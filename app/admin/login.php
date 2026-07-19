<?php
/** Admin login. */
require_once __DIR__ . '/_layout.php';

if (is_admin()) {
    header('Location: ' . admin_url(''));
    return;
}
if (!admin_exists()) {
    header('Location: ' . admin_url('setup'));
    return;
}

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify_post();
    if (admin_login(trim($_POST['username'] ?? ''), (string) ($_POST['password'] ?? ''))) {
        header('Location: ' . admin_url(''));
        return;
    }
    $err = 'Incorrect username or password.';
}

admin_head('Login');
?>
<h2 class="page">Admin Login</h2>
<div class="card" style="max-width:420px">
  <?php if ($err): ?><div class="flash err"><?= e($err) ?></div><?php endif; ?>
  <form method="post">
    <?= csrf_field() ?>
    <label>Username</label><input type="text" name="username" required autofocus>
    <label>Password</label><input type="password" name="password" required>
    <p style="margin-top:18px"><button class="btn" type="submit">Log in</button></p>
  </form>
</div>
<?php admin_foot();
