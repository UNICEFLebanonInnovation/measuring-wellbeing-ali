import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';

import 'app/app.dart';
import 'app/providers.dart';
import 'app/services.dart';

Future<void> main() async {
  WidgetsFlutterBinding.ensureInitialized();
  final services = await AppServices.bootstrap();
  final container = ProviderContainer(overrides: [servicesProvider.overrideWithValue(services)]);
  await container.read(authProvider.notifier).restore();
  runApp(UncontrolledProviderScope(container: container, child: const MeasuringWellbeingApp()));
}
