<?php
// Einfache Demo: PHP-Code aus dem Editor ausführen und Ausgabe anzeigen.

$executionOutput = null;
$executionError  = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['code'] ?? '';

    if ($code !== '') {
        // Führende/trailing PHP-Tags optional entfernen
        $normalized = preg_replace('/^\s*<\?php\b/i', '', $code);
        $normalized = preg_replace('/\?>\s*$/', '', $normalized);

        ob_start();
        try {
            eval($normalized);
            $executionOutput = ob_get_clean();
        } catch (Throwable $e) {
            ob_end_clean();
            $executionError = $e->getMessage();
        }
    }
}
?>

<h1 class="h4 mb-3">Übung 1 – PHP-Eingabe</h1>

<form method="post">
    <div id="php-editor" style="width: 100%; height: 300px; border: 1px solid #ccc;"></div>
    <textarea name="code" id="php-code-input" hidden></textarea>
    <button type="submit" class="btn btn-primary mt-3">Ausführen</button>
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

<script>
  (function () {
    if (typeof ace === 'undefined') {
      console.error('Ace Editor ist nicht geladen.');
      return;
    }

    const editor = ace.edit('php-editor');
    editor.session.setMode('ace/mode/php');
    editor.setTheme('ace/theme-textmate');

    const phpExample = [
      '<' + '?php',
      '',
      'function greet(string $name): string {',
      "    return 'Hallo ' . $name;",
      '}',
      '',
      "$greeting = greet('Welt');",
      'echo $greeting;',
      ''
    ].join('\n');

    editor.setValue(phpExample, -1);

    const form = document.querySelector('form');
    const hiddenInput = document.getElementById('php-code-input');

    if (form && hiddenInput) {
      form.addEventListener('submit', function () {
        hiddenInput.value = editor.getValue();
      });
    }
  })();
</script>