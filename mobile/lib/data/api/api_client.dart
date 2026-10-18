import 'dart:io';

import 'package:dio/dio.dart';

import '../../core/config.dart';
import '../models/application_record.dart';
import '../models/reference_data.dart';
import '../models/user_profile.dart';

/// Error raised for every failed call so the UI can show one of a few messages.
class ApiException implements Exception {
  const ApiException(this.message, {this.statusCode, this.errors = const {}, this.isNetwork = false});

  final String message;
  final int? statusCode;

  /// Field → messages, from a `422` validation response.
  final Map<String, List<String>> errors;
  final bool isNetwork;

  bool get isUnauthorized => statusCode == 401;
  bool get isForbidden => statusCode == 403;
  bool get isValidation => statusCode == 422 && errors.isNotEmpty;

  @override
  String toString() => 'ApiException($statusCode): $message';
}

/// Result of `POST /auth/login`.
class LoginResult {
  const LoginResult({required this.token, required this.user});
  final String token;
  final UserProfile user;
}

/// One page of `GET /applications`.
class ApplicationPage {
  const ApplicationPage({required this.items, required this.currentPage, required this.lastPage});
  final List<ApplicationRecord> items;
  final int currentPage;
  final int lastPage;
  bool get hasMore => currentPage < lastPage;
}

/// Outcome of one item of `POST /sync`.
class SyncItemResult {
  const SyncItemResult({required this.clientUuid, required this.result, this.id, this.code, this.status, this.errors = const [], this.stages = const {}});

  final String clientUuid;
  final String result; // created | updated | skipped | error
  final int? id;
  final String? code;
  final String? status;
  final List<dynamic> errors;
  final Map<String, dynamic> stages;

  bool get isError => result == 'error';

  String stageResult(String stage) => (stages[stage] as Map<String, dynamic>?)?['result']?.toString() ?? 'skipped';

  /// Human readable summary of the errors for the record's `sync_error` column.
  String errorSummary() {
    final parts = <String>[];
    for (final e in errors) {
      if (e is Map) {
        e.forEach((field, msgs) {
          final text = msgs is List ? msgs.join(' ') : msgs.toString();
          parts.add('$field: $text');
        });
      } else {
        parts.add(e.toString());
      }
    }
    return parts.join('\n');
  }

  factory SyncItemResult.fromJson(Map<String, dynamic> json) => SyncItemResult(
    clientUuid: json['client_uuid'] as String,
    result: (json['result'] ?? 'error') as String,
    id: (json['id'] as num?)?.toInt(),
    code: json['code'] as String?,
    status: json['status'] as String?,
    errors: (json['errors'] as List?) ?? const [],
    stages: (json['stages'] as Map<String, dynamic>?) ?? const {},
  );
}

/// Reference payload with the ETag that identifies it; `null` data means "not modified".
class ReferenceResponse {
  const ReferenceResponse({this.data, required this.etag, required this.notModified});
  final ReferenceData? data;
  final String? etag;
  final bool notModified;
}

/// Thin typed wrapper over the v1 API. Not responsible for storage.
class ApiClient {
  ApiClient({Dio? dio, String? baseUrl, this.clientVersion = '2.0.0'}) : _dio = dio ?? Dio() {
    _dio.options
      ..connectTimeout = const Duration(seconds: 20)
      ..receiveTimeout = const Duration(seconds: 60)
      ..sendTimeout = const Duration(seconds: 60)
      ..responseType = ResponseType.json
      ..headers['Accept'] = 'application/json'
      ..validateStatus = (code) => code != null && code < 500;
    this.baseUrl = baseUrl ?? AppConfig.defaultBaseUrl;
  }

  final Dio _dio;
  final String clientVersion;
  String? _token;

  String get baseUrl => _dio.options.baseUrl.replaceFirst(RegExp(r'/api/v1/?$'), '');

  set baseUrl(String value) {
    _dio.options.baseUrl = normaliseBaseUrl(value) + AppConfig.apiPrefix;
  }

  String? get token => _token;

  set token(String? value) {
    _token = value;
    if (value == null) {
      _dio.options.headers.remove('Authorization');
    } else {
      _dio.options.headers['Authorization'] = 'Bearer $value';
    }
  }

  static String normaliseBaseUrl(String value) {
    var url = value.trim();
    if (url.isEmpty) url = AppConfig.defaultBaseUrl;
    if (!url.startsWith('http://') && !url.startsWith('https://')) url = 'https://$url';
    url = url.replaceFirst(RegExp(r'/+$'), '');
    url = url.replaceFirst(RegExp(r'/api(/v1)?$'), '');
    return url;
  }

  Map<String, dynamic> get _headers => {'X-Client-Version': '${AppConfig.clientName}/$clientVersion'};

  // ---- Auth ---------------------------------------------------------------

  Future<LoginResult> login({required String email, required String password, required String deviceName}) async {
    final data = await _request<Map<String, dynamic>>(
      () => _dio.post(
        '/auth/login',
        data: {'email': email, 'password': password, 'device_name': deviceName},
        options: Options(headers: _headers),
      ),
    );
    return LoginResult(token: data['token'] as String, user: UserProfile.fromJson(data['user'] as Map<String, dynamic>));
  }

  Future<void> logout() async {
    try {
      await _request<dynamic>(() => _dio.post('/auth/logout', options: Options(headers: _headers)));
    } on ApiException catch (e) {
      if (!e.isUnauthorized) rethrow;
    }
  }

  Future<UserProfile> me() async {
    final data = await _request<Map<String, dynamic>>(() => _dio.get('/auth/me', options: Options(headers: _headers)));
    return UserProfile.fromJson(data);
  }

  // ---- Reference ----------------------------------------------------------

  Future<ReferenceResponse> reference({String? etag}) async {
    final response = await _send(() => _dio.get('/reference', options: Options(headers: {..._headers, 'If-None-Match': ?etag})));
    if (response.statusCode == 304) {
      return ReferenceResponse(etag: etag, notModified: true);
    }
    final data = _unwrap<Map<String, dynamic>>(response);
    final ref = ReferenceData.fromJson(data);
    return ReferenceResponse(data: ref, etag: response.headers.value('etag') ?? ref.version, notModified: false);
  }

  // ---- Applications -------------------------------------------------------

  Future<ApplicationPage> applications({DateTime? updatedSince, int page = 1, int perPage = 100}) async {
    final response = await _send(
      () => _dio.get(
        '/applications',
        queryParameters: {'updated_since': ?updatedSince?.toUtc().toIso8601String(), 'page': page, 'per_page': perPage},
        options: Options(headers: _headers),
      ),
    );
    final body = _body(response);
    final items = ((body['data'] as List?) ?? const []).map((e) => ApplicationRecord.fromApi(e as Map<String, dynamic>)).toList();
    final meta = (body['meta'] as Map<String, dynamic>?) ?? const {};
    return ApplicationPage(
      items: items,
      currentPage: ((meta['current_page'] as num?) ?? page).toInt(),
      lastPage: ((meta['last_page'] as num?) ?? page).toInt(),
    );
  }

  Future<ApplicationRecord> application(int id) async {
    final data = await _request<Map<String, dynamic>>(() => _dio.get('/applications/$id', options: Options(headers: _headers)));
    return ApplicationRecord.fromApi(data);
  }

  Future<ApplicationRecord> createApplication({required String clientUuid, String? language}) async {
    final data = await _request<Map<String, dynamic>>(
      () => _dio.post(
        '/applications',
        data: {'client_uuid': clientUuid, 'language': ?language},
        options: Options(headers: _headers),
      ),
    );
    return ApplicationRecord.fromApi(data);
  }

  Future<ApplicationRecord> savePreTest(int id, Map<String, dynamic> body) async {
    final data = await _request<Map<String, dynamic>>(
      () => _dio.put(
        '/applications/$id/pre-test',
        data: body,
        options: Options(headers: _headers),
      ),
    );
    return ApplicationRecord.fromApi(data);
  }

  Future<ApplicationRecord> savePostTest(int id, Map<String, dynamic> body) async {
    final data = await _request<Map<String, dynamic>>(
      () => _dio.put(
        '/applications/$id/post-test',
        data: body,
        options: Options(headers: _headers),
      ),
    );
    return ApplicationRecord.fromApi(data);
  }

  Future<List<SyncItemResult>> sync(List<Map<String, dynamic>> applications) async {
    final data = await _request<Map<String, dynamic>>(
      () => _dio.post(
        '/sync',
        data: {'applications': applications},
        options: Options(headers: _headers),
      ),
    );
    return ((data['results'] as List?) ?? const []).map((e) => SyncItemResult.fromJson(e as Map<String, dynamic>)).toList();
  }

  // ---- Plumbing -----------------------------------------------------------

  Future<Response<dynamic>> _send(Future<Response<dynamic>> Function() call) async {
    try {
      final response = await call();
      if ((response.statusCode ?? 500) >= 400) throw _fromResponse(response);
      return response;
    } on DioException catch (e) {
      if (e.response != null) throw _fromResponse(e.response!);
      final network =
          e.type == DioExceptionType.connectionError ||
          e.type == DioExceptionType.connectionTimeout ||
          e.type == DioExceptionType.receiveTimeout ||
          e.type == DioExceptionType.sendTimeout ||
          e.error is SocketException;
      throw ApiException(e.message ?? 'Network error', isNetwork: network || e.error is HandshakeException);
    }
  }

  Future<T> _request<T>(Future<Response<dynamic>> Function() call) async {
    final response = await _send(call);
    return _unwrap<T>(response);
  }

  Map<String, dynamic> _body(Response<dynamic> response) {
    final data = response.data;
    if (data is Map<String, dynamic>) return data;
    throw ApiException('Unexpected response from the server', statusCode: response.statusCode);
  }

  T _unwrap<T>(Response<dynamic> response) {
    final body = _body(response);
    final data = body.containsKey('data') ? body['data'] : body;
    if (data is T) return data;
    throw ApiException('Unexpected response from the server', statusCode: response.statusCode);
  }

  ApiException _fromResponse(Response<dynamic> response) {
    final data = response.data;
    var message = 'HTTP ${response.statusCode}';
    final errors = <String, List<String>>{};
    if (data is Map<String, dynamic>) {
      if (data['message'] is String && (data['message'] as String).isNotEmpty) message = data['message'] as String;
      final raw = data['errors'];
      if (raw is Map<String, dynamic>) {
        raw.forEach((k, v) => errors[k] = v is List ? v.map((e) => e.toString()).toList() : [v.toString()]);
      }
    }
    return ApiException(message, statusCode: response.statusCode, errors: errors);
  }
}
