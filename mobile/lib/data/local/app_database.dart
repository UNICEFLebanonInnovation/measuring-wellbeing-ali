import 'package:path/path.dart' as p;
import 'package:sqflite_sqlcipher/sqflite.dart';

import '../models/application_record.dart';

/// Opens the encrypted SQLite file. Tests pass their own opener (ffi, unencrypted).
typedef DatabaseOpener = Future<Database> Function();

Future<Database> openEncryptedDatabase(String password) async {
  final dir = await getDatabasesPath();
  return openDatabase(
    p.join(dir, 'measuring_wellbeing.db'),
    password: password,
    version: AppDatabase.schemaVersion,
    onCreate: (db, _) => AppDatabase.createSchema(db),
    onUpgrade: (db, from, to) => AppDatabase.upgradeSchema(db, from, to),
  );
}

/// Offline store: every application the collector works on plus small
/// metadata values (reference cache, last sync, ...).
class AppDatabase {
  AppDatabase(this._open);

  static const schemaVersion = 1;

  final DatabaseOpener _open;
  Database? _db;

  Future<Database> get db async => _db ??= await _open();

  static Future<void> createSchema(Database db) async {
    await db.execute('''
      CREATE TABLE applications (
        client_uuid TEXT PRIMARY KEY,
        server_id INTEGER,
        code TEXT,
        status TEXT NOT NULL,
        status_id INTEGER,
        year INTEGER,
        language TEXT,
        pre_json TEXT,
        post_json TEXT,
        pre_pending TEXT,
        post_pending TEXT,
        sync_error TEXT,
        pre_test_date TEXT,
        post_test_date TEXT,
        server_updated_at TEXT,
        updated_at TEXT NOT NULL,
        created_at TEXT NOT NULL
      )
    ''');
    await db.execute('CREATE INDEX applications_server_id ON applications(server_id)');
    await db.execute('CREATE INDEX applications_code ON applications(code)');
    await db.execute('CREATE TABLE meta (key TEXT PRIMARY KEY, value TEXT)');
  }

  static Future<void> upgradeSchema(Database db, int from, int to) async {
    // Nothing yet: schema 1 is the first release.
  }

  Future<void> close() async {
    await _db?.close();
    _db = null;
  }

  // ---- meta ---------------------------------------------------------------

  Future<String?> meta(String key) async {
    final rows = await (await db).query('meta', where: 'key = ?', whereArgs: [key], limit: 1);
    return rows.isEmpty ? null : rows.first['value'] as String?;
  }

  Future<void> setMeta(String key, String? value) async {
    final d = await db;
    if (value == null) {
      await d.delete('meta', where: 'key = ?', whereArgs: [key]);
    } else {
      await d.insert('meta', {'key': key, 'value': value}, conflictAlgorithm: ConflictAlgorithm.replace);
    }
  }

  // ---- applications -------------------------------------------------------

  Future<List<ApplicationRecord>> allApplications() async {
    final rows = await (await db).query('applications', orderBy: 'updated_at DESC');
    return rows.map(ApplicationRecord.fromRow).toList();
  }

  Future<ApplicationRecord?> application(String clientUuid) async {
    final rows = await (await db).query('applications', where: 'client_uuid = ?', whereArgs: [clientUuid], limit: 1);
    return rows.isEmpty ? null : ApplicationRecord.fromRow(rows.first);
  }

  Future<ApplicationRecord?> applicationByServerId(int id) async {
    final rows = await (await db).query('applications', where: 'server_id = ?', whereArgs: [id], limit: 1);
    return rows.isEmpty ? null : ApplicationRecord.fromRow(rows.first);
  }

  Future<List<ApplicationRecord>> pendingApplications() async {
    final rows = await (await db).query('applications', where: 'pre_pending IS NOT NULL OR post_pending IS NOT NULL', orderBy: 'created_at ASC');
    return rows.map(ApplicationRecord.fromRow).toList();
  }

  Future<int> pendingCount() async {
    final rows = await (await db).rawQuery('SELECT COUNT(*) AS c FROM applications WHERE pre_pending IS NOT NULL OR post_pending IS NOT NULL');
    return (rows.first['c'] as int?) ?? 0;
  }

  Future<void> upsert(ApplicationRecord record) async {
    record.updatedAt = DateTime.now();
    await (await db).insert('applications', record.toRow(), conflictAlgorithm: ConflictAlgorithm.replace);
  }

  Future<void> delete(String clientUuid) async {
    await (await db).delete('applications', where: 'client_uuid = ?', whereArgs: [clientUuid]);
  }

  /// Wipe everything (sign out of a different account).
  Future<void> clearAll() async {
    final d = await db;
    await d.delete('applications');
    await d.delete('meta');
  }
}
