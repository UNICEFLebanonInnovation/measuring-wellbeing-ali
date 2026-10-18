import '../data/models/application_record.dart';
import 'sdq_catalog.dart';

/// Mirrors the server-side rules of `App\Http\Requests\TestRequest` so
/// problems are caught on the device before a sync. Keys are field names;
/// values are error codes resolved to translated messages by the UI.
class TestValidator {
  const TestValidator({required this.isPostTest});

  final bool isPostTest;

  static const String required = 'required';
  static const String number = 'number';
  static const String ageRange = 'age_range';
  static const String latitude = 'latitude';
  static const String longitude = 'longitude';

  static (int, int) ageRangeFor(String? form) => form == 'Form 12-17' ? (12, 17) : (6, 11);

  Map<String, String> validate(TestData data, {required bool submitting}) {
    final errors = <String, String>{};
    final f = data.fields;

    String? s(String key) {
      final v = f[key];
      if (v == null) return null;
      final t = v.toString().trim();
      return t.isEmpty ? null : t;
    }

    void need(String key) {
      if (s(key) == null) errors[key] = required;
    }

    need('form');
    need('may_i_start_now');
    if (!data.consentGiven) return errors;

    for (final key in [
      'category',
      'agency_name',
      'donor_name',
      'interview_date',
      'interviewers_name',
      'gender',
      'nationality',
      'gouvarnate',
      'caza',
      'area',
      'gateway_type',
    ]) {
      need(key);
    }
    if (s('nationality') == 'Other Nationality') need('other_nationality');

    final age = int.tryParse(s('age') ?? '');
    if (age == null) {
      errors['age'] = s('age') == null ? required : number;
    } else {
      final (min, max) = ageRangeFor(s('form'));
      if (age < min || age > max) errors['age'] = ageRange;
    }

    final lat = s('latitude');
    if (lat != null) {
      final v = double.tryParse(lat);
      if (v == null || v < -90 || v > 90) errors['latitude'] = latitude;
    }
    final lng = s('longitude');
    if (lng != null) {
      final v = double.tryParse(lng);
      if (v == null || v < -180 || v > 180) errors['longitude'] = longitude;
    }

    if (submitting) {
      for (final item in sdqItems) {
        final v = s(item.key)?.toLowerCase();
        if (v == null || !{'0', '1', '2', 'na'}.contains(v)) errors[item.key] = required;
      }
    }

    if (isPostTest) {
      if (submitting) {
        need('dropout_reason');
        for (final key in ['number_of_hours_that_the_child_attended', 'total_number_of_hours_in_your_program']) {
          final v = s(key);
          if (v == null) {
            errors[key] = required;
          } else if (double.tryParse(v) == null || double.parse(v) < 0) {
            errors[key] = number;
          }
        }
      }
      final reason = s('dropout_reason');
      if (reason != null && reason != didNotDropOut && s('justify_the_dropout_reason') == null) {
        errors['justify_the_dropout_reason'] = required;
      }
    }

    return errors;
  }
}
