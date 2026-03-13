 <div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <h2 class="h4 mb-3">Login</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <h2 class="h5 mb-3">Registrieren</h2>
        <form method="post" action="/login" class="card card-body border-0 shadow-sm">
            <div class="mb-3">
                <label for="register_firstname" class="form-label">Vorname</label>
                <input type="text" class="form-control" id="register_firstname" name="reg_firstname" placeholder="Vorname" required>
            </div>
            <div class="mb-3">
                <label for="register_lastname" class="form-label">Nachname</label>
                <input type="text" class="form-control" id="register_lastname" name="reg_lastname" placeholder="Nachname" required>
            </div>
            <div class="mb-3">
                <label for="register_email" class="form-label">E-Mail</label>
                <input type="email" class="form-control" id="register_email" name="reg_email" placeholder="E-Mail" required>
            </div>
            <div class="mb-3">
                <label for="register_password" class="form-label">Passwort</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="register_password" name="reg_password" placeholder="Passwort" required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword" tabindex="-1">
                        <span id="togglePasswordIcon" class="bi bi-eye"></span>
                    </button>
                </div>
            </div>
            <div class="mb-3">
                <label for="register_password_repeat" class="form-label">Passwort wiederholen</label>
                <input type="password" class="form-control" id="register_password_repeat" name="reg_password_repeat" placeholder="Passwort wiederholen" required>
            </div>
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const pw = document.getElementById('register_password');
                const pwRepeat = document.getElementById('register_password_repeat');
                const toggle = document.getElementById('togglePassword');
                const icon = document.getElementById('togglePasswordIcon');
                const form = document.querySelector('form[action="/login"]');
                if (toggle) {
                    toggle.addEventListener('click', function() {
                        const type = pw.type === 'password' ? 'text' : 'password';
                        pw.type = type;
                        pwRepeat.type = type;
                        icon.className = type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
                    });
                }
                if (form) {
                    form.addEventListener('submit', function(e) {
                        if (pw.value !== pwRepeat.value) {
                            e.preventDefault();
                            pwRepeat.classList.add('is-invalid');
                            if (!document.getElementById('pw-mismatch')) {
                                const msg = document.createElement('div');
                                msg.className = 'invalid-feedback';
                                msg.id = 'pw-mismatch';
                                msg.innerText = 'Die Passwörter stimmen nicht überein.';
                                pwRepeat.parentNode.appendChild(msg);
                            }
                        } else {
                            pwRepeat.classList.remove('is-invalid');
                            const msg = document.getElementById('pw-mismatch');
                            if (msg) msg.remove();
                        }
                    });
                }
            });
            </script>
            <button type="submit" name="register" value="1" class="btn btn-secondary w-100">Registrieren</button>
        </form>

        </div>
    </div>