# Android application analysis (sdq-12.apk)

Date: 2026-10-18. Source: `sdq-12.apk` downloaded from measuringwellbeing.org (SHA-256 `d733de6b144fb11932a559b5c69fb2718669c751f78fd1de4a3b034a84e3c7ef`), decoded with apktool 2.10 and decompiled with jadx 1.5. The decompiled code is not stored in this repository; the extracted English and Arabic strings and the option lists are under `docs/mobile-app/`.

## 1. Summary

The app is a thin, offline-capable client for collectors. It has four screens: splash, login, dashboard and form. It stores everything in a local SQLite database, generates application codes on the device, and pushes drafts and submissions to the legacy `/api/*` endpoints when a connection is available. There is no scoring, no analytics and no partner functionality in the app; all of that is server side.

Three findings matter for the migration:

1. **The production server is newer than the code in this repository.** The app requires two fields in the login response, `year` and `years`, that the repository's legacy code never returned. Version 12 of the app has a reporting-year selector that depends on them. The compatibility layer in the new platform now returns both fields, otherwise the app shows "Invalid User" on login.
2. **The app sends raw spinner labels.** Gender arrives as `Male`/`Female`, consent as `Yes, permission is given`, categories as `Child Marriage Activity` (the web form said `Child Mariage Activity`), and gateway types include `Remotely` and `Other`. Production data contains these variants. The new platform normalises them on input (`App\Sdq\FormOptions::normalise`) and accepts both spellings.
3. **The APK is a debug build signed with the Android debug key** (certificate CN "Android Debug", valid to 2049), with `usesCleartextTraffic` on and the Stetho debugging bridge enabled. It must never be the basis of a store release and should be retired as soon as the new app ships.

## 2. Build facts

| Item | Value |
|---|---|
| Package | `com.example.sqd_app` |
| Version shown to the server | `app_version = 12` (string resource); manifest versionName 1.0, versionCode 1 |
| Android | minSdk 21 (Android 5.0), targetSdk 29 (Android 10), compileSdk 29 |
| Build type | `debug` (`BuildConfig.DEBUG = true`) |
| Signing | Android debug certificate, SHA-256 `C4:2F:EF:9D:09:10:14:2A:4F:B6:1A:C4:A1:50:7E:64:8F:B5:C6:27:9E:C2:32:C7:72:C7:54:C1:92:A0:F5:F9`, signature schemes v1 and v2 |
| Permissions | INTERNET, ACCESS_NETWORK_STATE, ACCESS_FINE_LOCATION, ACCESS_COARSE_LOCATION, WAKE_LOCK, Firebase messaging |
| Networking | `usesCleartextTraffic="true"`, `allowBackup="false"` |
| Libraries | Volley (HTTP), OkHttp 3, Firebase Core and Analytics, Crashlytics, Google Play Services location, Facebook Stetho (debug inspector, enabled in `MainActivity`), MaterialSpinner, MultiSelectionSpinner, AndroidX |
| Languages | English and Arabic resources for every app string (93 strings, 12 option arrays), with the self-report wording for Form 12-17 and the caregiver wording for Form 6-11 |
| Code size | 16,300 decompiled lines in the app package: `FormActivity` 3,900, `DashboardActivity` 3,000, `DBHelper` 2,200 |

## 3. Screens and behaviour

**MainActivity (splash).** Requests fine and coarse location permission. If `LoginStatus` is set in shared preferences it opens the dashboard, otherwise the login screen. Initialises Stetho.

**LoginActivity.** Posts `email`, `password` and `app_version` to `/api/login`. On success it stores in shared preferences every field of `data` (id, names, email, phone, zone, address, fax, is_active, email_verified_at, api_token, created_at, updated_at, collector_prefix, partner_prefix, partner_name, last_increment_no, is_readonly, year, years) and flags `LoginStatus = true`, `SyncGouStatus = false`. Any missing key raises a JSON exception and the user sees "Invalid User".

**DashboardActivity.** Forces the UI language to English on open. Then:

1. If reference data has not been synced (`SyncGouStatus`), downloads governorates, cazas and areas (`get-gouvernate`, `get-caza`, `get-area`) into SQLite.
2. Checks connectivity by running `ping -c 1 www.google.com`. Online: deletes all local applications and reloads them from `get-application`. Offline: shows what is in SQLite.
3. If unsynced rows exist, runs `SynceOnline`: pushes pre-test drafts, pre-test submissions, post-test drafts and post-test submissions in that order with fixed delays (0 s, 1 s, 3 s, 5 s), then refreshes the list after 15 s.
4. Four tabs filter the list by local status name: Pre-pending (`Pre Test`, `Pre Test Pending`), Post-pending (`Post Test`, `Post Test Pending`, `Pre Test Completed`), Done (`Done`), Dropped (`Dropout`). A search box filters by code and category, and a year filter uses the `years` list from login.
5. Buttons: add application (opens the form in "new" mode), resume, view, sync now, logout (`/api/logout`).

**FormActivity.** One activity renders pre-test and post-test. The order is: consent text (`declaration_pre` or `declaration_post`, read aloud by the collector), consent spinner, reporting year, form (6-11 or 12-17), category, agency (dropdown of 37 NGOs plus Other), donor, interview date and time (defaults to now), interviewer name, child's code (read-only, see section 5), age, gender, nationality (plus free text for Other), governorate, caza, area (cascading from SQLite, Arabic names when the UI is Arabic), gateway type, P-code, GPS (last known location from Google Play Services, written into latitude, longitude, altitude, accuracy), the 25 items with answers Not true / Somewhat true / Certainly true / No answer, other child-protection services (multi-select, includes "No"), comments. Post-test adds hours attended, total hours in programme, dropout reason and its justification.

Validation in the app: age must be 6 to 11 for Form 6-11 and 12 to 17 for Form 12-17 (Arabic digits are converted); dropout justification is required when the reason is not "Did Not Drop Out"; when consent is refused the rest of the form is skipped. The language toggle switches between English and Arabic at runtime; Arabic answer labels are mapped back to `0`, `1`, `2`, `na` before saving. The `language` field sent to the server records the UI language used.

Save stores the row locally as a draft and, when online, calls the save endpoint. Submit stores the row and calls the submit endpoint; offline, the row waits with `synced = 0`.

## 4. Network contract

Base URL `https://measuringwellbeing.org/api/` (root `/api`, not `/prod/api`). Every call is an HTTP POST with form-encoded parameters, 10 to 30 second timeout, no retries for most calls. The token is sent as a form field named `token`, never as a header. Every request also carries `app_version`.

| Endpoint | Parameters | Response fields the app reads |
|---|---|---|
| `login` | email, password | `data.*` listed above, `message` |
| `logout` | token | none |
| `get-gouvernate`, `get-caza`, `get-area` | token (caza and area also send the parent id) | `data[]` with id, name, arabic, parent ids, created_at, updated_at |
| `get-application` | token | `data.application_count`, `data.application[]` with id, code, status, status_name, type, pre_test{...}, post_test{...}, caza, area |
| `create-application` | token, code | `data.code` (the app overwrites its local code with the returned one) |
| `submit-pre-test-application`, `save-pre-test-application` | token, code, submit (`save` or `submit`), year, all questionnaire fields, `do_the_child_receive_any_other_child_protection_services[]` | `data` (application row) |
| `submit-post-test-application`, `save-post-test-application` | same plus hours and dropout fields | `data` |
| `pre-test-application`, `post-test-application` | token, code | the stored answers, used to open an existing application in view or resume mode |

Error handling is minimal: any non-JSON or unexpected body shows "Invalid User"; a JSON error shows its `message`.

The new platform's legacy routes (`routes/api.php`, `App\Http\Controllers\Api\Legacy\*`) implement every endpoint above with these shapes, and `docker/Caddyfile` additionally rewrites `/prod/api/*` and `/staging/api/*` in case an older APK is still installed somewhere. Feature tests in `tests/Feature/Api/LegacyApiTest.php` exercise the login shape, the year fields, device-generated codes and the raw spinner values.

## 5. Codes and the local database

**Code generation.** On creating an application the app computes `partner_prefix + "-" + collector_prefix + "-" + (last_increment_no + 1)`, for example `TDH-MICH-7`, stores the incremented counter in preferences and uses that string as the server `code`. The counter starts from the value the server returned at login (the collector's application count) and is only corrected at the next login. Two devices, or the app and the web form, can therefore produce the same code. This is the race the technical document warned about.

The child's code shown in the form is a different string: `year + "-" + partner_prefix + "-" + collector_prefix + "-" + n`, for example `2025-TDH-MICH-7`. This explains the "2021-ROB-MICH-1" format in the 2021 guidance note. The year is the reporting year chosen in the form and is also sent as the `year` parameter.

**SQLite (`sqd.db`, version 1).** Tables:

- `application`: one row per application with every questionnaire column of the server's `application_value` table plus `user_id`, `api_id` (server id), `status`, `status_name`, `synced` (0/1), `language`, `type`.
- `gouvernate`, `caza`, `area`: reference data with `api_id`, English and Arabic names.
- `junction`: links a local pre-test row to its post-test row (`pre_id`, `pre_synced`, `post_id`, `post_synced`, `code`).

Local status names are set by the app itself (`Pre Test Pending`, `Pre Test Completed`, `Post Test Pending`, `Done`, `Dropout`) and overwritten by the server's `status_name` on the next refresh. Scores are never computed on the device.

**Sync and conflicts.** There is no conflict resolution. Synced rows are deleted and reloaded from the server whenever the app opens online, so the server always wins once a row has been pushed. Unsynced rows are pushed in status order with timers rather than callbacks, so a slow connection can push a post-test before its pre-test has been accepted. No retry queue exists beyond "try again next time the dashboard opens".

## 6. Differences between the app, the web form and the documents

| Topic | Android app | Legacy web form | New platform |
|---|---|---|---|
| Category spelling | Child Marriage Activity, Violent Discipline Activity | Child Mariage Activity, Violent Discipline  Activity (double space) | Canonical app spelling; legacy spellings normalised |
| Gender | Male / Female | male / female | lower case; both accepted |
| Consent | Yes, permission is given / No, permission is not given | yes / no | yes / no; both accepted |
| Gateway types | 13 values incl. Border crossing, Remotely, Other | 11 values incl. "Border crossing, Other" | App list; legacy value mapped to Border crossing |
| Agency | Dropdown of 37 NGOs plus Other | Partner name, read only | Free text up to 50 chars; the app list is published for the new client |
| Services | 4 services plus "No" | 4 services | "No" is dropped on input |
| Year | Reporting year selector, sent with each test | Not sent | Stored on the application; defaults to the pre-test year |
| Code on server | PARTNER-COLLECTOR-N from the device | Server generated | Server generated for new clients; device code honoured for the old app |
| Item wording | Caregiver wording (6-11) and self-report wording (12-17), English and Arabic | Caregiver wording only | Both wordings available from `docs/mobile-app/strings.en-ar.md` |

## 7. Risks in the current app

- Debug build, debug signing key, cleartext traffic allowed and a debugging bridge that exposes the SQLite database and preferences (including the API token) to anyone with USB access to the device.
- Token in plain text in shared preferences and sent as a form field on every request.
- Connectivity check by shelling out to `ping`, which fails on devices where ICMP is blocked, leaving the app permanently "offline".
- Timer-based sync ordering and no idempotency: a retried submit can create duplicates on the server.
- Reference data is downloaded once per login and never refreshed, so new areas added on the web do not reach devices until the collector logs out.
- `targetSdk 29` will be rejected by Google Play and by recent Android versions for sideloading restrictions; the app is already past its support window.

## 8. Specification for the rebuilt mobile app

Everything below is already supported by `/api/v1` (`docs/API.md`).

1. **Platform.** Flutter or React Native, Android first with iOS possible; minimum Android 8. Store distribution through managed Google Play or an MDM, signed with a UNICEF-controlled key.
2. **Authentication.** Email and password against `POST /api/v1/auth/login`, Sanctum bearer token stored in the platform keystore, logout revokes the token. Read-only accounts can view but not create.
3. **Reference data.** `GET /api/v1/reference` cached locally with its version; refreshed on every app start when online, not only at login.
4. **Application list.** `GET /api/v1/applications?updated_since=` for incremental refresh; tabs identical to today (pre-pending, post-pending, done, dropped out) plus search by code and year filter.
5. **Forms.** Same field order and option lists as today (section 3), both wordings by form type, English and Arabic with right-to-left layout, Arabic digit handling, GPS capture with manual override, draft saving. Validation mirrors the server rules (`App\Http\Requests\TestRequest`) so errors are caught before sync.
6. **Codes.** Generated by the server. A new application is created with a client-side UUID (`client_uuid`) so the request can be retried safely; the server returns the code. The child's code displayed to the collector is the server code.
7. **Sync.** A local queue of pending changes pushed through `POST /api/v1/sync` in one batch, ordered pre-test then post-test per application, idempotent by `client_uuid`. Server responses mark rows synced or record the validation error against the row so the collector can fix it. No deletion of local rows until the server has confirmed them.
8. **Security.** HTTPS only, certificate pinning optional, no debug tooling in release builds, encrypted local database (SQLCipher or platform equivalent), remote wipe of local data on logout.
9. **Telemetry.** Crash reporting and anonymous usage counts only; no child data in logs.

## 9. Transition plan for devices in the field

1. Keep `sdq-12.apk` working against the new platform through the legacy routes (done; verified by tests). Any draft left on a device will sync when it next opens online.
2. Ask partners to open the app once while online before the new app is rolled out, so local queues are flushed.
3. Release the new app; the legacy routes can be switched off once the activity log shows no `app_version=12` traffic for 30 days.
