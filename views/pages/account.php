<?php
/** @var array|null $user */
$user = $user ?? null;
?>

<div class="mb-4">
    <h2 class="h4">Dein Account</h2>
    <p class="text-muted small">Hier siehst du deine gespeicherten Profildaten.</p>
</div>

<?php if (is_array($user)): ?>
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h3 class="h6 mb-2">Benutzerinformationen</h3>
            <p class="mb-1"><strong>Name:</strong> <?= htmlspecialchars($user['name'] ?? '-', ENT_QUOTES, 'UTF-8') ?></p>
            <p class="mb-1"><strong>E-Mail:</strong> <?= htmlspecialchars($user['email'] ?? '-', ENT_QUOTES, 'UTF-8') ?></p>
            <p class="mb-1"><strong>User-ID:</strong> <?= htmlspecialchars($user['id'] ?? '-', ENT_QUOTES, 'UTF-8') ?></p>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-warning">Kein Benutzer eingeloggt.</div>
<?php endif; ?>

<a href="/logout" class="btn btn-outline-danger btn-sm">Logout</a>
