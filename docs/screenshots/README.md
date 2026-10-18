# Screenshots of the modernised application

Captured from the local development build with the fictional demo data of `database/seeders/DemoDataSeeder.php` (4 partners, 8 collectors, 61 applications). Desktop captures are 1366 px wide; the last two are at phone width (390 px).

| File | Page |
|---|---|
| `00-login.png` | Sign-in page with language switch |
| `01-dashboard.png` | Admin dashboard: totals and applications per partner with quota |
| `02-applications.png` | Applications list with filters, sorting, change indicator and CSV export |
| `03-partners.png` | Partner management |
| `04-partner-detail.png` | Partner detail with quota usage and collectors |
| `05-collectors.png` | Collector management |
| `06-analytics-index.png` | Analytics catalogue |
| `07-report-improvement-rate.png` | Improvement rate (programme indicator) per partner |
| `08-report-scale-comparison.png` | Average SDQ scale scores, pre-test against post-test |
| `09-report-governorate.png` | Governorate analysis by change and gender |
| `10-change-decrease.png` | Change-decrease follow-up with partner explanations |
| `11-activity-log.png` | Activity log |
| `12-locations.png` | Governorate, caza and area management |
| `13-dashboard-arabic.png` | Dashboard in Arabic (right-to-left layout) |
| `14-applications-arabic.png` | Applications list in Arabic |
| `20-collector-applications.png` | Collector view of their own applications |
| `21-application-detail.png` | Application detail: scores, history, pre-test and post-test answers |
| `22-pre-test-form.png` | Pre-test form with consent, child details and the 25-item questionnaire |
| `30-mobile-applications.png` | Phone width |
| `31-mobile-menu.png` | Phone width with the navigation drawer open |

To regenerate: run the app locally with the demo seeder (`php artisan migrate:fresh --seed && php artisan db:seed --class=DemoDataSeeder`) and capture the pages listed above.
