<?php
/** @var array|null $user */
$user = $user ?? null;
$name = is_array($user) ? ($user['name'] ?? 'Unbekannter Benutzer') : 'Unbekannter Benutzer';
?>

<div class="mb-4">
    <h2 class="h4">Dein Account</h2>
    <p class="text-muted small">Dies ist eine einfache Dummy-Account-Seite.</p>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h3 class="h6 mb-2">Benutzerinformationen</h3>
        <p class="mb-1"><strong>Name:</strong> <?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?></p>
        <p class="mb-0 text-muted small">Später kannst du hier weitere Profildaten anzeigen oder bearbeiten.</p>
    </div>
</div>

<a href="/logout" class="btn btn-outline-danger btn-sm">Logout</a>
