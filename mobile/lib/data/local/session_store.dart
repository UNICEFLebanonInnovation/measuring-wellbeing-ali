import 'dart:convert';
import 'dart:math';

import 'package:flutter_secure_storage/flutter_secure_storage.dart';

import '../models/user_profile.dart';

/// Small key/value backend so the store can be swapped in tests.
abstract class SecureKeyValue {
  Future<String?> read(String key);
  Future<void> write(String key, String? value);
  Future<void> delete(String key);
}

class FlutterSecureKeyValue implements SecureKeyValue {
  FlutterSecureKeyValue() : _storage = const FlutterSecureStorage(aOptions: AndroidOptions(encryptedSharedPreferences: true));

  final FlutterSecureStorage _storage;

  @override
  Future<String?> read(String key) => _storage.read(key: key);

  @override
  Future<void> write(String key, String? value) => value == null ? _storage.delete(key: key) : _storage.write(key: key, value: value);

  @override
  Future<void> delete(String key) => _storage.delete(key: key);
}

class InMemoryKeyValue implements SecureKeyValue {
  final Map<String, String> _values = {};

  @override
  Future<String?> read(String key) async => _values[key];

  @override
  Future<void> write(String key, String? value) async => value == null ? _values.remove(key) : _values[key] = value;

  @override
  Future<void> delete(String key) async => _values.remove(key);
}

/// Session information kept in the Android keystore-backed secure storage:
/// the API token, the signed-in user, the server address and the key that
/// encrypts the local database.
class SessionStore {
  SessionStore(this._kv);

  final SecureKeyValue _kv;

  static const _token = 'api_token';
  static const _user = 'user_profile';
  static const _baseUrl = 'base_url';
  static const _dbKey = 'db_key';

  Future<String?> token() => _kv.read(_token);
  Future<void> saveToken(String? value) => _kv.write(_token, value);

  Future<UserProfile?> user() async {
    final raw = await _kv.read(_user);
    if (raw == null) return null;
    return UserProfile.fromJson(jsonDecode(raw) as Map<String, dynamic>);
  }

  Future<void> saveUser(UserProfile? user) => _kv.write(_user, user == null ? null : jsonEncode(user.toJson()));

  Future<String?> baseUrl() => _kv.read(_baseUrl);
  Future<void> saveBaseUrl(String value) => _kv.write(_baseUrl, value);

  /// Random key for SQLCipher, generated on first use and never leaving the device.
  Future<String> databaseKey() async {
    final existing = await _kv.read(_dbKey);
    if (existing != null) return existing;
    final random = Random.secure();
    final bytes = List<int>.generate(32, (_) => random.nextInt(256));
    final key = base64UrlEncode(bytes);
    await _kv.write(_dbKey, key);
    return key;
  }

  /// Forget the token and user but keep the database key and server address.
  Future<void> clearSession() async {
    await _kv.delete(_token);
    await _kv.delete(_user);
  }
}
