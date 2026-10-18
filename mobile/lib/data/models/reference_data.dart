/// Reference data from `/api/v1/reference`: locations, statuses, forms and option lists.
class ReferenceData {
  const ReferenceData({
    required this.version,
    required this.governorates,
    required this.statuses,
    required this.forms,
    required this.items,
    required this.maxNaAnswers,
    required this.raw,
  });

  final String version;
  final List<Governorate> governorates;
  final List<NamedRow> statuses;
  final List<String> forms;

  /// The 25 item keys in questionnaire order, as the server expects them.
  final List<String> items;
  final int maxNaAnswers;

  /// The payload as received, kept so the cache can be re-created without a round trip.
  final Map<String, dynamic> raw;

  factory ReferenceData.fromJson(Map<String, dynamic> json) {
    final options = (json['options'] as Map<String, dynamic>?) ?? const {};
    final scoring = (json['scoring'] as Map<String, dynamic>?) ?? const {};
    return ReferenceData(
      version: (json['version'] ?? '') as String,
      governorates: ((json['governorates'] as List?) ?? const []).map((g) => Governorate.fromJson(g as Map<String, dynamic>)).toList(),
      statuses: ((json['statuses'] as List?) ?? const []).map((s) => NamedRow.fromJson(s as Map<String, dynamic>)).toList(),
      forms: ((options['forms'] as List?) ?? const ['Form 6-11', 'Form 12-17']).map((e) => e.toString()).toList(),
      items: ((options['items'] as List?) ?? const []).map((e) => e.toString()).toList(),
      maxNaAnswers: ((scoring['max_na_answers'] as num?) ?? 3).toInt(),
      raw: json,
    );
  }

  Governorate? governorate(String? id) => id == null ? null : governorates.cast<Governorate?>().firstWhere((g) => g!.id.toString() == id, orElse: () => null);

  Caza? caza(String? governorateId, String? cazaId) =>
      governorate(governorateId)?.cazas.cast<Caza?>().firstWhere((c) => c!.id.toString() == cazaId, orElse: () => null);

  Area? area(String? governorateId, String? cazaId, String? areaId) =>
      caza(governorateId, cazaId)?.areas.cast<Area?>().firstWhere((a) => a!.id.toString() == areaId, orElse: () => null);
}

class NamedRow {
  const NamedRow({required this.id, required this.name, this.arabic});

  final int id;
  final String name;
  final String? arabic;

  String label(bool arabic) => arabic && (this.arabic ?? '').isNotEmpty ? this.arabic! : name;

  factory NamedRow.fromJson(Map<String, dynamic> json) =>
      NamedRow(id: (json['id'] as num).toInt(), name: (json['name'] ?? '') as String, arabic: json['arabic'] as String?);
}

class Governorate extends NamedRow {
  const Governorate({required super.id, required super.name, super.arabic, required this.cazas});

  final List<Caza> cazas;

  factory Governorate.fromJson(Map<String, dynamic> json) => Governorate(
    id: (json['id'] as num).toInt(),
    name: (json['name'] ?? '') as String,
    arabic: json['arabic'] as String?,
    cazas: ((json['cazas'] as List?) ?? const []).map((c) => Caza.fromJson(c as Map<String, dynamic>)).toList(),
  );
}

class Caza extends NamedRow {
  const Caza({required super.id, required super.name, super.arabic, required this.areas});

  final List<Area> areas;

  factory Caza.fromJson(Map<String, dynamic> json) => Caza(
    id: (json['id'] as num).toInt(),
    name: (json['name'] ?? '') as String,
    arabic: json['arabic'] as String?,
    areas: ((json['areas'] as List?) ?? const []).map((a) => Area.fromJson(a as Map<String, dynamic>)).toList(),
  );
}

class Area extends NamedRow {
  const Area({required super.id, required super.name, super.arabic});

  factory Area.fromJson(Map<String, dynamic> json) =>
      Area(id: (json['id'] as num).toInt(), name: (json['name'] ?? '') as String, arabic: json['arabic'] as String?);
}
