<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom mb-4">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="/">
                <?= htmlspecialchars($title ?? 'Meine PHP-Seite', ENT_QUOTES, 'UTF-8') ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Navigation umschalten">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link<?= (isset($page) && $page === 'home') ? ' active' : '' ?>" href="/">Startseite</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?= (isset($page) && $page === 'about') ? ' active' : '' ?>" href="/about">Über</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?= (isset($page) && $page === 'exercises') ? ' active' : '' ?>" href="/exercises">Übungen</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
