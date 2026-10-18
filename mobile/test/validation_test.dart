import 'package:flutter_test/flutter_test.dart';
import 'package:measuring_wellbeing/data/models/application_record.dart';
import 'package:measuring_wellbeing/domain/sdq_catalog.dart';
import 'package:measuring_wellbeing/domain/validation.dart';

TestData completePreTest() {
  final data = TestData(
    fields: {
      'form': 'Form 6-11',
      'may_i_start_now': 'yes',
      'category': 'Child Labour Activity',
      'agency_name': 'UNICEF',
      'donor_name': 'UNICEF',
      'interview_date': '2026-03-10',
      'interviewers_name': 'Rana',
      'gender': 'female',
      'nationality': 'Syrian',
      'gouvarnate': '1',
      'caza': '3',
      'area': '3',
      'gateway_type': 'Informal settlement',
      'age': '8',
    },
  );
  for (final item in sdqItems) {
    data.fields[item.key] = '1';
  }
  return data;
}

void main() {
  const pre = TestValidator(isPostTest: false);
  const post = TestValidator(isPostTest: true);

  test('a complete pre-test passes on submit', () {
    expect(pre.validate(completePreTest(), submitting: true), isEmpty);
  });

  test('consent refused needs nothing else', () {
    final data = TestData(fields: {'form': 'Form 6-11', 'may_i_start_now': 'no'});
    expect(pre.validate(data, submitting: true), isEmpty);
  });

  test('draft save does not require the answers', () {
    final data = completePreTest();
    for (final item in sdqItems) {
      data.fields.remove(item.key);
    }
    expect(pre.validate(data, submitting: false), isEmpty);
    final errors = pre.validate(data, submitting: true);
    expect(errors.length, sdqItems.length);
    expect(errors.values.toSet(), {TestValidator.required});
  });

  test('age must match the form', () {
    final data = completePreTest()..fields['age'] = '14';
    expect(pre.validate(data, submitting: true)['age'], TestValidator.ageRange);
    data.fields['form'] = 'Form 12-17';
    expect(pre.validate(data, submitting: true)['age'], isNull);
    data.fields['age'] = 'abc';
    expect(pre.validate(data, submitting: true)['age'], TestValidator.number);
  });

  test('other nationality must be spelled out', () {
    final data = completePreTest()..fields['nationality'] = 'Other Nationality';
    expect(pre.validate(data, submitting: true)['other_nationality'], TestValidator.required);
  });

  test('GPS values are range checked', () {
    final data = completePreTest()
      ..fields['latitude'] = '95'
      ..fields['longitude'] = 'x';
    final errors = pre.validate(data, submitting: false);
    expect(errors['latitude'], TestValidator.latitude);
    expect(errors['longitude'], TestValidator.longitude);
  });

  test('post-test submit needs programme hours and a dropout reason', () {
    final data = completePreTest();
    final errors = post.validate(data, submitting: true);
    expect(errors.keys, containsAll(['dropout_reason', 'number_of_hours_that_the_child_attended', 'total_number_of_hours_in_your_program']));

    data.fields['dropout_reason'] = 'Returned to Syria';
    data.fields['number_of_hours_that_the_child_attended'] = '10';
    data.fields['total_number_of_hours_in_your_program'] = '20';
    expect(post.validate(data, submitting: true), {'justify_the_dropout_reason': TestValidator.required});

    data.fields['justify_the_dropout_reason'] = 'Family left';
    expect(post.validate(data, submitting: true), isEmpty);
  });

  test('toApi drops empty values and sets the submit flag', () {
    final data = TestData(fields: {'form': 'Form 6-11', 'comment': '', 'p_code': null});
    expect(data.toApi(action: PendingAction.save), {'form': 'Form 6-11', 'submit': 'save'});
    expect(data.toApi(action: PendingAction.submit)['submit'], 'submit');
  });
}
