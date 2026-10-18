import 'dart:convert';
import 'dart:math';

import 'package:flutter/foundation.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';

import '../models/user_profile.dart';

/// Small key/value backend so the store can be swapped in tests.
abstract class SecureKeyValue {
  Future<String?> read(String key);
  Future<void> write(String key, String? value);
  Future<void> delete(String key);
}

/// Keystore-backed storage. If the encrypted-shared-preferences backend is
/// unusable on a device (corrupted keystore entry, vendor bugs) the plugin's
/// default backend is used instead, so the app still starts.
class FlutterSecureKeyValue implements SecureKeyValue {
  FlutterSecureKeyValue()
    : _primary = const FlutterSecureStorage(aOptions: AndroidOptions(encryptedSharedPreferences: true)),
      _fallback = const FlutterSecureStorage();

  final FlutterSecureStorage _primary;
  final FlutterSecureStorage _fallback;
  bool _useFallback = false;

  Future<T> _run<T>(Future<T> Function(FlutterSecureStorage s) action) async {
    if (!_useFallback) {
      try {
        return await action(_primary).timeout(const Duration(seconds: 10));
      } catch (e) {
        debugPrint('Secure storage (encrypted prefs) failed, using fallback: $e');
        _useFallback = true;
      }
    }
    return action(_fallback).timeout(const Duration(seconds: 10));
  }

  @override
  Future<String?> read(String key) => _run((s) => s.read(key: key));

  @override
  Future<void> write(String key, String? value) => _run((s) => value == null ? s.delete(key: key) : s.write(key: key, value: value));

  @override
  Future<void> delete(String key) => _run((s) => s.delete(key: key));
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
