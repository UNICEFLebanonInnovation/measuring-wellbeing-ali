/// The signed-in collector or partner as returned by `/api/v1/auth/login` and `/auth/me`.
class UserProfile {
  const UserProfile({
    required this.id,
    required this.name,
    required this.email,
    required this.roles,
    required this.isReadOnly,
    this.locale,
    this.partnerName,
    this.partnerPrefix,
    this.collectorPrefix,
  });

  final int id;
  final String name;
  final String email;
  final List<String> roles;
  final bool isReadOnly;
  final String? locale;
  final String? partnerName;
  final String? partnerPrefix;
  final String? collectorPrefix;

  bool get isCollector => roles.contains('collector');

  factory UserProfile.fromJson(Map<String, dynamic> json) {
    final partner = json['partner'] as Map<String, dynamic>?;
    final collector = json['collector'] as Map<String, dynamic>?;
    return UserProfile(
      id: (json['id'] as num).toInt(),
      name: (json['name'] ?? '') as String,
      email: (json['email'] ?? '') as String,
      roles: ((json['roles'] as List?) ?? const []).map((e) => e.toString()).toList(),
      isReadOnly: json['is_readonly'] == true,
      locale: json['locale'] as String?,
      partnerName: partner?['name'] as String?,
      partnerPrefix: partner?['prefix'] as String?,
      collectorPrefix: collector?['prefix'] as String?,
    );
  }

  Map<String, dynamic> toJson() => {
    'id': id,
    'name': name,
    'email': email,
    'roles': roles,
    'is_readonly': isReadOnly,
    'locale': locale,
    'partner': {'name': partnerName, 'prefix': partnerPrefix},
    'collector': {'prefix': collectorPrefix},
  };
}
