# Documentation index

All documentation available for the Measuring Well-Being (SDQ) platform, retained in the repository so the migration work has a single reference point.

| File | What it is | Date |
|---|---|---|
| `original/SDQ_Technical_Doc_2020-03-31.pdf` | Technical handover doc by the original developer: architecture, local setup, routing, API list, Android build, code-generation logic, cron jobs. | 2020-03-31 |
| `original/SDQ_Guidance_Note_2021_Eng_Revised.docx` | UNICEF / CPiEWG guidance note: how and when to administer the SDQ, sampling, coding rules, and a full user manual of the dashboard and Android app (admin, partner, collector roles). | 2021 |
| `original/SDQ_Scoring_Explanation.docx` | The scoring formula used by the platform (scale = average of items x 5 + 0.5, NA omitted, total excludes pro-social). | n/a |
| `original/Measuring_Wellbeing_SDQ_Description_2022-05-08.docx` | Programme description: purpose, indicator measured, adoption figures (12 organisations, 3,350+ entries), technologies used. | 2022-05-08 |
| `original/Inter-Agency_Coordination_Lebanon_Logo_Guidelines_2014.pdf` | UNHCR Inter-Agency Coordination Lebanon logo and brand guidelines (logo signatures, clear space, Pantone 300, Helvetica). Relevant for the redesigned UI. | 2014-10 |

Text extractions of the Word and PDF documents live in `extracted-text/` so they can be searched and diffed. Images are omitted there; open the originals for screenshots.

The system review and migration assessment is in [`SYSTEM_REVIEW_REPORT.md`](SYSTEM_REVIEW_REPORT.md).

## Security note

The original technical PDF (page 11) contains a plaintext FTP username and password for the GoDaddy production server. The text extraction redacts the password. The credential should be treated as compromised and rotated, and the FTP account should be retired once the Azure migration completes.

## Migration status

Option A ("evolve") was chosen on 2026-10-18. The modernised application lives at the repository root, the original under `legacy/`. Progress and open decisions are tracked in the root [README.md](../README.md) status table. Supporting documents:

- [ARCHITECTURE.md](ARCHITECTURE.md): target design, scoring policy, code generation, sync, environments.
- [MIGRATION_RUNBOOK.md](MIGRATION_RUNBOOK.md): export, restore, verification, UAT, cutover, rollback.
- [OPERATIONS.md](OPERATIONS.md): logs, deployments, scaling, backups, secrets, common failures.
- [../infra/README.md](../infra/README.md): Azure resources, one-time setup, CI/CD identity, costs.
