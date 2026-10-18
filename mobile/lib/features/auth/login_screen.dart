import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../app/providers.dart';
import '../../core/config.dart';
import '../../core/theme.dart';
import '../../data/api/api_client.dart';
import '../shared/l10n_ext.dart';

class LoginScreen extends ConsumerStatefulWidget {
  const LoginScreen({super.key});

  @override
  ConsumerState<LoginScreen> createState() => _LoginScreenState();
}

class _LoginScreenState extends ConsumerState<LoginScreen> {
  final _formKey = GlobalKey<FormState>();
  final _email = TextEditingController();
  final _password = TextEditingController();
  late final TextEditingController _server;
  bool _busy = false;
  bool _showServer = false;
  bool _obscure = true;
  String? _error;

  @override
  void initState() {
    super.initState();
    _server = TextEditingController(text: ref.read(authProvider).baseUrl ?? AppConfig.defaultBaseUrl);
  }

  @override
  void dispose() {
    _email.dispose();
    _password.dispose();
    _server.dispose();
    super.dispose();
  }

  Future<void> _submit() async {
    if (!_formKey.currentState!.validate()) return;
    setState(() {
      _busy = true;
      _error = null;
    });
    final l10n = context.l10n;
    try {
      await ref.read(authProvider.notifier).signIn(email: _email.text.trim(), password: _password.text, baseUrl: _server.text);
      // First download of reference data and applications; errors are shown on the dashboard.
      ref.read(syncProvider.notifier).run(fullPull: true);
    } on ApiException catch (e) {
      setState(() {
        _error = e.isUnauthorized
            ? (e.message.toLowerCase().contains('inactive') ? l10n.accountInactive : l10n.invalidCredentials)
            : e.isNetwork
            ? l10n.networkError
            : l10n.unexpectedError(e.message);
      });
    } catch (e) {
      setState(() => _error = l10n.unexpectedError(e.toString()));
    } finally {
      if (mounted) setState(() => _busy = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    final l10n = context.l10n;
    return Scaffold(
      body: SafeArea(
        child: Center(
          child: SingleChildScrollView(
            padding: const EdgeInsets.all(24),
            child: ConstrainedBox(
              constraints: const BoxConstraints(maxWidth: 420),
              child: Form(
                key: _formKey,
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.stretch,
                  children: [
                    Image.asset('assets/images/logo.png', height: 96),
                    const SizedBox(height: 16),
                    Text(
                      l10n.appName,
                      textAlign: TextAlign.center,
                      style: Theme.of(context).textTheme.headlineSmall?.copyWith(color: BrandColors.blueDark, fontWeight: FontWeight.w700),
                    ),
                    const SizedBox(height: 4),
                    Text(
                      l10n.signInSubtitle,
                      textAlign: TextAlign.center,
                      style: const TextStyle(color: BrandColors.slate),
                    ),
                    const SizedBox(height: 24),
                    TextFormField(
                      key: const Key('login-email'),
                      controller: _email,
                      keyboardType: TextInputType.emailAddress,
                      autocorrect: false,
                      textInputAction: TextInputAction.next,
                      decoration: InputDecoration(labelText: l10n.email, prefixIcon: const Icon(Icons.mail_outline)),
                      validator: (v) => (v == null || !v.contains('@')) ? l10n.required : null,
                    ),
                    const SizedBox(height: 12),
                    TextFormField(
                      key: const Key('login-password'),
                      controller: _password,
                      obscureText: _obscure,
                      textInputAction: TextInputAction.done,
                      onFieldSubmitted: (_) => _submit(),
                      decoration: InputDecoration(
                        labelText: l10n.password,
                        prefixIcon: const Icon(Icons.lock_outline),
                        suffixIcon: IconButton(
                          icon: Icon(_obscure ? Icons.visibility_outlined : Icons.visibility_off_outlined),
                          onPressed: () => setState(() => _obscure = !_obscure),
                        ),
                      ),
                      validator: (v) => (v == null || v.isEmpty) ? l10n.required : null,
                    ),
                    if (_showServer) ...[
                      const SizedBox(height: 12),
                      TextFormField(
                        key: const Key('login-server'),
                        controller: _server,
                        keyboardType: TextInputType.url,
                        autocorrect: false,
                        decoration: InputDecoration(labelText: l10n.serverUrl, helperText: l10n.serverUrlHelp, prefixIcon: const Icon(Icons.dns_outlined)),
                      ),
                    ],
                    if (_error != null) ...[
                      const SizedBox(height: 12),
                      Text(
                        _error!,
                        key: const Key('login-error'),
                        style: const TextStyle(color: BrandColors.red),
                      ),
                    ],
                    const SizedBox(height: 20),
                    FilledButton(key: const Key('login-submit'), onPressed: _busy ? null : _submit, child: Text(_busy ? l10n.signingIn : l10n.signIn)),
                    TextButton(onPressed: () => setState(() => _showServer = !_showServer), child: Text(l10n.serverUrl)),
                    const SizedBox(height: 8),
                    _LanguageToggle(),
                  ],
                ),
              ),
            ),
          ),
        ),
      ),
    );
  }
}

class _LanguageToggle extends ConsumerWidget {
  @override
  Widget build(BuildContext context, WidgetRef ref) {
    final l10n = context.l10n;
    final current = ref.watch(localeProvider)?.languageCode ?? Localizations.localeOf(context).languageCode;
    return SegmentedButton<String>(
      segments: [
        ButtonSegment(value: 'en', label: Text(l10n.english)),
        ButtonSegment(value: 'ar', label: Text(l10n.arabic)),
      ],
      selected: {current},
      onSelectionChanged: (s) => ref.read(localeProvider.notifier).set(Locale(s.first)),
    );
  }
}
