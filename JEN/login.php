<?php
require_once 'connection.php';
require_once 'includes/auth.php';
requireGuest();

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $statement = $conn->prepare('SELECT u.user_id, u.name, u.password_hash, u.role, p.email
        FROM users u
        INNER JOIN participants p ON p.user_id = u.user_id
        WHERE p.email = :email
        LIMIT 1');
    $statement->execute(['email' => $email]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'user_id' => $user['user_id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];
        header('Location: dashboard.php');
        exit;
    }

    $error = 'The email or password is incorrect.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in | EventDesk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/app.css" rel="stylesheet">
</head>
<body>
<main class="auth-shell">
    <div class="d-flex justify-content-end mb-3">
        <?php include 'includes/theme-toggle.php'; ?>
    </div>
    <div class="auth-mark">EventDesk</div>
    <section class="auth-card">
        <div class="page-kicker">Welcome back</div>
        <h1 class="h2 fw-bold mb-2">Log in to your workspace</h1>
        <p class="text-secondary mb-4">Manage events, people, and registrations in one place.</p>
        <?php if ($error): ?><div class="alert alert-danger" role="alert"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
        <form method="post" novalidate>
            <div class="mb-3"><label class="form-label" for="email">Email</label><input class="form-control" id="email" name="email" type="email" value="<?php echo htmlspecialchars($email); ?>" required autofocus></div>
            <div class="mb-4"><label class="form-label" for="password">Password</label><input class="form-control" id="password" name="password" type="password" required></div>
            <button class="btn btn-primary w-100" type="submit">Log in</button>
        </form>
        <p class="text-center text-secondary mt-4 mb-0">New here? <a href="register.php">Create an account</a></p>
    </section>
</main>
</body>
</html>
