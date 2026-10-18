import 'dart:async';

import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';

import 'app/app.dart';
import 'app/providers.dart';
import 'app/services.dart';
import 'core/theme.dart';

void main() {
  runZonedGuarded(
    () {
      WidgetsFlutterBinding.ensureInitialized();
      FlutterError.onError = (details) {
        FlutterError.presentError(details);
        debugPrint('Flutter error: ${details.exceptionAsString()}');
      };
      runApp(const BootstrapApp());
    },
    (error, stack) {
      debugPrint('Uncaught error: $error\n$stack');
    },
  );
}

/// Shown while the services start. Start-up problems (secure storage,
/// database, package info) are displayed instead of leaving the splash screen.
class BootstrapApp extends StatefulWidget {
  const BootstrapApp({super.key});

  @override
  State<BootstrapApp> createState() => _BootstrapAppState();
}

class _BootstrapAppState extends State<BootstrapApp> {
  ProviderContainer? _container;
  Object? _error;

  @override
  void initState() {
    super.initState();
    _start();
  }

  Future<void> _start() async {
    setState(() => _error = null);
    try {
      final services = await AppServices.bootstrap().timeout(const Duration(seconds: 30));
      final container = ProviderContainer(overrides: [servicesProvider.overrideWithValue(services)]);
      await container.read(authProvider.notifier).restore().timeout(const Duration(seconds: 15));
      if (!mounted) return;
      setState(() => _container = container);
    } catch (e, s) {
      debugPrint('Start-up failed: $e\n$s');
      if (mounted) setState(() => _error = e);
    }
  }

  @override
  Widget build(BuildContext context) {
    final container = _container;
    if (container != null) {
      return UncontrolledProviderScope(container: container, child: const MeasuringWellbeingApp());
    }
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      theme: buildTheme(),
      home: Scaffold(
        body: Center(
          child: Padding(
            padding: const EdgeInsets.all(32),
            child: Column(
              mainAxisSize: MainAxisSize.min,
              children: [
                Image.asset('assets/images/logo.png', height: 96),
                const SizedBox(height: 24),
                if (_error == null) ...[
                  const CircularProgressIndicator(),
                  const SizedBox(height: 12),
                  const Text('Starting…', style: TextStyle(color: BrandColors.slate)),
                ] else ...[
                  const Text(
                    'The application could not start',
                    style: TextStyle(fontWeight: FontWeight.w700, color: BrandColors.red),
                  ),
                  const SizedBox(height: 8),
                  Text(
                    '$_error',
                    textAlign: TextAlign.center,
                    style: const TextStyle(fontSize: 12, color: BrandColors.slate),
                  ),
                  const SizedBox(height: 16),
                  FilledButton(onPressed: _start, child: const Text('Retry')),
                ],
              ],
            ),
          ),
        ),
      ),
    );
  }
}
