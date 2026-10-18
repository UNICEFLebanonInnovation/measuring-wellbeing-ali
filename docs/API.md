# Measuring Well-Being API

Two HTTP APIs are served by the application:

| API | Base path | Auth | Audience |
|---|---|---|---|
| **v1** | `/api/v1` | Bearer token (Laravel Sanctum) | The new mobile application and any future integration. |
| **Legacy** | `/api/*` | `token` request parameter | The Android APK already in the field. Kept unchanged so devices keep working until they are updated. Do not build anything new on it. |

All responses are JSON. Successful responses have the shape `{"success": true, "data": ..., "message": "..."}`. Error responses have `{"success": false, "message": "...", "errors": {...}}` (v1) or `{"success": false, "message": "...", "data": {...}}` (legacy, HTTP 404 as the original app expected). Validation failures on v1 use Laravel's standard `422` body: `{"message": "...", "errors": {"field": ["..."]}}`. Business-rule violations (quota reached, test already submitted, read-only account) return `422` with `{"success": false, "message": "..."}`.

Rate limit: 120 requests per minute per user (per IP for unauthenticated calls); login endpoints are limited to 10 per minute.

---

## API v1

### Authentication

`POST /api/v1/auth/login`

```json
{ "email": "collector1@akkar.akkar", "password": "secret", "device_name": "Samsung tablet 12" }
```

Response `200`:

```json
{
  "success": true,
  "data": {
    "token": "12|AbCd...",
    "token_type": "Bearer",
    "user": {
      "id": 44, "name": "Collector One", "firstname": "Collector", "lastname": "One",
      "email": "collector1@akkar.akkar", "phone": "...", "roles": ["collector"],
      "is_readonly": false, "locale": "en",
      "partner": { "user_id": 12, "name": "Akkar", "prefix": "AKK", "max_app_per_year": 240 },
      "collector": { "prefix": "C1", "city": "Halba" }
    }
  },
  "message": "Welcome! Collector"
}
```

Send the token on every other call as `Authorization: Bearer <token>`. Tokens do not expire but are revoked by `POST /api/v1/auth/logout` or when an administrator deactivates the account. `401` is returned for wrong credentials or inactive accounts, `403` for accounts that are neither collectors nor partners (administrators use the web UI).

`GET /api/v1/auth/me` returns the same `user` object.

### Reference data

`GET /api/v1/reference` returns everything the app needs for offline work in one payload:

```json
{
  "success": true,
  "data": {
    "statuses": [{ "id": 2, "name": "Pre Test" }, ...],
    "forms": [{ "id": 1, "name": "Form 6-11" }, { "id": 2, "name": "Form 12-17" }],
    "governorates": [
      { "id": 1, "name": "Akkar", "arabic": "عكار",
        "cazas": [ { "id": 3, "name": "Akkar", "arabic": "عكار",
                     "areas": [ { "id": 3, "name": "Aadouiye", "arabic": "عدوي" } ] } ] }
    ],
    "options": { "forms": [...], "categories": [...], "donors": [...], "genders": [...], "nationalities": [...],
                 "gateway_types": [...], "dropout_reasons": [...], "services": [...], "decrease_reasons": [...],
                 "answers": ["0", "1", "2", "na"], "items": ["considerate_of_other_peoples_feelings", ...] },
    "scoring": { "policy": "documented", "max_na_answers": 3 },
    "version": "<sha1>"
  }
}
```

The response carries an `ETag` header equal to `version`. Send it back as `If-None-Match`; the server answers `304 Not Modified` when nothing changed, so the app can refresh reference data cheaply on every start.

### Applications

An **application** is one child's SDQ record. It moves through the statuses `Pre Test` → `Pre Test Pending` (draft) → `Post Test` (pre-test submitted) → `Post Test Pending` (draft) → `Done`, or ends in `Dropout`, `NA` (more than 3 "na" answers), `Pre Test No Permission` / `Post Test No Permission` (consent refused).

`GET /api/v1/applications?updated_since=2026-01-01T00:00:00Z&status=&per_page=50&page=1`

Paginated list of the applications visible to the user (a collector sees their own; a partner sees all of their collectors'). Each item:

```json
{
  "id": 101, "code": "2026-AKK-C1-7", "client_uuid": "0d2b...", "year": 2026, "language": "ar",
  "status": "Post Test", "status_id": 5, "partner_id": 12, "collector_id": 44,
  "pre_test_date": "2026-03-10", "post_test_date": null, "change": null,
  "pre_test": { "type": "pre_test", "form": "Form 6-11", "category": "...", "age": "8", "gender": "female",
                "gouvarnate": "1", "caza": "3", "area": "3", "may_i_start_now": "yes",
                "answers": { "considerate_of_other_peoples_feelings": "1", ... 25 items ... },
                "scores": { "emotional_scale": 5.5, "conduct_scale": 5.5, "hyper_activity_scale": 5.5,
                            "peer_problem_scale": 5.5, "pro_social_scale": 5.5, "na_count": 0, "total": 22 },
                "updated_at": "2026-03-10T10:15:00+03:00" },
  "post_test": null,
  "created_at": "...", "updated_at": "..."
}
```

`GET /api/v1/applications/{id}` returns one application (`403` if it belongs to someone else).

`POST /api/v1/applications`

```json
{ "client_uuid": "0d2b5c1e-8f4a-4e2b-9a4d-1c2e3f4a5b6c", "language": "ar" }
```

Creates an empty application and **generates the code on the server** (`YEAR-PARTNERPREFIX-COLLECTORPREFIX-N`). `client_uuid` is a UUID generated by the device when the child record is first created offline. The call is idempotent: the first call returns `201`, any repeat with the same uuid returns `200` with the same application. The device must store the returned `id` and `code` and show the code to the collector; devices never invent codes. Returns `422` when the partner's yearly quota is reached and `403` for read-only accounts.

`PUT /api/v1/applications/{id}/pre-test` and `PUT /api/v1/applications/{id}/post-test`

Body: the questionnaire fields plus `"submit": "save"` (draft) or `"submit": "submit"` (final; default). Field names are the legacy column names, listed under `options.items` in the reference payload. Required when `may_i_start_now` is `yes`: `form`, `category`, `agency_name`, `donor_name`, `interview_date` (not in the future), `interviewers_name`, `age` (6–11 for "Form 6-11", 12–17 for "Form 12-17"), `gender`, `nationality` (+ `other_nationality`), `gouvarnate`, `caza`, `area` (ids), `gateway_type`, and on submit all 25 items with values `"0"`, `"1"`, `"2"` or `"na"`. Optional: `p_code`, `latitude`, `longitude`, `altitude`, `accuracy`, `child_code`, `comment`, `do_the_child_receive_any_other_child_protection_services` (array). Post-test additionally requires `dropout_reason`, `number_of_hours_that_the_child_attended` and `total_number_of_hours_in_your_program` on submit. When `may_i_start_now` is `no` nothing else is required and the application is closed as "no permission".

Scores are computed by the server on submit and returned in `scores`; the device must not compute or send scores. A submitted test cannot be edited again (`422`).

### Offline sync

`POST /api/v1/sync` uploads a batch of locally stored applications in one request:

```json
{
  "applications": [
    { "client_uuid": "0d2b...", "language": "ar",
      "pre_test": { "...questionnaire fields...", "submit": "submit" },
      "post_test": { "...questionnaire fields...", "submit": "save" } },
    { "client_uuid": "7e1a...", "pre_test": { "...": "...", "submit": "submit" } }
  ]
}
```

Rules:

1. Each item is processed independently and identified by `client_uuid`. The application is created when the uuid is unknown, otherwise the existing one is used. Resending a batch after a lost connection is safe.
2. `pre_test` and `post_test` are applied in that order, each only when the application's current status allows it. A stage that is no longer editable (already submitted) is reported as `skipped`, not as an error, so re-sent data never overwrites a submitted questionnaire.
3. Validation uses the same rules as the single-application endpoints. A failing stage is reported as `error` with the field messages and the application keeps its previous state.
4. At most 200 items per request.

Response:

```json
{ "success": true, "data": { "results": [
  { "client_uuid": "0d2b...", "id": 101, "code": "2026-AKK-C1-7", "status": "Post Test Pending",
    "result": "created", "errors": [],
    "stages": { "pre_test": { "result": "updated", "submitted": true },
                "post_test": { "result": "updated", "submitted": false } } },
  { "client_uuid": "7e1a...", "id": 102, "code": "2026-AKK-C1-8", "status": "Pre Test",
    "result": "error", "errors": [ { "age": ["The age field must be between 6 and 11."] } ],
    "stages": { "pre_test": { "result": "error", "errors": { "age": ["..."] } } } }
] }, "message": "Sync processed" }
```

`result` per item is `created` (new application), `updated` (existing application changed), `skipped` (nothing to apply) or `error`. After a successful sync the device should replace its local copy with the data from `GET /api/v1/applications` (use `updated_since` for incremental refresh).

---

## Legacy API (current Android app)

All endpoints accept any HTTP method and read parameters from the query string or form/JSON body, exactly like the original application. Authenticated endpoints require `token` (the `api_token` returned by login). Errors are returned with HTTP `404` and `{"success": false, "message": "..."}`, with `data` holding validation messages when relevant.

| Endpoint | Purpose |
|---|---|
| `POST /api/login` `{email, password}` | Returns `data` with the user row plus `api_token` (50 characters, replaced on every login), `collector_prefix`, `partner_prefix`, `partner_name`, `last_increment_no` (number of applications this collector has) and `message: "Welcome! <firstname>"`. Errors: `User does not exists`, `Your account is inactive`, `Invalid credentials`, `Collector not found or unauthorized user`, `Partner Prefix not added`, `Collector Prefix not added`. |
| `/api/logout` `{token}` | Invalidates the token. |
| `/api/forgot-password` `{email}` | Sends a password set-up link. |
| `/api/get-all-locations` | `{gouvernates, caza, area}` arrays (no token needed). |
| `/api/get-gouvernate`, `/api/get-caza` `{gouvernate_id}`, `/api/get-area` `{caza_id}`, `/api/get-status` | Reference lists. |
| `/api/create-application` `{token}` | Creates an application with a **server-generated** code (`YEAR-PARTNER-COLLECTOR-N`) and returns the application row with `status_name`. |
| `/api/save-pre-test-application`, `/api/submit-pre-test-application` `{token, code, ...fields}` | Draft / final pre-test. The application is looked up by `code`. **If the code is unknown it is created on the server and the device's code is kept** (the field app generates codes itself); this is the only place client codes are accepted. Responses: application row + message (`Application submitted as pre test.`, `Application saved as pre test draft.`, `Application submitted as NA`, `Application Pre Test No Permission`). Re-submitting a submitted pre-test returns the legacy error `Values cannot be changed after pre test application submitted.` |
| `/api/save-post-test-application`, `/api/submit-post-test-application` `{token, code, ...fields}` | Same for the post-test; the code must exist. |
| `/api/get-application` `{token, status?}` | `{application_count, application: [...]}`; each item has `status_name`, `form`, `gouvername_name`, `caza_name`, `pre_test` and `post_test` rows. Applications in `NA` and `Pre Test No Permission` are hidden, as before. |
| `/api/view-application` `{token, code}` | `{application, pre_test, post_test}` with location names. |
| `/api/pre-test-application`, `/api/post-test-application` `{token, code}` | `{preTestObj, forms, gouvernates}` (creates the empty value row if missing, as the original did). |

Differences from the original implementation, on purpose: validation is stricter (option values must be from the published lists, locations must exist), scores follow the documented formula, the yearly quota and read-only flag are enforced through the shared workflow service, and codes created by `/api/create-application` include the year. Clients that compare `last_increment_no` with their own counter keep working because the server never reuses a code.

---

## Scoring reminder (both APIs)

Scale = average of the answered items of the scale × 5 + 0.5, with `na` items omitted; the total difficulties score is the sum of the emotional, conduct, hyperactivity and peer-problem scales (pro-social excluded). More than 3 `na` answers in one questionnaire sets the application to status `NA`. A lower post-test total than pre-test is reported as `Increase` (improvement), a higher one as `Decrease`.
