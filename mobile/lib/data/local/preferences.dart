import 'package:shared_preferences/shared_preferences.dart';

/// Non-sensitive per-device settings.
class Preferences {
  Preferences(this._prefs);

  final SharedPreferences _prefs;

  static const _locale = 'locale';

  static Future<Preferences> load() async => Preferences(await SharedPreferences.getInstance());

  String? get locale => _prefs.getString(_locale);

  Future<void> setLocale(String? code) => code == null ? _prefs.remove(_locale) : _prefs.setString(_locale, code);
}
