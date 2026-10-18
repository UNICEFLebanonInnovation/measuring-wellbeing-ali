import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../app/providers.dart';
import '../../core/theme.dart';
import '../shared/l10n_ext.dart';

class SettingsScreen extends ConsumerWidget {
  const SettingsScreen({super.key});

  @override
  Widget build(BuildContext context, WidgetRef ref) {
    final l10n = context.l10n;
    final auth = ref.watch(authProvider);
    final services = ref.watch(servicesProvider);
    final current = ref.watch(localeProvider)?.languageCode ?? Localizations.localeOf(context).languageCode;
    final sync = ref.watch(syncProvider);

    return Scaffold(
      appBar: AppBar(title: Text(l10n.settings)),
      body: ListView(
        children: [
          if (auth.user != null)
            ListTile(
              leading: const CircleAvatar(
                backgroundColor: BrandColors.blueLight,
                child: Icon(Icons.person, color: BrandColors.blueDark),
              ),
              title: Text(l10n.signedInAs(auth.user!.name, auth.user!.partnerName ?? '')),
              subtitle: Text('${auth.user!.email}\n${auth.baseUrl ?? ''}'),
              isThreeLine: true,
            ),
          const Divider(),
          ListTile(leading: const Icon(Icons.language), title: Text(l10n.language)),
          RadioGroup<String>(
            groupValue: current,
            onChanged: (v) => ref.read(localeProvider.notifier).set(v == null ? null : Locale(v)),
            child: Column(
              children: [
                RadioListTile<String>(value: 'en', title: Text(l10n.english)),
                RadioListTile<String>(value: 'ar', title: Text(l10n.arabic)),
              ],
            ),
          ),
          const Divider(),
          ListTile(
            leading: const Icon(Icons.sync),
            title: Text(l10n.syncNow),
            subtitle: Text('${l10n.pendingSync}: ${sync.pendingCount}'),
            trailing: sync.running ? const SizedBox(width: 20, height: 20, child: CircularProgressIndicator(strokeWidth: 2)) : null,
            onTap: sync.running ? null : () => ref.read(syncProvider.notifier).run(fullPull: true),
          ),
          const Divider(),
          ListTile(
            leading: const Icon(Icons.logout, color: BrandColors.red),
            title: Text(l10n.signOut, style: const TextStyle(color: BrandColors.red)),
            onTap: () => _signOut(context, ref),
          ),
          const Divider(),
          ListTile(leading: const Icon(Icons.info_outline), title: Text(l10n.version(services.version))),
        ],
      ),
    );
  }

  Future<void> _signOut(BuildContext context, WidgetRef ref) async {
    final l10n = context.l10n;
    final ok = await showDialog<bool>(
      context: context,
      builder: (ctx) => AlertDialog(
        title: Text(l10n.signOut),
        content: Text(l10n.signOutConfirm),
        actions: [
          TextButton(onPressed: () => Navigator.pop(ctx, false), child: Text(l10n.cancel)),
          FilledButton(onPressed: () => Navigator.pop(ctx, true), child: Text(l10n.signOut)),
        ],
      ),
    );
    if (ok == true) await ref.read(authProvider.notifier).signOut();
  }
}
