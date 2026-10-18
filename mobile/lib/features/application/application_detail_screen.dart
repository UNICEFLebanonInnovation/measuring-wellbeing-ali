import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:go_router/go_router.dart';

import '../../app/providers.dart';
import '../../core/theme.dart';
import '../../data/models/application_record.dart';
import '../../data/models/reference_data.dart';
import '../../domain/application_status.dart';
import '../../domain/sdq_catalog.dart';
import '../shared/l10n_ext.dart';
import '../shared/widgets.dart';

class ApplicationDetailScreen extends ConsumerWidget {
  const ApplicationDetailScreen({super.key, required this.clientUuid});

  final String clientUuid;

  @override
  Widget build(BuildContext context, WidgetRef ref) {
    final l10n = context.l10n;
    final record = ref.watch(applicationProvider(clientUuid)).value;
    final reference = ref.watch(referenceProvider).value;
    final canEdit = ref.watch(authProvider).canEdit;

    if (record == null) {
      return Scaffold(
        appBar: AppBar(title: Text(l10n.application)),
        body: const Center(child: CircularProgressIndicator()),
      );
    }

    final isSelf = record.preTest['form'] == 'Form 12-17';
    return Scaffold(
      appBar: AppBar(
        title: Text(record.code ?? l10n.application),
        actions: [
          if (!record.existsOnServer && canEdit)
            IconButton(tooltip: l10n.deleteDraft, icon: const Icon(Icons.delete_outline), onPressed: () => _delete(context, ref, record)),
        ],
      ),
      body: ListView(
        padding: const EdgeInsets.all(16),
        children: [
          Row(
            children: [
              StatusChip(record.status, pending: record.hasPendingChanges),
              const SizedBox(width: 8),
              if (record.year != null) Text('${l10n.year} ${record.year}', style: const TextStyle(color: BrandColors.slate)),
            ],
          ),
          if (record.hasPendingChanges)
            Padding(
              padding: const EdgeInsets.only(top: 8),
              child: Text(l10n.notSynced, style: const TextStyle(color: BrandColors.amber)),
            ),
          if (record.syncError != null)
            Container(
              margin: const EdgeInsets.only(top: 8),
              padding: const EdgeInsets.all(10),
              decoration: BoxDecoration(color: const Color(0xFFFEE2E2), borderRadius: BorderRadius.circular(8)),
              child: Text(l10n.serverError(record.syncError!), style: const TextStyle(color: BrandColors.red)),
            ),
          SectionTitle(l10n.sectionChild),
          InfoRow(l10n.form, record.preTest['form']),
          InfoRow(l10n.childCode, record.preTest['child_code']),
          InfoRow(l10n.age, record.preTest['age']),
          InfoRow(l10n.gender, _optionLabel(genderOptions, record.preTest['gender'], context.isArabic)),
          InfoRow(l10n.nationality, _optionLabel(nationalityOptions, record.preTest['nationality'], context.isArabic)),
          InfoRow(l10n.category, _optionLabel(categoryOptions, record.preTest['category'], context.isArabic)),
          InfoRow(l10n.agency, record.preTest['agency_name']),
          InfoRow(l10n.governorate, _location(reference, record.preTest, context.isArabic)),
          InfoRow(l10n.preTestDate, record.preTestDate ?? record.preTest['interview_date']),
          InfoRow(l10n.postTestDate, record.postTestDate ?? record.postTest['interview_date']),
          SectionTitle(l10n.scores),
          _ScoresTable(record: record),
          const SizedBox(height: 24),
          ..._actions(context, record, canEdit, isSelf),
          const SizedBox(height: 32),
        ],
      ),
    );
  }

  List<Widget> _actions(BuildContext context, ApplicationRecord record, bool canEdit, bool isSelf) {
    final l10n = context.l10n;
    final buttons = <Widget>[];
    void add(String label, IconData icon, String route, {bool filled = true}) {
      final child = Row(mainAxisAlignment: MainAxisAlignment.center, children: [Icon(icon), const SizedBox(width: 8), Text(label)]);
      buttons.add(
        Padding(
          padding: const EdgeInsets.only(bottom: 10),
          child: filled ? FilledButton(onPressed: () => context.push(route), child: child) : OutlinedButton(onPressed: () => context.push(route), child: child),
        ),
      );
    }

    final base = '/applications/${record.clientUuid}';
    if (canEdit && ApplicationStatus.allowsPreTestEdit(record.status)) {
      add(
        record.prePending == PendingAction.none && record.preTest.answeredCount == 0 ? l10n.startPreTest : l10n.continuePreTest,
        Icons.edit_note,
        '$base/pre-test',
      );
    } else {
      add('${l10n.viewAnswers} · ${l10n.preTest}', Icons.visibility_outlined, '$base/pre-test', filled: false);
    }
    if (canEdit && ApplicationStatus.allowsPostTestEdit(record.status)) {
      add(
        record.postPending == PendingAction.none && record.postTest.answeredCount == 0 ? l10n.startPostTest : l10n.continuePostTest,
        Icons.edit_note,
        '$base/post-test',
      );
    } else if (record.postTest.answeredCount > 0 || record.postTestDate != null) {
      add('${l10n.viewAnswers} · ${l10n.postTest}', Icons.visibility_outlined, '$base/post-test', filled: false);
    }
    return buttons;
  }

  Future<void> _delete(BuildContext context, WidgetRef ref, ApplicationRecord record) async {
    final l10n = context.l10n;
    final ok = await showDialog<bool>(
      context: context,
      builder: (ctx) => AlertDialog(
        title: Text(l10n.deleteDraft),
        content: Text(l10n.deleteDraftConfirm),
        actions: [
          TextButton(onPressed: () => Navigator.pop(ctx, false), child: Text(l10n.cancel)),
          FilledButton(
            style: FilledButton.styleFrom(backgroundColor: BrandColors.red),
            onPressed: () => Navigator.pop(ctx, true),
            child: Text(l10n.deleteDraft),
          ),
        ],
      ),
    );
    if (ok != true) return;
    await ref.read(applicationsProvider.notifier).delete(record);
    if (context.mounted) context.pop();
  }

  String? _optionLabel(List<Option> options, String? value, bool arabic) {
    if (value == null) return null;
    for (final o in options) {
      if (o.value.toLowerCase() == value.toLowerCase()) return o.label(arabic);
    }
    return value;
  }

  String? _location(ReferenceData? ref, TestData pre, bool arabic) {
    if (ref == null) return [pre['gouvarnate'], pre['caza'], pre['area']].whereType<String>().join(' / ');
    final g = ref.governorate(pre['gouvarnate']);
    final c = ref.caza(pre['gouvarnate'], pre['caza']);
    final a = ref.area(pre['gouvarnate'], pre['caza'], pre['area']);
    return [g?.label(arabic), c?.label(arabic), a?.label(arabic)].whereType<String>().join(' / ');
  }
}

class _ScoresTable extends StatelessWidget {
  const _ScoresTable({required this.record});

  final ApplicationRecord record;

  @override
  Widget build(BuildContext context) {
    final l10n = context.l10n;
    final pre = record.preTest.scores;
    final post = record.postTest.scores;
    if (pre == null && post == null) {
      return Text(l10n.notSynced, style: const TextStyle(color: BrandColors.slate));
    }
    String fmt(Map<String, dynamic>? s, String key) {
      final v = s?[key];
      if (v == null) return '—';
      if (v is num) return v == v.roundToDouble() ? v.toInt().toString() : v.toStringAsFixed(1);
      return v.toString();
    }

    final rows = [
      (l10n.scaleEmotional, 'emotional_scale'),
      (l10n.scaleConduct, 'conduct_scale'),
      (l10n.scaleHyperactivity, 'hyper_activity_scale'),
      (l10n.scalePeer, 'peer_problem_scale'),
      (l10n.scaleProsocial, 'pro_social_scale'),
      (l10n.naCount, 'na_count'),
      (l10n.scaleTotal, 'total'),
    ];
    final preTotal = record.preTest.total;
    final postTotal = record.postTest.total;
    String? change;
    if (preTotal != null && postTotal != null) {
      change = postTotal < preTotal ? l10n.changeIncrease : (postTotal > preTotal ? l10n.changeDecrease : l10n.changeSame);
    }
    return Column(
      children: [
        Table(
          columnWidths: const {0: FlexColumnWidth(2), 1: FlexColumnWidth(1), 2: FlexColumnWidth(1)},
          border: TableBorder(horizontalInside: BorderSide(color: Colors.grey.shade200)),
          children: [
            TableRow(
              children: [
                const SizedBox(),
                Padding(
                  padding: const EdgeInsets.all(6),
                  child: Text(l10n.preTest, style: const TextStyle(fontWeight: FontWeight.w700)),
                ),
                Padding(
                  padding: const EdgeInsets.all(6),
                  child: Text(l10n.postTest, style: const TextStyle(fontWeight: FontWeight.w700)),
                ),
              ],
            ),
            for (final (label, key) in rows)
              TableRow(
                decoration: key == 'total' ? const BoxDecoration(color: BrandColors.blueLight) : null,
                children: [
                  Padding(padding: const EdgeInsets.all(6), child: Text(label)),
                  Padding(padding: const EdgeInsets.all(6), child: Text(fmt(pre, key))),
                  Padding(padding: const EdgeInsets.all(6), child: Text(fmt(post, key))),
                ],
              ),
          ],
        ),
        if (change != null) Padding(padding: const EdgeInsets.only(top: 8), child: InfoRow(l10n.change, change)),
      ],
    );
  }
}
