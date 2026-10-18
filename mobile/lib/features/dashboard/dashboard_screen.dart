import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:go_router/go_router.dart';
import 'package:intl/intl.dart';

import '../../app/providers.dart';
import '../../core/theme.dart';
import '../../data/models/application_record.dart';
import '../../domain/application_status.dart';
import '../shared/l10n_ext.dart';
import '../shared/widgets.dart';

class DashboardScreen extends ConsumerStatefulWidget {
  const DashboardScreen({super.key});

  @override
  ConsumerState<DashboardScreen> createState() => _DashboardScreenState();
}

class _DashboardScreenState extends ConsumerState<DashboardScreen> {
  String _query = '';
  int? _year;

  @override
  void initState() {
    super.initState();
    // Reload the profile and pick up server changes when the dashboard opens online.
    Future.microtask(() {
      ref.read(authProvider.notifier).refreshProfile();
      final online = ref.read(onlineProvider).value ?? true;
      if (online) ref.read(syncProvider.notifier).run();
    });
  }

  Future<void> _sync() async {
    final l10n = context.l10n;
    final messenger = ScaffoldMessenger.of(context);
    final report = await ref.read(syncProvider.notifier).run();
    if (!mounted) return;
    final state = ref.read(syncProvider);
    if (report != null) {
      messenger.showSnackBar(SnackBar(content: Text(l10n.syncDone(report.pushed, report.pulled))));
      if (report.rejected > 0) {
        messenger.showSnackBar(SnackBar(content: Text(l10n.syncErrorsTitle), backgroundColor: BrandColors.amber));
      }
    } else if (state.error != null) {
      messenger.showSnackBar(SnackBar(content: Text(l10n.syncFailed(state.error!)), backgroundColor: BrandColors.red));
    }
  }

  Future<void> _create() async {
    final l10n = context.l10n;
    final confirmed = await showDialog<bool>(
      context: context,
      builder: (ctx) => AlertDialog(
        title: Text(l10n.newApplication),
        content: Text(l10n.newApplicationHelp),
        actions: [
          TextButton(onPressed: () => Navigator.pop(ctx, false), child: Text(l10n.cancel)),
          FilledButton(onPressed: () => Navigator.pop(ctx, true), child: Text(l10n.ok)),
        ],
      ),
    );
    if (confirmed != true || !mounted) return;
    final record = await ref.read(applicationsProvider.notifier).create(language: context.isArabic ? 'ar' : 'en');
    if (!mounted) return;
    context.push('/applications/${record.clientUuid}/pre-test');
  }

  @override
  Widget build(BuildContext context) {
    final l10n = context.l10n;
    final auth = ref.watch(authProvider);
    final apps = ref.watch(applicationsProvider);
    final sync = ref.watch(syncProvider);
    final online = ref.watch(onlineProvider).value ?? true;

    final all = apps.value ?? const <ApplicationRecord>[];
    final years = all.map((a) => a.year).whereType<int>().toSet().toList()..sort((a, b) => b.compareTo(a));
    final filtered = all.where((a) {
      if (_year != null && a.year != _year) return false;
      if (_query.isNotEmpty && !(a.code ?? '').toLowerCase().contains(_query.toLowerCase())) return false;
      return true;
    }).toList();

    List<ApplicationRecord> forTab(DashboardTab tab) => filtered.where((a) => ApplicationStatus.tabOf(a.status) == tab).toList();

    return DefaultTabController(
      length: 4,
      child: Scaffold(
        appBar: AppBar(
          title: Row(
            children: [
              Image.asset('assets/images/logo.png', height: 32),
              const SizedBox(width: 10),
              Expanded(child: Text(l10n.appName, overflow: TextOverflow.ellipsis)),
            ],
          ),
          actions: [
            IconButton(
              key: const Key('sync-button'),
              tooltip: l10n.syncNow,
              onPressed: sync.running ? null : _sync,
              icon: sync.running
                  ? const SizedBox(width: 20, height: 20, child: CircularProgressIndicator(strokeWidth: 2))
                  : Badge(isLabelVisible: sync.pendingCount > 0, label: Text('${sync.pendingCount}'), child: const Icon(Icons.sync)),
            ),
            IconButton(tooltip: l10n.settings, onPressed: () => context.push('/settings'), icon: const Icon(Icons.settings_outlined)),
          ],
          bottom: PreferredSize(
            preferredSize: const Size.fromHeight(120),
            child: Column(
              children: [
                _SyncBar(online: online, sync: sync),
                Padding(
                  padding: const EdgeInsets.fromLTRB(12, 4, 12, 8),
                  child: Row(
                    children: [
                      Expanded(
                        child: TextField(
                          key: const Key('search-field'),
                          onChanged: (v) => setState(() => _query = v.trim()),
                          decoration: InputDecoration(hintText: l10n.search, prefixIcon: const Icon(Icons.search), isDense: true),
                        ),
                      ),
                      const SizedBox(width: 8),
                      DropdownButton<int?>(
                        value: _year,
                        hint: Text(l10n.year),
                        items: [
                          DropdownMenuItem<int?>(value: null, child: Text(l10n.allYears)),
                          for (final y in years) DropdownMenuItem<int?>(value: y, child: Text('$y')),
                        ],
                        onChanged: (v) => setState(() => _year = v),
                      ),
                    ],
                  ),
                ),
                TabBar(
                  isScrollable: false,
                  labelStyle: const TextStyle(fontSize: 13, fontWeight: FontWeight.w600),
                  tabs: [
                    Tab(text: '${l10n.tabPreTest} (${forTab(DashboardTab.preTest).length})'),
                    Tab(text: '${l10n.tabPostTest} (${forTab(DashboardTab.postTest).length})'),
                    Tab(text: '${l10n.tabDone} (${forTab(DashboardTab.done).length})'),
                    Tab(text: '${l10n.tabClosed} (${forTab(DashboardTab.closed).length})'),
                  ],
                ),
              ],
            ),
          ),
        ),
        body: Column(
          children: [
            if (auth.signedIn && !auth.canEdit)
              Container(
                width: double.infinity,
                color: const Color(0xFFFEF3C7),
                padding: const EdgeInsets.all(10),
                child: Text(l10n.readOnlyAccount, style: const TextStyle(color: BrandColors.amber)),
              ),
            Expanded(
              child: apps.isLoading && apps.value == null
                  ? const Center(child: CircularProgressIndicator())
                  : TabBarView(
                      children: [for (final tab in DashboardTab.values) _ApplicationList(records: forTab(tab), onRefresh: _sync)],
                    ),
            ),
          ],
        ),
        floatingActionButton: auth.canEdit
            ? FloatingActionButton.extended(
                key: const Key('new-application'),
                onPressed: _create,
                icon: const Icon(Icons.add),
                label: Text(l10n.newApplication),
              )
            : null,
      ),
    );
  }
}

class _SyncBar extends StatelessWidget {
  const _SyncBar({required this.online, required this.sync});

  final bool online;
  final SyncState sync;

  @override
  Widget build(BuildContext context) {
    final l10n = context.l10n;
    final when = sync.lastSync == null ? l10n.never : DateFormat.yMd(Localizations.localeOf(context).toString()).add_Hm().format(sync.lastSync!);
    return Container(
      width: double.infinity,
      color: online ? BrandColors.blueLight : const Color(0xFFFEE2E2),
      padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
      child: Row(
        children: [
          Icon(online ? Icons.wifi : Icons.wifi_off, size: 16, color: online ? BrandColors.blueDark : BrandColors.red),
          const SizedBox(width: 6),
          Text(online ? l10n.online : l10n.offline, style: const TextStyle(fontSize: 12, fontWeight: FontWeight.w600)),
          const SizedBox(width: 12),
          Expanded(
            child: Text(l10n.lastSync(when), style: const TextStyle(fontSize: 12), overflow: TextOverflow.ellipsis),
          ),
          if (sync.pendingCount > 0)
            Text(
              '${l10n.pendingSync}: ${sync.pendingCount}',
              style: const TextStyle(fontSize: 12, color: BrandColors.amber, fontWeight: FontWeight.w600),
            ),
        ],
      ),
    );
  }
}

class _ApplicationList extends StatelessWidget {
  const _ApplicationList({required this.records, required this.onRefresh});

  final List<ApplicationRecord> records;
  final Future<void> Function() onRefresh;

  @override
  Widget build(BuildContext context) {
    final l10n = context.l10n;
    return RefreshIndicator(
      onRefresh: onRefresh,
      child: records.isEmpty
          ? ListView(
              children: [
                Padding(
                  padding: const EdgeInsets.all(40),
                  child: Center(
                    child: Text(l10n.noApplications, style: const TextStyle(color: BrandColors.slate)),
                  ),
                ),
              ],
            )
          : ListView.builder(
              padding: const EdgeInsets.only(top: 8, bottom: 88),
              itemCount: records.length,
              itemBuilder: (context, i) => _ApplicationTile(record: records[i]),
            ),
    );
  }
}

class _ApplicationTile extends StatelessWidget {
  const _ApplicationTile({required this.record});

  final ApplicationRecord record;

  @override
  Widget build(BuildContext context) {
    final l10n = context.l10n;
    final pre = record.preTest;
    final subtitle = [
      if (pre['form'] != null) pre['form'],
      if (pre['age'] != null) '${l10n.age}: ${pre['age']}',
      if (pre['gender'] != null) pre['gender'],
      if (record.preTestDate != null) '${l10n.preTestDate}: ${record.preTestDate}',
    ].join(' · ');
    return Card(
      child: ListTile(
        onTap: () => context.push('/applications/${record.clientUuid}'),
        title: Text(
          record.code ?? l10n.pendingSync,
          style: TextStyle(fontWeight: FontWeight.w700, color: record.code == null ? BrandColors.amber : null),
        ),
        subtitle: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            if (subtitle.isNotEmpty) Text(subtitle, maxLines: 2, overflow: TextOverflow.ellipsis),
            if (record.syncError != null)
              Padding(
                padding: const EdgeInsets.only(top: 4),
                child: Text(
                  record.syncError!,
                  maxLines: 2,
                  overflow: TextOverflow.ellipsis,
                  style: const TextStyle(color: BrandColors.red, fontSize: 12),
                ),
              ),
          ],
        ),
        trailing: StatusChip(record.status, pending: record.hasPendingChanges),
      ),
    );
  }
}
