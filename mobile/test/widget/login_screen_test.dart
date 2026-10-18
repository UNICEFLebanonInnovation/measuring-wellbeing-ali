import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:flutter_test/flutter_test.dart';
import 'package:measuring_wellbeing/app/app.dart';
import 'package:measuring_wellbeing/app/providers.dart';
import 'package:measuring_wellbeing/app/services.dart';
import 'package:measuring_wellbeing/data/local/preferences.dart';
import 'package:measuring_wellbeing/data/local/session_store.dart';
import 'package:measuring_wellbeing/services/location_service.dart';
import 'package:measuring_wellbeing/services/sync_service.dart';
import 'package:shared_preferences/shared_preferences.dart';

import '../helpers/fakes.dart';

Future<(ProviderContainer, FakeApi)> buildApp(WidgetTester tester) async {
  SharedPreferences.setMockInitialValues({});
  final api = FakeApi();
  final db = testDatabase();
  final services = AppServices(
    api: api,
    session: SessionStore(InMemoryKeyValue()),
    db: db,
    preferences: await Preferences.load(),
    sync: SyncService(api: api, db: db),
    location: LocationService(),
    version: '2.0.0+200',
  );
  final container = ProviderContainer(overrides: [servicesProvider.overrideWithValue(services), onlineProvider.overrideWith((ref) => Stream.value(true))]);
  addTearDown(container.dispose);
  addTearDown(db.close);
  await container.read(authProvider.notifier).restore();
  await tester.pumpWidget(UncontrolledProviderScope(container: container, child: const MeasuringWellbeingApp()));
  await tester.pumpAndSettle();
  return (container, api);
}

void main() {
  testWidgets('shows the sign-in screen and rejects a wrong password', (tester) async {
    await buildApp(tester);

    expect(find.byKey(const Key('login-submit')), findsOneWidget);
    await tester.enterText(find.byKey(const Key('login-email')), 'collector1@akkar.akkar');
    await tester.enterText(find.byKey(const Key('login-password')), 'wrong');
    await tester.tap(find.byKey(const Key('login-submit')));
    await tester.pumpAndSettle();

    expect(find.byKey(const Key('login-error')), findsOneWidget);
    expect(find.text('Email or password is incorrect.'), findsOneWidget);
  });

  testWidgets('signs in, stores the session and opens the dashboard', (tester) async {
    final (container, api) = await buildApp(tester);

    await tester.enterText(find.byKey(const Key('login-email')), 'collector1@akkar.akkar');
    await tester.enterText(find.byKey(const Key('login-password')), 'secret');
    await tester.tap(find.byKey(const Key('login-submit')));
    await tester.pumpAndSettle();

    expect(container.read(authProvider).signedIn, isTrue);
    expect(api.token, 'tok');
    expect(await container.read(servicesProvider).session.token(), 'tok');
    expect(find.byKey(const Key('new-application')), findsOneWidget);
    expect(find.byKey(const Key('sync-button')), findsOneWidget);
    expect(find.text('Pre-test (0)'), findsOneWidget);
  });

  testWidgets('switching to Arabic flips the layout to right-to-left', (tester) async {
    final (container, _) = await buildApp(tester);
    await container.read(localeProvider.notifier).set(const Locale('ar'));
    await tester.pumpAndSettle();

    expect(find.text('تسجيل الدخول'), findsWidgets);
    expect(Directionality.of(tester.element(find.byKey(const Key('login-submit')))), TextDirection.rtl);
  });
}
