<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Service\PasswordResetService;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = trim($_POST['email']);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $resetService = new PasswordResetService();
        $token = $resetService->createResetToken($email);
        if ($token) {
            // Mail versenden (Mailhog)
            $resetLink = sprintf('http://%s/reset-password.php?token=%s', $_SERVER['HTTP_HOST'], $token);
            $subject = 'Passwort zurücksetzen';
            $message = "Hallo,\n\nKlicke auf folgenden Link, um dein Passwort zurückzusetzen:\n$resetLink\n\nFalls du das nicht warst, ignoriere diese E-Mail.";
            $headers = "From: noreply@example.com\r\nContent-Type: text/plain; charset=UTF-8";
            mail($email, $subject, $message, $headers);
        }
    }
    // Immer auf Login-Seite weiterleiten, egal ob E-Mail existiert
    header('Location: /login?reset=1');
    exit;
}

$success = null;
$error = null;
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Passwort vergessen</title>
</head>
<body>
    <h1>Passwort vergessen</h1>
    <?php if ($success): ?>
        <p style="color: green;"><?= htmlspecialchars($success) ?></p>
    <?php elseif ($error): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="post" action="/forgot-password.php">
        <label for="email">E-Mail-Adresse:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Link zum Zurücksetzen senden</button>
    </form>
</body>
</html>
