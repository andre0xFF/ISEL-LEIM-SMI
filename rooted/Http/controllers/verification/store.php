<?php

// TODO: Implement verification code validation.
//
// Example implementation:
//
//   $code = $_POST['code'] ?? '';
//
//   if ($code !== $_SESSION['verification_code']) {
//       $errors['code'] = 'Invalid verification code.';
//       return view('verification/show.view.php', [
//           'heading' => 'Verify',
//           'errors' => $errors
//       ]);
//   }
//
//   $_SESSION['user']['verified'] = true;
//   redirect('/');

redirect("/");
