# Authentication Example Changes

## Scope

This note tracks what was changed in `07-Auth/Ver3` relative to the original `07-Auth` example, and what is still missing for the user-registration exercise from `AulaPratica-02-RegistoUtilizadores_Image_Email-PT`.

## Changes Made vs Original

### `formLogin.php`

- Added `require_once("../../06-Forms/regex.php");` to reuse the regex constants from the forms example.
- Added HTML5 validation to the login inputs:
  - `username` now uses `required`
  - `username` now uses `pattern="<?= htmlspecialchars(ALIAS_REGEX, ENT_QUOTES) ?>"`
  - `password` now uses `required`
  - `password` now uses `pattern="<?= htmlspecialchars(PASS_REGEX, ENT_QUOTES) ?>"`

### `index.php`

- Added a second entry point to the authentication example so the user can open the registration form.
- The page now links to:
  - `formLogin.php`
  - `formRegister.php`

### `formRegister.php`

- Created a new registration form page based on the existing login page structure.
- Added `require_once("../../06-Forms/regex.php");`.
- Configured the form to submit to `processFormRegister.php`.
- Added these fields:
  - `username`
  - `email`
  - `password`
  - `captcha`
- Added HTML5 validation:
  - `username` uses `required` and `ALIAS_REGEX`
  - `email` uses `type="email"` and `required`
  - `password` uses `required` and `PASS_REGEX`
  - `captcha` uses `required`
- Added CAPTCHA image rendering through `../../08-Images/captchaImage.php`.

### `processFormRegister.php`

- Expanded the server-side registration handler.
- Added includes for:
  - `../../Lib/lib.php`
  - `../../Lib/db.php`
  - `../../06-Forms/regex.php`
  - `../../Lib/lib-mail-v2.php`
- Added request-method handling for `POST` and `GET`.
- Added input reading and trimming for:
  - `username`
  - `password`
  - `email`
  - `captcha`
- Added server-side validation for:
  - username format
  - password format
  - email format
- Added CAPTCHA validation against `$_SESSION['captcha']`.
- Added CAPTCHA cleanup through `unset($_SESSION['captcha']);` after validation.
- Added duplicate checks for username and email through `existUserField(...)`.
- Added error aggregation and `redirectToLastPage("Registration Error", $message, 5)` on validation failure.
- Added a success-path call to `createInactiveUser(...)`.
- Added a check for user-creation failure and an error redirect when insertion fails.
- Added sender-account loading through `getEmailAccountById(2)` before creating the user and token.
- Added activation-token creation through `createActivationToken(...)`.
- Added activation URL generation through `getCurrentBaseUrl()`.
- Added a call to `sendAuthEmail(...)` with the activation link.
- Added rollback calls after later registration failures through:
  - `deleteInactiveUserById(...)` when token creation fails
- Added cleanup on mail-send failure through:
  - `deleteActivationTokenByUserId(...)`
  - `deleteInactiveUserById(...)`
- Added a redirect to `registerPending.php` after the registration e-mail is sent.

### `activateAccount.php`

- Added token input reading from `$_GET['token']`.
- Added token lookup through `getUserIdByActivationToken(...)`.
- Added an invalid-token redirect path.
- Added default-role lookup through `getIdRoleByName("user")`.
- Added role-existence checks through `userHasRole(...)` so repeated activation links do not try to assign the same role twice.
- Added an "already activated" success path that retries activation-token deletion and redirects to `formLogin.php`.
- Added activation through `activateUserById(...)`.
- Added role assignment through `assignRoleToUser(...)`.
- Added rollback to inactive through `deactivateUserById(...)` when role assignment fails after activation.
- Added deletion of the activation token through `deleteActivationTokenByUserId(...)` after successful activation.
- Added a redirect to `formLogin.php` after activation.

### `registerPending.php`

- Added request-method handling for `POST` and `GET`.
- Added reading of the `email` argument passed by `processFormRegister.php`.
- Added output escaping through `htmlspecialchars(...)` before rendering the e-mail in HTML.
- Added a confirmation page informing the user that an activation e-mail was sent.
- Added a fallback message when no e-mail argument is available.
- Added a link to `formLogin.php`.

### `Lib/lib.php`

- Added `createInactiveUser(...)`.
  - rejects empty values
  - inserts a new record into `auth-basic`
  - sets `active = 0`
  - returns the inserted `idUser`
- Added `createActivationToken(...)`.
  - generates a token
  - inserts it into `auth-challenge`
  - returns the generated token
- Added `getEmailAccountById(...)`.
  - loads an SMTP account from `email-accounts`
  - normalizes `port`, `timeout`, and `useSSL`
- Added `getCurrentBaseUrl()`.
  - derives the current base URL from the request scheme, host, and script directory
- Added `getUserIdByActivationToken(...)`.
  - looks up the token in `auth-challenge`
  - returns the associated `idUser`
- Added `activateUserById(...)`.
  - updates `auth-basic.active` from `0` to `1`
- Added `deleteActivationTokenByUserId(...)`.
  - removes the stored token for a given user
- Added `deleteInactiveUserById(...)`.
  - removes an inactive user record by `idUser`
- Added `assignRoleToUser(...)`.
  - inserts the selected role into `auth-permissions` for the user
- Added `getIdRoleByName(...)`.
  - resolves a role id from `auth-roles.friendlyName`
- Added `deactivateUserById(...)`.
  - updates `auth-basic.active` from `1` back to `0`
- Added `userHasRole(...)`.
  - checks whether a user already has a specific role in `auth-permissions`

## Current Behavior

### Registration failure

- Validation errors redirect back with an error message.
- Missing SMTP account configuration redirects back with an error message before any user or token is created.
- User-creation failure redirects back with an error message.
- Token-creation failure deletes the inactive user, then redirects back with an error message.
- Mail-send failure deletes the stored activation token and the inactive user, then redirects back with an error message.

### Registration success

- The new user is inserted into `auth-basic` as inactive.
- An activation token is inserted into `auth-challenge`.
- A confirmation e-mail is sent with a link to `activateAccount.php?token=...`.
- The user is redirected to `registerPending.php`.
- `registerPending.php` shows a confirmation message with the destination e-mail address when available.

### Activation

- `activateAccount.php` now reads the token from the activation URL.
- The token is resolved to an `idUser` through `getUserIdByActivationToken(...)`.
- If the token is invalid, the user is redirected to `formRegister.php`.
- The default `user` role is looked up in `auth-roles`.
- If the user already has that role, the flow treats the account as already activated, retries token deletion, and redirects to `formLogin.php` with a success message.
- The matching user is activated by setting `auth-basic.active = 1`.
- If the user does not yet have the `user` role, it is inserted into `auth-permissions`.
- If role assignment fails after activation, the user is reverted back to inactive.
- The activation token is deleted after a successful activation flow.
- The user is redirected to `formLogin.php`.

## Missing vs Exercise Requirements

The practical sheet requires this flow:

1. Collect user data in a registration form, including e-mail.
2. Send a confirmation e-mail containing an activation link.
3. Let the user activate the account and then access protected content.

The current `Ver3` implementation is still missing:

- Proper logging/reporting for internal cleanup failures such as token-deletion failure.

## Important Consequence

- New users cannot log in immediately after registration because login only accepts users with `active = 1`.
- Since `createInactiveUser(...)` stores new users with `active = 0`, the activation flow is required before `processFormLogin.php` can succeed for them.

## Optional Work

- CAPTCHA is now integrated into the registration form and checked server-side using the reusable material from `08-Images`.

## Workflow Note

- When this example is rechecked later, update this file with the new delta against the original `07-Auth` example before reporting the findings.
