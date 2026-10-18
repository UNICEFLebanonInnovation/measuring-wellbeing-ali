# Measuring Well-Being – mobile application

The new Android application replaces `sdq-12.apk` (see `docs/MOBILE_APP_ANALYSIS.md` for what the old app did). It is a Flutter application that lives in `mobile/`, keeps the same name and logo, signs in with the collector's email and password, and talks only to the v1 API documented in `docs/API.md`. It is distributed as an APK (no Play Store).

## What the collector gets

| Area | Behaviour |
|---|---|
| Sign in | Email + password against `POST /api/v1/auth/login`. The server address is `https://measuringwellbeing.org` by default and can be changed on the sign-in screen (for staging). The Sanctum token is kept in Android's encrypted storage; the session survives restarts. |
| Dashboard | Four tabs — **Pre-test**, **Post-test**, **Done**, **Closed** (dropout, NA, no permission) — with a search-by-code field, a year filter, counts per tab, an online/offline banner, the time of the last sync and the number of applications still to upload. Pull to refresh runs a sync. |
| New application | The device generates a `client_uuid`; the **code is assigned by the server** at the first sync (`YEAR-PARTNER-COLLECTOR-N`). Until then the card shows "Pending sync". The quota per partner and year is enforced server-side. |
| Pre-test / post-test | One questionnaire screen for both: consent script (caregiver wording for Form 6-11, self-report wording for Form 12-17, in English or Arabic), consent yes/no, interview details, child details, governorate → caza → area cascade from the reference payload, optional GPS capture, the 25 SDQ items, programme attendance and dropout reason (post-test), other services and comments. **Save draft** keeps the application in "Pending"; **Submit** locks the stage. Validation mirrors the server rules before anything is sent. |
| Detail page | Status, pending badge, server rejection message if any, child summary, pre/post scores and the Increase/Decrease outcome as computed by the server. Scores are never computed on the device. |
| Settings | Language (English / Arabic with full RTL), manual full sync, sign out, version. |
| Offline | Everything is stored in an SQLCipher-encrypted SQLite database (key generated per device and kept in secure storage). Collectors can work for days without a connection; the app syncs automatically when it opens online, after each save when online, and on demand. |

### Sync rules (device side)

1. Records without a server id are uploaded in batches of 50 through `POST /api/v1/sync`. `created`/`updated` clears the pending flag and stores the id, code and status; `skipped` (stage already submitted on the server) clears the flag too; `error` keeps the stage pending and shows the server's field messages on the card so the collector can fix and resend.
2. Records that already have a server id use `PUT /applications/{id}/pre-test|post-test`. A business-rule `422` ("cannot be changed after submission") drops the stale local edit and reloads the server copy.
3. `GET /applications?updated_since=` then refreshes the local copies without overwriting a stage that still has local changes.
4. `GET /reference` is called with `If-None-Match`; locations and option lists are cached until the server's ETag changes.
5. A `401` anywhere signs the device out; unsynced data is kept and sent after the next sign in by the same user. Signing in as a different user wipes the local database.

## Project layout

```
mobile/
├── lib/
│   ├── main.dart, app/            # bootstrap, Riverpod providers, go_router routes
│   ├── core/                      # build-time config, theme (brand colours)
│   ├── data/api/api_client.dart   # Dio client for /api/v1
│   ├── data/local/                # secure session store, SQLCipher database, preferences
│   ├── data/models/               # UserProfile, ReferenceData, ApplicationRecord/TestData
│   ├── domain/                    # SDQ catalogue (items, options, consent text), statuses,
│   │                              # validation rules, local workflow transitions
│   ├── services/                  # SyncService, LocationService
│   ├── features/                  # auth, dashboard, application (detail + form), settings
│   └── l10n/                      # app_en.arb, app_ar.arb (generated AppLocalizations)
├── test/                          # validation, workflow, sync engine, login widget tests
└── android/                       # Gradle project; release signing from key.properties or env
```

State management is Riverpod (no code generation); navigation is go_router with an auth redirect; HTTP is Dio; storage is `sqflite_sqlcipher` + `flutter_secure_storage`.

## Building

Prerequisites: Flutter 3.47 (Dart 3.13), Android SDK with build-tools 35, JDK 17.

```bash
cd mobile
flutter pub get
flutter gen-l10n
flutter analyze && flutter test
flutter build apk --release --dart-define=API_BASE_URL=https://measuringwellbeing.org
# -> build/app/outputs/flutter-apk/app-release.apk
```

`API_BASE_URL` is only the default; the collector can still change the address on the sign-in screen.

### Release signing

Create the keystore once and keep it (and its passwords) outside the repository — losing it means devices cannot upgrade in place:

```bash
keytool -genkey -v -keystore measuring-wellbeing.jks -keyalg RSA -keysize 2048 -validity 10000 -alias measuring-wellbeing
```

Locally, put `android/key.properties` next to the Gradle project:

```
storeFile=/absolute/path/measuring-wellbeing.jks
storePassword=...
keyAlias=measuring-wellbeing
keyPassword=...
```

`key.properties` and `*.jks` are git-ignored. Without a keystore the build falls back to the debug key, which is fine for testing but not for distribution.

### GitHub Actions

`.github/workflows/mobile.yml` runs on every change under `mobile/`:

1. **Analyse and test** – `dart format` check, `flutter analyze --fatal-infos`, `flutter test`.
2. **Build release APK** – signed with the keystore from the repository secrets, uploaded as the `measuring-wellbeing-apk` artifact (kept 90 days). Pushing a tag `mobile-vX.Y.Z` also attaches the APK to a GitHub release, which is the download link to give to partners.

Secrets to add under *Settings → Secrets and variables → Actions*:

| Secret | Value |
|---|---|
| `ANDROID_KEYSTORE_BASE64` | `base64 -w0 measuring-wellbeing.jks` |
| `ANDROID_KEYSTORE_PASSWORD` | keystore password |
| `ANDROID_KEY_ALIAS` | `measuring-wellbeing` |
| `ANDROID_KEY_PASSWORD` | key password |

The workflow can also be started by hand (*Run workflow*) with a different default server address, for a staging build.

## Rolling out

1. Deploy the new backend (the legacy `/api/*` keeps the old APK working during the transition).
2. Build and publish the APK from a `mobile-v2.0.0` tag; share the release link or host the file under `/apk/` as before.
3. Collectors finish syncing on the old app, install the new one and sign in with the same email and password.
4. Once every partner has moved, the legacy API can be switched off (`docs/ARCHITECTURE.md`).

## Not included (on purpose)

- No Play Store listing, no iOS build.
- No password reset in the app: the web platform's "forgot password" email flow is used.
- No on-device scoring; all scores, statuses and codes come from the server.
