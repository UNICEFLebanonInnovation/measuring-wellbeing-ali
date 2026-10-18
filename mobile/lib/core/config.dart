/// Build-time configuration. Override with
/// `flutter build apk --dart-define=API_BASE_URL=https://staging.example.org`.
class AppConfig {
  const AppConfig._();

  /// Default server. The user can change it on the sign-in screen.
  static const String defaultBaseUrl = String.fromEnvironment('API_BASE_URL', defaultValue: 'https://measuringwellbeing.org');

  static const String apiPrefix = '/api/v1';

  /// Sent as the `X-Client-Version` header on every request.
  static const String clientName = 'measuring-wellbeing-android';

  /// Number of applications uploaded per sync request (server limit is 200).
  static const int syncBatchSize = 50;

  /// Server rule mirrored locally for the warning in the questionnaire.
  static const int maxNaAnswers = 3;
}
