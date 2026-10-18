import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:go_router/go_router.dart';
import 'package:intl/intl.dart';

import '../../app/providers.dart';
import '../../core/config.dart';
import '../../core/theme.dart';
import '../../data/models/application_record.dart';
import '../../data/models/reference_data.dart';
import '../../domain/application_status.dart';
import '../../domain/sdq_catalog.dart';
import '../../domain/validation.dart';
import '../../domain/workflow.dart';
import '../../services/location_service.dart';
import '../shared/l10n_ext.dart';
import '../shared/widgets.dart';

/// Pre-test and post-test questionnaire. One screen handles both; the
/// differences are the consent script, the self-report wording for Form
/// 12-17 and the programme-attendance block of the post-test.
class TestFormScreen extends ConsumerStatefulWidget {
  const TestFormScreen({super.key, required this.clientUuid, required this.isPostTest});

  final String clientUuid;
  final bool isPostTest;

  @override
  ConsumerState<TestFormScreen> createState() => _TestFormScreenState();
}

class _TestFormScreenState extends ConsumerState<TestFormScreen> {
  ApplicationRecord? _record;
  late TestData _data;
  bool _readOnly = true;
  bool _loaded = false;
  bool _saving = false;
  bool _gpsBusy = false;
  Map<String, String> _errors = {};
  final _scroll = ScrollController();
  final _controllers = <String, TextEditingController>{};

  @override
  void initState() {
    super.initState();
    _load();
  }

  Future<void> _load() async {
    final record = await ref.read(applicationsProvider.notifier).find(widget.clientUuid);
    if (record == null || !mounted) return;
    final canEdit = ref.read(authProvider).canEdit;
    final editable = widget.isPostTest ? ApplicationStatus.allowsPostTestEdit(record.status) : ApplicationStatus.allowsPreTestEdit(record.status);
    TestData data = (widget.isPostTest ? record.postTest : record.preTest).copy();
    if (widget.isPostTest && data.fields.isEmpty) data = startPostTestFrom(record.preTest);
    if (!widget.isPostTest && data.fields['interview_date'] == null && editable) {
      data.fields['interview_date'] = DateFormat('yyyy-MM-dd').format(DateTime.now());
    }
    if (widget.isPostTest && data.fields['interview_date'] == null && editable) {
      data.fields['interview_date'] = DateFormat('yyyy-MM-dd').format(DateTime.now());
    }
    data.fields['may_i_start_now'] ??= 'yes';
    setState(() {
      _record = record;
      _data = data;
      _readOnly = !(canEdit && editable);
      _loaded = true;
    });
  }

  @override
  void dispose() {
    _scroll.dispose();
    for (final c in _controllers.values) {
      c.dispose();
    }
    super.dispose();
  }

  TextEditingController _controller(String key) => _controllers.putIfAbsent(key, () {
    final c = TextEditingController(text: _data[key] ?? '');
    c.addListener(() => _data.fields[key] = c.text);
    return c;
  });

  void _set(String key, Object? value) => setState(() {
    if (value == null || (value is String && value.isEmpty)) {
      _data.fields.remove(key);
    } else {
      _data.fields[key] = value;
    }
    _errors.remove(key);
  });

  String _errorMessage(String code) {
    final l10n = context.l10n;
    return switch (code) {
      TestValidator.number => l10n.invalidNumber,
      TestValidator.ageRange => () {
        final (min, max) = TestValidator.ageRangeFor(_data['form']);
        return l10n.ageRange(min, max);
      }(),
      TestValidator.latitude || TestValidator.longitude => l10n.invalidNumber,
      _ => l10n.required,
    };
  }

  Future<void> _persist({required bool submit}) async {
    final l10n = context.l10n;
    final errors = TestValidator(isPostTest: widget.isPostTest).validate(_data, submitting: submit);
    if (errors.isNotEmpty) {
      setState(() => _errors = errors);
      ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text(l10n.fixErrors), backgroundColor: BrandColors.red));
      _scroll.animateTo(0, duration: const Duration(milliseconds: 300), curve: Curves.easeOut);
      return;
    }
    if (submit) {
      final ok = await showDialog<bool>(
        context: context,
        builder: (ctx) => AlertDialog(
          title: Text(l10n.submitConfirmTitle(widget.isPostTest ? l10n.postTest : l10n.preTest)),
          content: Text(l10n.submitConfirmBody),
          actions: [
            TextButton(onPressed: () => Navigator.pop(ctx, false), child: Text(l10n.cancel)),
            FilledButton(onPressed: () => Navigator.pop(ctx, true), child: Text(l10n.submit)),
          ],
        ),
      );
      if (ok != true || !mounted) return;
    }
    setState(() => _saving = true);
    final record = _record!;
    final action = submit ? PendingAction.submit : PendingAction.save;
    if (widget.isPostTest) {
      record.postTest = _data.copy();
      record.postPending = action;
    } else {
      record.preTest = _data.copy();
      record.prePending = action;
    }
    record.status = statusAfter(isPostTest: widget.isPostTest, submit: submit, data: _data);
    record.syncError = null;
    await ref.read(applicationsProvider.notifier).save(record);
    if (!mounted) return;
    ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text(submit ? l10n.submittedLocally : l10n.savedLocally)));
    if (ref.read(onlineProvider).value ?? false) {
      ref.read(syncProvider.notifier).run();
    }
    context.pop();
  }

  Future<void> _captureGps() async {
    final l10n = context.l10n;
    setState(() => _gpsBusy = true);
    try {
      final pos = await ref.read(servicesProvider).location.capture();
      setState(() {
        _data.fields['latitude'] = pos.latitude.toStringAsFixed(6);
        _data.fields['longitude'] = pos.longitude.toStringAsFixed(6);
        if (pos.altitude != null) _data.fields['altitude'] = pos.altitude!.toStringAsFixed(1);
        if (pos.accuracy != null) _data.fields['accuracy'] = pos.accuracy!.toStringAsFixed(1);
        _errors.remove('latitude');
        _errors.remove('longitude');
      });
      if (mounted) ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text(l10n.gpsCaptured(pos.accuracy?.toStringAsFixed(0) ?? '?'))));
    } catch (e) {
      final message = e is LocationException ? e.message : e.toString();
      if (mounted) ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text(l10n.gpsFailed(message)), backgroundColor: BrandColors.red));
    } finally {
      if (mounted) setState(() => _gpsBusy = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    final l10n = context.l10n;
    final title = widget.isPostTest ? l10n.postTest : l10n.preTest;
    if (!_loaded) {
      return Scaffold(
        appBar: AppBar(title: Text(title)),
        body: const Center(child: CircularProgressIndicator()),
      );
    }
    final reference = ref.watch(referenceProvider).value;
    final arabic = context.isArabic;
    final consent = _data.consentGiven;

    return Scaffold(
      appBar: AppBar(title: Text('${_record!.code ?? l10n.application} · $title')),
      body: Form(
        child: ListView(
          controller: _scroll,
          padding: const EdgeInsets.fromLTRB(16, 8, 16, 120),
          children: [
            _consentSection(arabic),
            if (consent) ...[
              _interviewSection(arabic),
              _childSection(arabic),
              _locationSection(reference, arabic),
              _questionnaireSection(arabic),
              if (widget.isPostTest) _programmeSection(arabic),
              _otherSection(arabic),
            ],
          ],
        ),
      ),
      bottomNavigationBar: _readOnly
          ? null
          : SafeArea(
              child: Padding(
                padding: const EdgeInsets.all(12),
                child: Row(
                  children: [
                    Expanded(
                      child: OutlinedButton.icon(
                        key: const Key('save-draft'),
                        onPressed: _saving ? null : () => _persist(submit: false),
                        icon: const Icon(Icons.save_outlined),
                        label: Text(l10n.saveDraft),
                      ),
                    ),
                    const SizedBox(width: 12),
                    Expanded(
                      child: FilledButton.icon(
                        key: const Key('submit'),
                        onPressed: _saving ? null : () => _persist(submit: true),
                        icon: const Icon(Icons.send),
                        label: Text(l10n.submit),
                      ),
                    ),
                  ],
                ),
              ),
            ),
    );
  }

  // ---- Sections -------------------------------------------------------------

  Widget _consentSection(bool arabic) {
    final l10n = context.l10n;
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        SectionTitle(l10n.sectionConsent),
        Card(
          margin: EdgeInsets.zero,
          child: Padding(
            padding: const EdgeInsets.all(12),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  l10n.consentScriptTitle,
                  style: const TextStyle(fontWeight: FontWeight.w700, color: BrandColors.blueDark),
                ),
                const SizedBox(height: 6),
                Text(
                  consentScript(arabic: arabic, postTest: widget.isPostTest),
                  style: const TextStyle(height: 1.5),
                ),
              ],
            ),
          ),
        ),
        const SizedBox(height: 12),
        Text(l10n.consentQuestion, style: const TextStyle(fontWeight: FontWeight.w600)),
        RadioGroup<String>(
          groupValue: _data['may_i_start_now'] ?? 'yes',
          onChanged: (v) {
            if (!_readOnly) _set('may_i_start_now', v);
          },
          child: Column(
            children: [
              for (final o in consentOptions)
                RadioListTile<String>(key: Key('consent-${o.value}'), value: o.value, dense: true, title: Text(arabic ? o.ar : consentEnglish[o.value]!)),
            ],
          ),
        ),
        if (!_data.consentGiven) Text(l10n.consentRefusedHelp, style: const TextStyle(color: BrandColors.amber)),
      ],
    );
  }

  Widget _interviewSection(bool arabic) {
    final l10n = context.l10n;
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        SectionTitle(l10n.sectionInterview),
        _optionDropdown('form', l10n.form, formOptions, arabic, help: l10n.formHelp),
        _optionDropdown('category', l10n.category, categoryOptions, arabic),
        _optionDropdown('agency_name', l10n.agency, agencyOptions, arabic),
        _optionDropdown('donor_name', l10n.donor, donorOptions, arabic),
        _dateField('interview_date', l10n.interviewDate),
        _textField('interviewers_name', l10n.interviewer),
      ],
    );
  }

  Widget _childSection(bool arabic) {
    final l10n = context.l10n;
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        SectionTitle(l10n.sectionChild),
        _textField('child_code', l10n.childCode),
        _textField('age', l10n.age, keyboard: TextInputType.number),
        _optionDropdown('gender', l10n.gender, genderOptions, arabic),
        _optionDropdown('nationality', l10n.nationality, nationalityOptions, arabic),
        if (_data['nationality'] == 'Other Nationality') _textField('other_nationality', l10n.otherNationality),
      ],
    );
  }

  Widget _locationSection(ReferenceData? reference, bool arabic) {
    final l10n = context.l10n;
    final governorates = reference?.governorates ?? const <Governorate>[];
    final gov = reference?.governorate(_data['gouvarnate']);
    final caza = reference?.caza(_data['gouvarnate'], _data['caza']);
    final hasGps = _data['latitude'] != null && _data['longitude'] != null;
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        SectionTitle(l10n.sectionLocation),
        if (reference == null)
          Padding(
            padding: const EdgeInsets.only(bottom: 8),
            child: Text(l10n.notSynced, style: const TextStyle(color: BrandColors.amber)),
          ),
        OptionDropdown<String>(
          label: l10n.governorate,
          value: _data['gouvarnate'],
          enabled: !_readOnly,
          errorText: _errors['gouvarnate'] == null ? null : _errorMessage(_errors['gouvarnate']!),
          items: [for (final g in governorates) DropdownMenuItem(value: g.id.toString(), child: Text(g.label(arabic)))],
          onChanged: (v) => setState(() {
            _set('gouvarnate', v);
            _set('caza', null);
            _set('area', null);
          }),
        ),
        OptionDropdown<String>(
          label: l10n.caza,
          value: _data['caza'],
          enabled: !_readOnly && gov != null,
          errorText: _errors['caza'] == null ? null : _errorMessage(_errors['caza']!),
          items: [for (final c in gov?.cazas ?? const <Caza>[]) DropdownMenuItem(value: c.id.toString(), child: Text(c.label(arabic)))],
          onChanged: (v) => setState(() {
            _set('caza', v);
            _set('area', null);
          }),
        ),
        OptionDropdown<String>(
          label: l10n.area,
          value: _data['area'],
          enabled: !_readOnly && caza != null,
          errorText: _errors['area'] == null ? null : _errorMessage(_errors['area']!),
          items: [for (final a in caza?.areas ?? const <Area>[]) DropdownMenuItem(value: a.id.toString(), child: Text(a.label(arabic)))],
          onChanged: (v) => _set('area', v),
        ),
        _optionDropdown('gateway_type', l10n.gatewayType, gatewayOptions, arabic),
        _textField('p_code', l10n.pCode),
        Row(
          children: [
            Expanded(
              child: Text(
                hasGps ? '${l10n.gps}: ${_data['latitude']}, ${_data['longitude']}' : l10n.gps,
                style: TextStyle(color: hasGps ? BrandColors.green : BrandColors.slate),
              ),
            ),
            if (!_readOnly)
              OutlinedButton.icon(
                onPressed: _gpsBusy ? null : _captureGps,
                icon: _gpsBusy ? const SizedBox(width: 16, height: 16, child: CircularProgressIndicator(strokeWidth: 2)) : const Icon(Icons.my_location),
                label: Text(l10n.captureGps),
              ),
          ],
        ),
        if (_errors['latitude'] != null || _errors['longitude'] != null) Text(l10n.invalidNumber, style: const TextStyle(color: BrandColors.red, fontSize: 12)),
      ],
    );
  }

  Widget _questionnaireSection(bool arabic) {
    final l10n = context.l10n;
    final selfReport = _data['form'] == 'Form 12-17';
    final answered = _data.answeredCount;
    final na = _data.naCount;
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        SectionTitle(l10n.sectionQuestionnaire),
        Text(l10n.answered(answered, sdqItems.length), style: const TextStyle(color: BrandColors.slate)),
        if (na > AppConfig.maxNaAnswers)
          Padding(
            padding: const EdgeInsets.only(top: 4),
            child: Text(l10n.naWarning(AppConfig.maxNaAnswers), style: const TextStyle(color: BrandColors.amber)),
          ),
        const SizedBox(height: 8),
        for (var i = 0; i < sdqItems.length; i++) _itemCard(i, sdqItems[i], arabic, selfReport),
      ],
    );
  }

  Widget _itemCard(int index, SdqItem item, bool arabic, bool selfReport) {
    final value = _data[item.key]?.toLowerCase();
    final error = _errors[item.key];
    return Card(
      key: Key('item-${item.key}'),
      margin: const EdgeInsets.only(bottom: 10),
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(10),
        side: BorderSide(color: error != null ? BrandColors.red : const Color(0xFFE2E8F0)),
      ),
      child: Padding(
        padding: const EdgeInsets.all(12),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              '${index + 1}. ${item.label(arabic: arabic, selfReport: selfReport)}',
              style: const TextStyle(fontWeight: FontWeight.w600, height: 1.4),
            ),
            const SizedBox(height: 8),
            Wrap(
              spacing: 6,
              runSpacing: 6,
              children: [
                for (final o in answerOptions)
                  ChoiceChip(
                    label: Text(arabic ? o.ar : answerEnglish[o.value]!),
                    selected: value == o.value,
                    onSelected: _readOnly ? null : (_) => _set(item.key, o.value),
                    selectedColor: o.value == 'na' ? const Color(0xFFFEF3C7) : BrandColors.blueLight,
                  ),
              ],
            ),
            if (error != null)
              Padding(
                padding: const EdgeInsets.only(top: 4),
                child: Text(_errorMessage(error), style: const TextStyle(color: BrandColors.red, fontSize: 12)),
              ),
          ],
        ),
      ),
    );
  }

  Widget _programmeSection(bool arabic) {
    final l10n = context.l10n;
    final reason = _data['dropout_reason'];
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        SectionTitle(l10n.sectionProgramme),
        _textField('number_of_hours_that_the_child_attended', l10n.hoursAttended, keyboard: const TextInputType.numberWithOptions(decimal: true)),
        _textField('total_number_of_hours_in_your_program', l10n.hoursTotal, keyboard: const TextInputType.numberWithOptions(decimal: true)),
        _optionDropdown('dropout_reason', l10n.dropoutReason, dropoutOptions, arabic),
        if (reason != null && reason != didNotDropOut) _textField('justify_the_dropout_reason', l10n.dropoutJustification, maxLines: 3),
      ],
    );
  }

  Widget _otherSection(bool arabic) {
    final l10n = context.l10n;
    final raw = _data.fields['do_the_child_receive_any_other_child_protection_services'];
    final selected = raw is List ? raw.map((e) => e.toString()).toSet() : <String>{};
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        SectionTitle(l10n.sectionOther),
        Text(l10n.services, style: const TextStyle(fontWeight: FontWeight.w600)),
        for (final o in serviceOptions)
          CheckboxListTile(
            dense: true,
            contentPadding: EdgeInsets.zero,
            controlAffinity: ListTileControlAffinity.leading,
            value: selected.contains(o.value),
            title: Text(o.label(arabic)),
            onChanged: _readOnly
                ? null
                : (checked) {
                    final next = {...selected};
                    checked == true ? next.add(o.value) : next.remove(o.value);
                    _set('do_the_child_receive_any_other_child_protection_services', next.isEmpty ? null : next.toList());
                  },
          ),
        const SizedBox(height: 8),
        _textField('comment', l10n.comment, maxLines: 4),
      ],
    );
  }

  // ---- Field helpers ----------------------------------------------------------

  Widget _optionDropdown(String key, String label, List<Option> options, bool arabic, {String? help}) {
    final current = _data[key];
    // Keep a legacy spelling selectable even if it is not in the current list.
    final values = options.map((o) => o.value).toList();
    final matched = current == null ? null : values.cast<String?>().firstWhere((v) => v!.toLowerCase() == current.toLowerCase(), orElse: () => null);
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        OptionDropdown<String>(
          label: label,
          value: matched ?? current,
          enabled: !_readOnly,
          errorText: _errors[key] == null ? null : _errorMessage(_errors[key]!),
          items: [
            for (final o in options)
              DropdownMenuItem(
                value: o.value,
                child: Text(o.label(arabic), overflow: TextOverflow.ellipsis),
              ),
            if (current != null && matched == null)
              DropdownMenuItem(
                value: current,
                child: Text(current, overflow: TextOverflow.ellipsis),
              ),
          ],
          onChanged: (v) => _set(key, v),
        ),
        if (help != null)
          Padding(
            padding: const EdgeInsets.only(bottom: 12),
            child: Text(help, style: const TextStyle(fontSize: 12, color: BrandColors.slate)),
          ),
      ],
    );
  }

  Widget _textField(String key, String label, {TextInputType? keyboard, int maxLines = 1}) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 12),
      child: TextFormField(
        key: Key('field-$key'),
        controller: _controller(key),
        readOnly: _readOnly,
        keyboardType: keyboard,
        maxLines: maxLines,
        onChanged: (_) => setState(() => _errors.remove(key)),
        decoration: InputDecoration(labelText: label, errorText: _errors[key] == null ? null : _errorMessage(_errors[key]!)),
      ),
    );
  }

  Widget _dateField(String key, String label) {
    final value = _data[key];
    return Padding(
      padding: const EdgeInsets.only(bottom: 12),
      child: InkWell(
        onTap: _readOnly
            ? null
            : () async {
                final initial = DateTime.tryParse(value ?? '') ?? DateTime.now();
                final picked = await showDatePicker(context: context, initialDate: initial, firstDate: DateTime(2015), lastDate: DateTime.now());
                if (picked != null) _set(key, DateFormat('yyyy-MM-dd').format(picked));
              },
        child: InputDecorator(
          decoration: InputDecoration(
            labelText: label,
            suffixIcon: const Icon(Icons.calendar_today_outlined),
            errorText: _errors[key] == null ? null : _errorMessage(_errors[key]!),
          ),
          child: Text(value ?? context.l10n.selectOne),
        ),
      ),
    );
  }
}
