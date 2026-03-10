<?php
// $view ist z.B. 'pages/home.php' und wird von index.php übergeben
// $data ist ein assoziatives Array mit Variablen für die View

/** @var string|null $view */
/** @var array $data */

$data = $data ?? [];
if (!is_array($data)) {
	$data = [];
}

// Variablen für View und Layout verfügbar machen (z.B. $title, $page)
extract($data, EXTR_SKIP);

// View-Pfad ermitteln
$baseDir = __DIR__;
$viewFile = $view ? $baseDir . DIRECTORY_SEPARATOR . $view : null;
?>

<!doctype html>
<html lang="de">
<head>
	<meta charset="utf-8">
	<title><?= htmlspecialchars($title ?? 'Meine PHP-Seite', ENT_QUOTES, 'UTF-8') ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="/styles/main.css">
</head>
<body>
	<?php require $baseDir . '/layouts/header.php'; ?>

	<main class="py-4">
		<div class="container">
			<div class="row">
				<?php
				// Sidebar nur auf der Exercises-Seite anzeigen
				$showSidebar = isset($page) && $page === 'exercises';
				?>
				<?php if ($showSidebar): ?>
					<aside class="col-md-3 col-lg-2 mb-4">
						<?php require $baseDir . '/layouts/sidebar.php'; ?>
					</aside>
					<section class="col-md-9 col-lg-10">
				<?php else: ?>
					<section class="col-12">
				<?php endif; ?>
					<?php
					if ($viewFile && is_file($viewFile)) {
						require $viewFile;
					}
					?>
				</section>
			</div>
		</div>
	</main>

	<?php require $baseDir . '/layouts/footer.php'; ?>

	<script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
