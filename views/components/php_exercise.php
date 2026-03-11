<?php
// Wiederverwendbare Komponente für einen PHP-Code-Editor mit Ausführung in der Sandbox.
// Erwartet:
// - $exerciseId (string): ID der Übung (Schlüssel in config/exercises.php)
// - $initialCode (string): Start-Code, der im Editor angezeigt wird
// Optional:
// - $heading (string): Überschrift über dem Block

use App\Service\ExerciseChecker;
use App\Repository\ConfigExerciseRepository;

$executionOutput = null;
$executionError  = null;
$checkResult     = null;
$code            = $_POST['code'] ?? '';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    if ($code !== '') {
        $sandboxUrl = getenv('SANDBOX_EVAL_URL') ?: 'http://sandbox/api/php-eval.php';

        $payload = http_build_query(['code' => $code]);
        $options = [
            'http' => [
                'method'  => 'POST',
                'header'  => "Content-Type: application/x-www-form-urlencoded\r\n" .
                             'Content-Length: ' . strlen($payload) . "\r\n",
                'content' => $payload,
                'timeout' => 5,
            ],
        ];

        $context = stream_context_create($options);

        $response = @file_get_contents($sandboxUrl, false, $context);

        if ($response === false) {
            $executionError = 'Sandbox-Aufruf fehlgeschlagen.';
        } else {
            $data = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
                $executionError = 'Ungültige Antwort von der Sandbox.';
            } else {
                $executionOutput = $data['output'] ?? '';
                $executionError  = $data['error'] ?? null;

                if ($executionError === null && isset($exerciseId)) {
                    $repository   = new ConfigExerciseRepository();
                    $checker      = new ExerciseChecker($repository);
                    $checkResult  = $checker->check((string)$exerciseId, $code, $executionOutput);
                }
            }
        }
    }
}

$heading = $heading ?? null;
?>

<?php if ($heading): ?>
    <h1 class="h4 mb-3"><?= htmlspecialchars($heading, ENT_QUOTES, 'UTF-8') ?></h1>
<?php endif; ?>

<form method="post">
    <div class="php-code-block">
        <div
            class="php-code-editor"
            data-initial-code="<?= htmlspecialchars($initialCode ?? '', ENT_QUOTES, 'UTF-8') ?>"
            style="width: 100%; height: 300px; border: 1px solid #ccc;"
        ></div>
        <textarea
            name="code"
            class="php-code-input"
            hidden
        ><?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8') ?></textarea>
        <button type="submit" class="btn btn-primary mt-3">Ausführen</button>
        <button type="button" class="btn btn-secondary mt-3 ms-2 php-code-reset">Zurücksetzen</button>
    </div>
</form>

<?php if ($executionError !== null): ?>
    <div class="alert alert-danger mt-3" role="alert">
        <strong>Fehler:</strong>
        <pre class="mb-0"><?= htmlspecialchars($executionError, ENT_QUOTES, 'UTF-8') ?></pre>
    </div>
<?php elseif ($executionOutput !== null): ?>
    <div class="alert alert-secondary mt-3" role="alert">
        <strong>Ausgabe:</strong>
        <pre class="mb-0"><?= htmlspecialchars($executionOutput, ENT_QUOTES, 'UTF-8') ?></pre>
    </div>
<?php endif; ?>

<?php if ($checkResult !== null): ?>
    <?php if ($checkResult['passed']): ?>
        <div class="alert alert-success mt-3" role="alert">
            <strong>Gut gemacht!</strong>
            <div><?= htmlspecialchars($checkResult['message'], ENT_QUOTES, 'UTF-8') ?></div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning mt-3" role="alert">
            <strong>Noch nicht ganz.</strong>
            <div><?= htmlspecialchars($checkResult['message'], ENT_QUOTES, 'UTF-8') ?></div>
        </div>
    <?php endif; ?>
<?php endif; ?>

<script src="/js/exercises/php-code-block.js"></script>
