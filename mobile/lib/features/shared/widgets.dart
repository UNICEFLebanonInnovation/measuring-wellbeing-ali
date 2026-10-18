import 'package:flutter/material.dart';

import '../../core/theme.dart';
import '../../domain/application_status.dart';

/// Coloured pill for a workflow status.
class StatusChip extends StatelessWidget {
  const StatusChip(this.status, {super.key, this.pending = false});

  final String status;
  final bool pending;

  @override
  Widget build(BuildContext context) {
    final (bg, fg) = switch (ApplicationStatus.tabOf(status)) {
      DashboardTab.preTest => (BrandColors.blueLight, BrandColors.blueDark),
      DashboardTab.postTest => (const Color(0xFFFEF3C7), BrandColors.amber),
      DashboardTab.done => (const Color(0xFFDCFCE7), BrandColors.green),
      DashboardTab.closed => (const Color(0xFFF1F5F9), BrandColors.slate),
    };
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
      decoration: BoxDecoration(color: bg, borderRadius: BorderRadius.circular(999)),
      child: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          if (pending) ...[Icon(Icons.cloud_upload_outlined, size: 14, color: fg), const SizedBox(width: 4)],
          Text(
            status,
            style: TextStyle(color: fg, fontSize: 12, fontWeight: FontWeight.w600),
          ),
        ],
      ),
    );
  }
}

/// Section header used in forms and on the detail page.
class SectionTitle extends StatelessWidget {
  const SectionTitle(this.title, {super.key});

  final String title;

  @override
  Widget build(BuildContext context) => Padding(
    padding: const EdgeInsets.only(top: 20, bottom: 8),
    child: Text(
      title,
      style: Theme.of(context).textTheme.titleMedium?.copyWith(color: BrandColors.blueDark, fontWeight: FontWeight.w700),
    ),
  );
}

/// Two-column label/value row.
class InfoRow extends StatelessWidget {
  const InfoRow(this.label, this.value, {super.key});

  final String label;
  final String? value;

  @override
  Widget build(BuildContext context) => Padding(
    padding: const EdgeInsets.symmetric(vertical: 4),
    child: Row(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        SizedBox(
          width: 140,
          child: Text(label, style: const TextStyle(color: BrandColors.slate)),
        ),
        Expanded(
          child: Text((value == null || value!.isEmpty) ? '—' : value!, style: const TextStyle(fontWeight: FontWeight.w500)),
        ),
      ],
    ),
  );
}

/// Generic dropdown with a "Select…" placeholder.
class OptionDropdown<T> extends StatelessWidget {
  const OptionDropdown({
    super.key,
    required this.label,
    required this.value,
    required this.items,
    required this.onChanged,
    this.errorText,
    this.enabled = true,
  });

  final String label;
  final T? value;
  final List<DropdownMenuItem<T>> items;
  final ValueChanged<T?> onChanged;
  final String? errorText;
  final bool enabled;

  @override
  Widget build(BuildContext context) {
    final present = items.any((i) => i.value == value);
    return Padding(
      padding: const EdgeInsets.only(bottom: 12),
      child: DropdownButtonFormField<T>(
        key: ValueKey('$label-${present ? value : null}'),
        initialValue: present ? value : null,
        isExpanded: true,
        decoration: InputDecoration(labelText: label, errorText: errorText),
        items: items,
        onChanged: enabled ? onChanged : null,
      ),
    );
  }
}
