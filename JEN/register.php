<?php
require_once 'connection.php';
require_once 'includes/auth.php';
requireGuest();

$error = '';
$name = '';
$email = '';
$birthdate = '';
$gender = '';
$city = '';
$role = 'participant';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $birthdate = trim($_POST['birthdate'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $role = $_POST['role'] ?? 'participant';
    $password = $_POST['password'] ?? '';
    $passwordConfirmation = $_POST['password_confirmation'] ?? '';

    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $birthdate === '' || $gender === '' || $city === '' || !in_array($role, ['participant', 'admin'], true)) {
        $error = 'Complete all participant details with a valid email address.';
    } elseif (strlen($password) < 8) {
        $error = 'Your password must be at least 8 characters.';
    } elseif ($password !== $passwordConfirmation) {
        $error = 'The passwords do not match.';
    } else {
        $statement = $conn->prepare('SELECT p.participants_id FROM participants p WHERE p.email = :email LIMIT 1');
        $statement->execute(['email' => $email]);

        if ($statement->fetch()) {
            $error = 'An account with that email already exists.';
        } else {
            try {
                $conn->beginTransaction();

                $nameParts = preg_split('/\s+/', $name, 2);
                $firstName = $nameParts[0];
                $lastName = $nameParts[1] ?? '';

                $statement = $conn->prepare('INSERT INTO participants (first_name, last_name, email, birthdate, gender, city) VALUES (:first_name, :last_name, :email, :birthdate, :gender, :city)');
                $statement->execute([
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'birthdate' => $birthdate,
                    'gender' => $gender,
                    'city' => $city,
                ]);
                $participantId = $conn->lastInsertId();

                $statement = $conn->prepare('INSERT INTO users (name, password_hash, role) VALUES (:name, :password_hash, :role)');
                $statement->execute([
                    'name' => $name,
                    'password_hash' => password_hash($password, PASSWORD_DEFAULT),
                    'role' => $role,
                ]);
                $userId = $conn->lastInsertId();

                $statement = $conn->prepare('UPDATE participants SET user_id = :user_id WHERE participants_id = :participants_id');
                $statement->execute([
                    'user_id' => $userId,
                    'participants_id' => $participantId,
                ]);

                $conn->commit();
                header('Location: login.php?registered=1');
                exit;
            } catch (PDOException $exception) {
                if ($conn->inTransaction()) {
                    $conn->rollBack();
                }

                $error = 'We could not create your account. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create account | EventDesk</title>
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
        <div class="page-kicker">Get started</div>
        <h1 class="h2 fw-bold mb-2">Create your account</h1>
        <p class="text-secondary mb-4">Set up access to your event management workspace.</p>
        <?php if ($error): ?><div class="alert alert-danger" role="alert"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
        <form method="post" novalidate>
            <div class="mb-3"><label class="form-label" for="name">Full name</label><input class="form-control" id="name" name="name" type="text" value="<?php echo htmlspecialchars($name); ?>" required autofocus></div>
            <div class="mb-3"><label class="form-label" for="email">Email</label><input class="form-control" id="email" name="email" type="email" value="<?php echo htmlspecialchars($email); ?>" required></div>
            <div class="mb-3"><label class="form-label" for="birthdate">Birthdate</label><input class="form-control" id="birthdate" name="birthdate" type="date" value="<?php echo htmlspecialchars($birthdate); ?>" required></div>
            <div class="mb-3"><label class="form-label" for="gender">Gender</label><input class="form-control" id="gender" name="gender" type="text" value="<?php echo htmlspecialchars($gender); ?>" required></div>
            <div class="mb-3"><label class="form-label" for="city">City</label><input class="form-control" id="city" name="city" type="text" value="<?php echo htmlspecialchars($city); ?>" required></div>
            <div class="mb-3"><label class="form-label" for="role">Account role</label><select class="form-select" id="role" name="role" required><option value="participant" <?php echo $role === 'participant' ? 'selected' : ''; ?>>Participant</option><option value="admin" <?php echo $role === 'admin' ? 'selected' : ''; ?>>Admin</option></select></div>
            <div class="mb-3"><label class="form-label" for="password">Password</label><input class="form-control" id="password" name="password" type="password" minlength="8" required></div>
            <div class="mb-4"><label class="form-label" for="password_confirmation">Confirm password</label><input class="form-control" id="password_confirmation" name="password_confirmation" type="password" minlength="8" required></div>
            <button class="btn btn-primary w-100" type="submit">Create account</button>
        </form>
        <p class="text-center text-secondary mt-4 mb-0">Already registered? <a href="login.php">Log in</a></p>
    </section>
</main>
</body>
</html>
