<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <h2 class="h4 mb-3">Login</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form method="post" action="/login" class="card card-body border-0 shadow-sm mb-4">
            <div class="mb-3">
                <label for="login_email" class="form-label">E-Mail</label>
                <input type="email" class="form-control" id="login_email" name="email" placeholder="E-Mail" required>
            </div>
            <div class="mb-3">
                <label for="login_password" class="form-label">Passwort</label>
                <input type="password" class="form-control" id="login_password" name="password" placeholder="Passwort" required>
            </div>
            <button type="submit" name="login" value="1" class="btn btn-primary w-100">Einloggen</button>
        </form>
        <p>Noch keinen Account? <a href="/sign-up">Hier registrieren</a></p>
                
    </div>
</div>
