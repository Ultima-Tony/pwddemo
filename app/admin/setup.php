<?php
/** One-time, self-locking admin setup. Safe to leave on the server. */
require_once __DIR__ . '/_layout.php';

// Permanently locked once any admin has a password.
if (admin_exists()) {
    admin_head('Setup');
    echo '<h2 class="page">Setup complete</h2>';
    echo '<div class="card"><p>An administrator account already exists, so setup is locked.</p>';
    echo '<p><a class="btn" href="' . e(admin_url('login')) . '">Go to login</a></p></div>';
    admin_foot();
    return;
}

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify_post();
    $user = trim($_POST['username'] ?? '');
    $pw   = (string) ($_POST['password'] ?? '');
    $pw2  = (string) ($_POST['password2'] ?? '');
    if ($user === '' || strlen($user) < 3) {
        $err = 'Choose a username of at least 3 characters.';
    } elseif (strlen($pw) < 8) {
        $err = 'Password must be at least 8 characters.';
    } elseif ($pw !== $pw2) {
        $err = 'Passwords do not match.';
    } else {
        // Double-check nobody set a password meanwhile (race / lock).
        if (admin_exists()) {
            $err = 'Setup is already locked.';
        } else {
            $stmt = db()->prepare('INSERT INTO admins (username, password_hash) VALUES (?, ?)');
            $stmt->execute([$user, password_hash($pw, PASSWORD_DEFAULT)]);
            admin_login($user, $pw);
            header('Location: ' . admin_url(''));
            return;
        }
    }
}

admin_head('Setup');
?>
<h2 class="page">Create your admin account</h2>
<div class="card">
  <p class="muted">This runs once. After you set a password, this page locks itself permanently.</p>
  <?php if ($err): ?><div class="flash err"><?= e($err) ?></div><?php endif; ?>
  <form method="post" autocomplete="off">
    <?= csrf_field() ?>
    <label>Username</label><input type="text" name="username" required minlength="3" value="<?= e($_POST['username'] ?? 'admin') ?>">
    <label>Password</label><input type="password" name="password" required minlength="8">
    <label>Confirm password</label><input type="password" name="password2" required minlength="8">
    <p style="margin-top:18px"><button class="btn" type="submit">Create account &amp; lock setup</button></p>
  </form>
</div>
<?php admin_foot();
