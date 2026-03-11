<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <h2 class="h4 mb-3">Login</h2>
        <p class="text-muted small">Dies ist ein Dummy-Login. Die Eingaben werden nicht geprüft.</p>

        <form method="post" action="/login" class="card card-body border-0 shadow-sm">
            <div class="mb-3">
                <label for="username" class="form-label">Benutzername</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="z.B. Max" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Passwort</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="beliebiges Passwort" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Einloggen</button>
        </form>
    </div>
</div>
