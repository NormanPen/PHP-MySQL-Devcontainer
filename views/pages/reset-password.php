<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Service\PasswordResetService;
use App\Service\UserService;

$success = null;
$error = null;
$showForm = false;
$token = $_GET['token'] ?? '';

if ($token) {
    $pdo = \App\Database\Connection::getPdo();
    // Token prüfen
    $stmt = $pdo->prepare('SELECT pr.id, pr.user_id, pr.expires_at, pr.used_at, u.email FROM password_resets pr JOIN users u ON pr.user_id = u.id WHERE pr.token = ? LIMIT 1');
    $stmt->execute([$token]);
    $row = $stmt->fetch();
    if ($row && !$row['used_at'] && strtotime($row['expires_at']) > time()) {
        $showForm = true;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
            $password = $_POST['password'];
            if (strlen($password) < 6) {
                $error = 'Das Passwort muss mindestens 6 Zeichen lang sein.';
            } else {
                // Passwort setzen
                $userService = new UserService($pdo);
                $userId = $row['user_id'];
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $pdo->prepare('UPDATE users SET password_hash = ? WHERE id = ?')->execute([$hash, $userId]);
                // Token als benutzt markieren
                $pdo->prepare('UPDATE password_resets SET used_at = NOW() WHERE id = ?')->execute([$row['id']]);
                $success = 'Das Passwort wurde erfolgreich geändert. Du kannst dich jetzt einloggen.';
                $showForm = false;
            }
        }
    } else {
        $error = 'Der Link ist ungültig oder abgelaufen.';
    }
} else {
    $error = 'Kein Token angegeben.';
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Passwort zurücksetzen</title>
</head>
<body>
    <h1>Passwort zurücksetzen</h1>
    <?php if ($success): ?>
        <p style="color: green;"><?= htmlspecialchars($success) ?></p>
        <p><a href="/sign-in.php">Zum Login</a></p>
    <?php elseif ($error): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <?php if ($showForm): ?>
        <form method="post">
            <label for="password">Neues Passwort:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Passwort setzen</button>
        </form>
    <?php endif; ?>
</body>
</html>
