# 06-Forms — Changes Report

This document describes all modifications made relative to the original example files provided in `originalExamples/`, and maps each change to the corresponding requirement from the practical class PDF (_AulaPratica-01-FormulariosHTML_JavaScript_AJAX-PT.pdf_).

---

## PDF Requirements Overview

The assignment specified the following tasks:

1. **Implement client-side form validation** using the `onSubmit()` event or HTML5 `required` attribute.
2. **Use regular expressions** for input validation.
3. **Ensure client-side and server-side validation rules are identical** (same regex on both ends).
4. **Load postal codes from the database** instead of using hardcoded values.
5. **Read file upload settings from the database** instead of hardcoding them.

---

## New Files

### `regex.php`
**Not present in the originals.** This file is the single source of truth for all validation patterns.

- Defines PHP constants for each field's validation rule:
  - `NAME_REGEX` — name: 3–50 alphabetic chars (with accents/unicode)
  - `EMAIL_REGEX` — standard email format
  - `ALIAS_REGEX` — alias: 3–15 alphanumeric/underscore chars
  - `PASS_REGEX` — password: 6–15 chars, must contain at least one letter and one digit
- Provides `toPhpRegex($pattern, $modifiers = '')` — a wrapper that converts a bare regex string into a PHP-compatible delimited pattern (e.g., `~pattern~u`). The optional `$modifiers` parameter was added to support the `u` (unicode) flag needed for name validation.

**Addresses requirement 3:** all validation rules originate here and are shared by both client and server.

---

### `varsLogin.php` and `varsProfile.php`
**Replaces the original `vars.php`** (which only exported a single unrelated PHP variable `$x` to JavaScript).

Both files serve as PHP-generated JavaScript modules:
- They `require_once("regex.php")` to access the shared constants.
- They set `Content-Type: application/javascript` so browsers load them as scripts.
- They serialize the relevant regex constants into a `window.formPatterns` object using `json_encode()`, which handles escaping automatically.
  - `varsLogin.php` exposes: `formPatterns.name` and `formPatterns.email`
  - `varsProfile.php` exposes: `formPatterns.alias` and `formPatterns.password`

**Addresses requirement 3:** the PHP-defined regex constants are injected into the browser at page load, so JavaScript uses the exact same rules as PHP.

---

## Modified Files

### `forms.js`

#### Before
- Hardcoded email regex at the top of the file (`var filter = /^.../`).
- `FormLoginValidator()` validated only name (not-blank check) and email (hardcoded regex).
- `FormUpdateProfileValidator()` was an unimplemented stub:
  ```js
  // Home work for the students!
  ```

#### After
- **Removed hardcoded regex.** The old commented-out `filter` variables were replaced with four `RegExp` objects built from `window.formPatterns`, which is populated by `varsLogin.php` or `varsProfile.php` at load time:
  ```js
  var nameFilter     = new RegExp(window.formPatterns.name);
  var emailFilter    = new RegExp(window.formPatterns.email);
  var aliasFilter    = new RegExp(window.formPatterns.alias);
  var passwordFilter = new RegExp(window.formPatterns.password);
  ```
- **`FormLoginValidator()` updated:**
  - Name is now validated against `nameFilter` (regex-based, with `.trim()`), replacing the original blank-only check.
  - Email validated against `emailFilter` (same behavior, but now sourced from `window.formPatterns`).
- **`FormUpdateProfileValidator()` fully implemented** (was a stub):
  - Alias: validated with `aliasFilter` (3–15 alphanumeric/underscore).
  - Password: validated with `passwordFilter` (6–15 chars, letters + digit required).
  - Age: checks that at least one of the four radio buttons is selected.
  - District: checks the select is not empty.
  - County: checks the select is not empty.
  - Zip-code: checks the select is not empty.
  - Comments: checks length does not exceed 200 characters.

**Addresses requirements 1, 2, and 3.**

---

### `formLogin.php`

#### Before
- Included `gera.php` as a script (which called `xpto()` on load).
- No `required` attributes on input fields.

#### After
- Replaced `gera.php` with `varsLogin.php` (loaded before `forms.js`) so regex patterns are available when the validator runs.
- Added `required` to both `name` and `email` inputs as a first-pass browser-native guard.
- `onsubmit="return FormLoginValidator(this)"` was already present in the original and was kept.

**Addresses requirements 1 and 3.**

---

### `formUpdateProfile.php`

#### Before
- Did not load `gera.php` or any vars script.
- No `onsubmit` handler on the form.
- File upload max sizes were hardcoded in HTML (`value="131072"` and `value="65536"`).

#### After
- Loads `varsProfile.php` before `forms.js` to expose alias/password regex to the client.
- Added `onsubmit="return FormUpdateProfileValidator(this)"` to the form element.
- File upload max sizes are now **read from the database** (`forms-upload-settings` table, `max_file_size_photo` and `max_file_size_user` settings) and rendered dynamically into the `MAX_FILE_SIZE` hidden inputs and the label text.
- `required` attributes are present on alias, password, age (first radio), district, county, and zip selects.

**Addresses requirements 1, 3, and 5.**

---

### `processFormLogin.php`

#### Before
- Validated name with only `FILTER_UNSAFE_RAW` (no regex check on name).
- Errors were displayed inline with no structured collection.
- Redirect on error went back to the page but error messages were mixed with raw HTML output.

#### After
- `require_once("regex.php")` to use the shared constants.
- Name validated with `preg_match(toPhpRegex(NAME_REGEX, 'u'), $name)` — same pattern used by the client.
- Errors collected in an `$errors` array; all messages are listed before redirecting.
- On failure: redirects back to `formLogin.php` after 5 seconds via `meta refresh`.
- On success: displays name and email, and links to `formUpdateProfile.php`.

**Addresses requirements 2 and 3.**

---

### `processFormUpdateProfile.php`

#### Before
- No server-side validation of any profile fields (alias, password, age, location, comments).
- Upload destination hardcoded as `/tmp/upload/`.
- File size limits hardcoded.
- Used `copy()` + `unlink()` for file handling.
- Did not use `basename()` on the uploaded filename.

#### After
- `require_once("regex.php")` to use shared constants.
- **Full server-side validation** matching the client rules:
  - Alias: `preg_match(toPhpRegex(ALIAS_REGEX), $alias)`
  - Password: `preg_match(toPhpRegex(PASS_REGEX), $password)`
  - Age: `in_array($age, ['R1','R2','R3','R4'], true)`
  - District, county, zip: empty-string checks.
  - Comments: `strlen($comments) > 200`
- On validation failure: redirects back to `formUpdateProfile.php` after 5 seconds with all error messages listed.
- **Upload settings read from the database** (`forms-upload-settings` table):
  - `upload_dir` — destination directory
  - `max_file_size_photo` — max size for the photo upload
  - `max_file_size_user` — max size for the user image upload
- `handleFile()` uses **`move_uploaded_file()`** instead of `copy()` + `unlink()`, which is the correct PHP API: it verifies the file is a genuine HTTP upload and prevents temp file leaks.
- Uses **`basename()`** on the original filename to strip any path components and prevent directory traversal attacks.

**Addresses requirements 2, 3, and 5.**

---

### `getZips.php`

#### Before
- Hardcoded response: only returned data for `county=5` AND `district=11` (3 hardcoded zip codes), and returned an empty option for everything else.

#### After
- Validates both `county` and `district` parameters as positive integers.
- Queries the database (`forms-postal-codes` or equivalent table) dynamically based on the provided district and county IDs.
- Returns a JSON array of matching zip codes from the database.

**Addresses requirement 4.**

---

## Summary Table

| Requirement | Files Changed |
|---|---|
| 1. Client-side validation (`onSubmit` / `required`) | `formLogin.php`, `formUpdateProfile.php`, `forms.js` |
| 2. Regex-based validation | `regex.php` (new), `forms.js`, `processFormLogin.php`, `processFormUpdateProfile.php` |
| 3. Identical client & server validation rules | `regex.php`, `varsLogin.php` (new), `varsProfile.php` (new), `forms.js`, `processFormLogin.php`, `processFormUpdateProfile.php` |
| 4. Postal codes from database | `getZips.php` |
| 5. Upload settings from database | `formUpdateProfile.php`, `processFormUpdateProfile.php` |