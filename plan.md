# dec-expenses / IncomeFlow Implementation Plan

## Summary

`dec-expenses` will be reworked from a basic expense tracker into **IncomeFlow**, a personal income management app for internships, part-time work, freelance contracts, honorariums, transportation reimbursements, and reimbursable expenses.

The app should not compete with household budget tools such as Money Forward. Its purpose is to manage the income side that is currently tracked in Excel:

- When income was earned or paid.
- Who paid it.
- Whether it was salary, freelance income, internship pay, honorarium, or undecided.
- How much was base pay, transportation, expenses, and actual bank transfer.
- Which payer is used for year-end adjustment.
- Monthly and yearly totals by contract type and payer.

The portfolio value is **practical financial workflow design, data modeling, aggregation, and reporting**. This app should feel like a small but useful operations tool built from a real personal need.

## Product Definition

### One-line Description

IncomeFlow is a personal income tracker for students and early-career developers who need to manage internship pay, freelance rewards, part-time salary, transportation reimbursement, and yearly income summaries.

### Target Users

- Students doing summer internships or short-term paid work.
- Developers with freelance or業務委託 income.
- People who receive honorariums, reimbursements, and transportation payments from multiple organizations.
- Users who already use a household budgeting app but need a clearer income-side ledger.

### Demo Scenario

1. Open the dashboard and see this month's expected transfer amount.
2. Add a new income record for a summer internship.
3. Enter payer, contract type, base amount, transportation, expense reimbursement, and transfer amount.
4. Mark whether the payer is the year-end adjustment payer.
5. Filter records by payer and contract type.
6. Open monthly summary and compare salary, freelance, transportation, expenses, and transfer totals.
7. Open yearly summary and see totals that can be used for tax and year-end review preparation.

## Current State

### Existing Strengths

- Laravel app already exists.
- The current app can create and delete amount records.
- Records already have date, category, and amount.
- Category seed data exists.
- The current UI has a simple list and pagination.

### Gaps Before Portfolio Use

- The app is still positioned as an expense tracker.
- It does not model income, payer, contract type, transportation, expenses, or transfer amount.
- There is no edit flow.
- There are no monthly or yearly summaries.
- README still describes the original school assignment.
- There are no tests for the money-recording workflow.

## Development Rules

- Keep Laravel and Blade.
- Do not add external bank, credit card, or Money Forward integration.
- Do not implement tax calculation or legal judgment.
- Treat this as a personal ledger and preparation tool.
- Keep the implementation small but polished.
- Prefer explicit data models over clever generic category logic.
- Use integer yen amounts.
- Make import/export a later milestone after the core model is stable.

## Milestone 0: Repository Hygiene

Prepare the project for the new direction.

Tasks:

- Add this `plan.md`.
- Rewrite README around IncomeFlow.
- Explain that the project started as an expense tracker and is being reworked into income management.
- Document the Excel-origin use case.
- Confirm local setup steps.

Done:

- GitHub readers understand that this is an income management app, not a household budget clone.
- README links to this plan.

## Milestone 1: IncomeFlow Branding

Rebrand the product and first screen.

Tasks:

- Rename UI text from expense tracking to IncomeFlow.
- Replace the current single-page title with a product dashboard.
- Add navigation for `Dashboard`, `Income Records`, `Payers`, `Monthly Summary`, and `Yearly Summary`.
- Keep the UI simple and practical.
- Remove assignment-style language from visible app screens.

Done:

- The app immediately communicates income, payers, and reimbursements.
- The UI no longer looks like a classroom CRUD assignment.

## Milestone 2: Income Domain Model

Replace the expense-first model with income records.

Tasks:

- Add `income_records` table.
- Add fields:
  - `earned_on`
  - `payer_id`
  - `contract_type`
  - `base_amount`
  - `transportation_amount`
  - `expense_amount`
  - `transfer_amount`
  - `is_year_end_adjustment_payer`
  - `memo`
- Add `payers` table with:
  - `name`
  - `default_contract_type`
  - `default_year_end_adjustment`
  - `memo`
- Use fixed contract types:
  - `salary`
  - `freelance`
  - `internship`
  - `honorarium`
  - `undecided`
- Keep old `expenses` table untouched initially or migrate later after the new flow is stable.

Done:

- The Excel columns can be represented in the database.
- Income records can support base pay, transportation, expenses, and actual transfer amount separately.

## Milestone 3: CRUD And Validation

Build the practical entry workflow.

Tasks:

- Create income record list.
- Create income record form.
- Add edit and delete.
- Add payer creation/edit flow.
- Auto-fill contract type and year-end adjustment setting from payer defaults.
- Validate:
  - date is required
  - payer is required
  - contract type is required
  - money fields are non-negative integers
  - transfer amount is non-negative
- If transfer amount is blank, default it to base + transportation + expenses.

Done:

- A new internship or freelance payment can be entered quickly.
- Existing records can be corrected.
- The app is usable without touching the database manually.

## Milestone 4: Filtering And Search

Make past income easy to inspect.

Tasks:

- Filter income records by year, month, payer, contract type, and year-end adjustment flag.
- Add keyword search over payer name and memo.
- Sort by earned date descending by default.
- Add quick filters:
  - this month
  - this year
  - internships
  - freelance
  - transportation included
  - year-end adjustment payer

Done:

- The user can quickly find a summer internship payment, transportation reimbursement, or freelance reward.

## Milestone 5: Monthly And Yearly Summaries

Turn entries into reports.

Tasks:

- Add monthly summary page.
- Add yearly summary page.
- Summarize by:
  - salary total
  - freelance total
  - internship total
  - honorarium total
  - transportation total
  - expense reimbursement total
  - transfer total
- Add payer-level totals.
- Add month-over-month table.
- Highlight months with no records.

Done:

- The Excel monthly summary can be reproduced in the app.
- The user can see total transfer amount and income breakdown without spreadsheet formulas.

## Milestone 6: Internship And Reimbursement Workflow

Support the new summer internship use case.

Tasks:

- Add optional `work_period_start` and `work_period_end` for records that cover a period.
- Add optional `transportation_route_memo`.
- Add optional `receipt_status` with:
  - `not_needed`
  - `pending`
  - `submitted`
  - `accepted`
- Add a reimbursement-focused filter for transportation or expense records.
- Show reimbursement checklist on dashboard.

Done:

- Summer internship income and transportation reimbursements can be tracked clearly.
- Records that need receipt submission are easy to find.

## Milestone 7: Excel / CSV Import And Export

Make the app useful alongside existing spreadsheets.

Initial import should be CSV, not native Excel parsing.

Tasks:

- Define CSV columns matching the current Excel sheet:
  - date
  - payer
  - contract_type
  - base_amount
  - transportation_amount
  - expense_amount
  - transfer_amount
  - is_year_end_adjustment_payer
  - memo
- Add CSV export for filtered records.
- Add monthly summary CSV export.
- Add import preview before saving.
- Validate rows and show row-level errors.

Done:

- Existing Excel data can be moved through CSV.
- Filtered records can be exported for backup or later tax preparation.

## Milestone 8: Portfolio Finish

Make the repository presentable.

Tasks:

- Add `DemoSeeder` with sample payers and income records.
- Include examples for part-time salary, freelance income, honorarium, and summer internship transportation.
- Add README sections:
  - problem setting
  - why this is not a household budget app
  - data model
  - monthly/yearly aggregation
  - demo steps
  - screenshots
  - future work
- Add feature tests for create, edit, delete, filtering, and summaries.
- Add 3-minute demo script.

Done:

- The project is understandable as a practical income management app.
- `php artisan test` passes.
- The demo can be reproduced from seed data.

## Future Ideas

- Native `.xlsx` import.
- Tax preparation checklist.
- Expected payment vs actual transfer reconciliation.
- Attachment upload for receipts.
- Calendar view for expected payment dates.
- Alerts for missing transportation receipts.
- Private notes for payer-specific contract details.
- Optional LLM summary that explains income trends from the user's own records.

## Public Routes

Target routes:

- `/`: dashboard
- `/income-records`: record list
- `/income-records/create`: create record
- `/income-records/{record}`: detail
- `/income-records/{record}/edit`: edit record
- `/payers`: payer list
- `/payers/create`: create payer
- `/monthly-summary`: monthly summary
- `/yearly-summary`: yearly summary
- `/imports/csv`: CSV import
- `/exports/csv`: CSV export

Compatibility:

- Existing expense routes can remain temporarily, but the product-facing routes should use income language.

## Test Plan

Feature tests:

- User can create an income record.
- User can edit an income record.
- User can delete an income record.
- Blank transfer amount defaults to base + transportation + expense.
- Records can be filtered by payer.
- Records can be filtered by contract type.
- Records can be filtered by month and year.
- Monthly summary totals salary, freelance, transportation, expenses, and transfer amount.
- Yearly summary totals by contract type and payer.
- CSV import preview validates rows before saving.

Unit tests:

- Transfer amount default calculation.
- Contract type labels.
- Monthly aggregation.
- Yearly aggregation.
- Payer default values.

Manual verification:

- `php artisan migrate:fresh --seed`
- Create a salary record.
- Create a freelance record.
- Create an internship record with transportation.
- Confirm monthly summary matches manual calculation.
- Export CSV and confirm columns match the planned format.

## Assumptions

- Money Forward remains the household expense management tool.
- IncomeFlow focuses only on income, reimbursements, and preparation records.
- Amounts are stored as integer yen.
- Tax and legal advice are out of scope.
- CSV import/export comes before native Excel support.
- This project should be smaller than `dec-camjyo` and `dec-laratter`, but polished enough to show practical data modeling and aggregation.
