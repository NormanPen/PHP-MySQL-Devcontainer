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

        <h2 class="h5 mb-3">Registrieren</h2>
        <form method="post" action="/login" class="card card-body border-0 shadow-sm">
            <div class="mb-3">
                <label for="register_name" class="form-label">Name</label>
                <input type="text" class="form-control" id="register_name" name="reg_name" placeholder="Vorname Nachname" required>
            </div>
            <div class="mb-3">
                <label for="register_email" class="form-label">E-Mail</label>
                <input type="email" class="form-control" id="register_email" name="reg_email" placeholder="E-Mail" required>
            </div>
            <div class="mb-3">
                <label for="register_password" class="form-label">Passwort</label>
                <input type="password" class="form-control" id="register_password" name="reg_password" placeholder="Passwort" required>
            </div>
            <button type="submit" name="register" value="1" class="btn btn-secondary w-100">Registrieren</button>
        </form>
    </div>
</div>
