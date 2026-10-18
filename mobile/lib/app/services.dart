import 'package:package_info_plus/package_info_plus.dart';

import '../data/api/api_client.dart';
import '../data/local/app_database.dart';
import '../data/local/preferences.dart';
import '../data/local/session_store.dart';
import '../services/location_service.dart';
import '../services/sync_service.dart';

/// Everything with a lifetime of the whole process, built once at start-up.
class AppServices {
  AppServices({
    required this.api,
    required this.session,
    required this.db,
    required this.preferences,
    required this.sync,
    required this.location,
    required this.version,
  });

  final ApiClient api;
  final SessionStore session;
  final AppDatabase db;
  final Preferences preferences;
  final SyncService sync;
  final LocationService location;
  final String version;

  static Future<AppServices> bootstrap() async {
    final info = await PackageInfo.fromPlatform();
    final version = '${info.version}+${info.buildNumber}';
    final session = SessionStore(FlutterSecureKeyValue());
    final dbKey = await session.databaseKey();
    final db = AppDatabase(() => openEncryptedDatabase(dbKey));
    final api = ApiClient(baseUrl: await session.baseUrl(), clientVersion: version)..token = await session.token();
    return AppServices(
      api: api,
      session: session,
      db: db,
      preferences: await Preferences.load(),
      sync: SyncService(api: api, db: db),
      location: LocationService(),
      version: version,
    );
  }
}
