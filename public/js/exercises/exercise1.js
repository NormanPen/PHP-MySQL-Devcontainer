(function () {
  if (typeof ace === 'undefined') {
    console.error('Ace Editor ist nicht geladen.');
    return;
  }

  const editor = ace.edit('php-editor');
  editor.session.setMode('ace/mode/php');
  editor.setTheme('ace/theme/textmate');

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

  const hiddenInput = document.getElementById('php-code-input');

  const initialCode = hiddenInput && hiddenInput.value.trim() !== ''
    ? hiddenInput.value
    : phpExample;

  editor.setValue(initialCode, -1);

  const form = document.querySelector('form');

  if (form && hiddenInput) {
    form.addEventListener('submit', function () {
      hiddenInput.value = editor.getValue();
    });
  }

  const resetButton = document.getElementById('reset-code-button');
  if (resetButton) {
    resetButton.addEventListener('click', function () {
      editor.setValue(phpExample, -1);
    });
  }
})();
