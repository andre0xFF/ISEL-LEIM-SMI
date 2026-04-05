# Authentication Example Changes

## Scope

This note summarizes the changes made so far in `07-Auth/Ver3` while adapting the example for user registration.

## Files Changed

### `formLogin.php`

- Added `require_once("../../06-Forms/regex.php");` to reuse the regex constants already created in the forms example.
- Removed the old commented `nextUrl` form action lines from active use.
- Added HTML5 validation to the login inputs:
  - `username` now uses `required`
  - `username` now uses `pattern="<?= htmlspecialchars(ALIAS_REGEX, ENT_QUOTES) ?>"`
  - `password` now uses `required`
  - `password` now uses `pattern="<?= htmlspecialchars(PASS_REGEX, ENT_QUOTES) ?>"`

### `formRegister.php`

- Created a new registration form page based on the structure of the existing login form.
- Added `require_once("../../06-Forms/regex.php");` so the same regex constants can be reused.
- Configured the form to submit to `processFormRegister.php`.
- Added the following fields:
  - `username`
  - `email`
  - `password`
- Added HTML5 validation:
  - `username` uses `required` and `ALIAS_REGEX`
  - `email` uses `type="email"` and `required`
  - `password` uses `required` and `PASS_REGEX`
- Updated the submit button label to `Register`.

### `processFormRegister.php`

- Created the initial processing script for registration.
- Added the base includes:
  - `../../Lib/lib.php`
  - `../../Lib/db.php`
  - `../../06-Forms/regex.php`
- Added request method detection for `POST` and `GET`, following the same pattern used by `processFormLogin.php`.
- Added input reading for:
  - `username`
  - `password`
  - `email`
- Added trimming of the submitted values before validation.
- Added initial server context reading:
  - `SERVER_NAME`
  - `serverPort`
  - `webAppName()`
  - `baseUrl`
- Added server-side validation scaffolding:
  - username validation against `ALIAS_REGEX` via `toPhpRegex(...)`
  - password validation against `PASS_REGEX` via `toPhpRegex(...)`
  - email validation with `FILTER_VALIDATE_EMAIL`
- Added duplicate checks for username and email using `existUserField(...)`.
- Added collection of validation errors into an array.
- Added rendering of the validation errors as an HTML list with `implode(...)`.
- Added `redirectToLastPage("Registration Error", $message, 5)` when validation fails.
- Added a first call to `createInactiveUser(...)` when validation succeeds.

### `lib.php`

- Added a new helper function `createInactiveUser(string $username, string $password, string $email)`.
- The helper currently:
  - rejects empty values
  - connects to the database
  - inserts a new row into `auth-basic` with `active = 0`
  - returns the inserted `idUser` with `mysqli_insert_id(...)`

## Current Status

The client-side form layer is now in place for both login and registration.

`processFormRegister.php` is still incomplete. It currently reads the submitted values, but it does not yet:

- insert the new user in `auth-basic`
- create a role in `auth-permissions`
- generate and save an activation token in `auth-challenge`
- send the confirmation email
- activate the account through a confirmation endpoint

## Notes

- The regex constants come from `../../06-Forms/regex.php`.
- `htmlspecialchars(..., ENT_QUOTES)` is being used when placing regex values into HTML `pattern` attributes so the value is safely escaped for HTML output.
- `processFormLogin.php` has no functional change so far beyond formatting.
