(function () {
  if (typeof ace === 'undefined') {
    console.error('Ace Editor ist nicht geladen.');
    return;
  }

  const blocks = document.querySelectorAll('.php-code-block');
  if (!blocks.length) {
    return;
  }

  blocks.forEach(function (block) {
    const editorElement = block.querySelector('.php-code-editor');
    const hiddenInput = block.querySelector('.php-code-input');

    if (!editorElement || !hiddenInput) {
      return;
    }

    const editor = ace.edit(editorElement);
    editor.session.setMode('ace/mode/php');
    editor.setTheme('ace/theme/textmate');

    const initialPhpCode = editorElement.dataset.initialCode || '';
    const initialCode = hiddenInput.value.trim() !== ''
      ? hiddenInput.value
      : initialPhpCode;

    editor.setValue(initialCode, -1);

    const form = block.closest('form');
    if (form) {
      form.addEventListener('submit', function () {
        hiddenInput.value = editor.getValue();
      });
    }

    const resetButton = block.querySelector('.php-code-reset');
    if (resetButton) {
      resetButton.addEventListener('click', function () {
        editor.setValue(initialPhpCode, -1);
      });
    }
  });
})();
