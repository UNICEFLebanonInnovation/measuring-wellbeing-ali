import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:go_router/go_router.dart';

import '../features/application/application_detail_screen.dart';
import '../features/application/test_form_screen.dart';
import '../features/auth/login_screen.dart';
import '../features/dashboard/dashboard_screen.dart';
import '../features/settings/settings_screen.dart';
import 'providers.dart';

/// Rebuilds the router's redirect whenever the auth state changes.
class _AuthListenable extends ChangeNotifier {
  _AuthListenable(Ref ref) {
    ref.listen(authProvider, (_, _) => notifyListeners());
  }
}

final routerProvider = Provider<GoRouter>((ref) {
  final listenable = _AuthListenable(ref);
  ref.onDispose(listenable.dispose);
  return GoRouter(
    initialLocation: '/',
    refreshListenable: listenable,
    redirect: (context, state) {
      final auth = ref.read(authProvider);
      if (!auth.restored) return null;
      final onLogin = state.matchedLocation == '/login';
      if (!auth.signedIn) return onLogin ? null : '/login';
      if (onLogin) return '/';
      return null;
    },
    routes: [
      GoRoute(path: '/login', builder: (_, _) => const LoginScreen()),
      GoRoute(path: '/', builder: (_, _) => const DashboardScreen()),
      GoRoute(path: '/settings', builder: (_, _) => const SettingsScreen()),
      GoRoute(
        path: '/applications/:uuid',
        builder: (_, state) => ApplicationDetailScreen(clientUuid: state.pathParameters['uuid']!),
        routes: [
          GoRoute(
            path: 'pre-test',
            builder: (_, state) => TestFormScreen(clientUuid: state.pathParameters['uuid']!, isPostTest: false),
          ),
          GoRoute(
            path: 'post-test',
            builder: (_, state) => TestFormScreen(clientUuid: state.pathParameters['uuid']!, isPostTest: true),
          ),
        ],
      ),
    ],
  );
});
