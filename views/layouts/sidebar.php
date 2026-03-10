<?php
// $exercise wird im Router für /exercises/1, /exercises/2 gesetzt
/** @var string|null $exercise */
$currentExercise = $exercise ?? null;
?>

<nav class="nav flex-column nav-pills small">
    <span class="nav-link disabled text-uppercase fw-semibold text-muted mb-1">Übungen</span>
    <a class="nav-link<?= $currentExercise === null ? ' active' : '' ?>" href="/exercises"<?= $currentExercise === null ? ' aria-current="page"' : '' ?>>Übersicht</a>
    <a class="nav-link<?= $currentExercise === '1' ? ' active' : '' ?>" href="/exercises/1"<?= $currentExercise === '1' ? ' aria-current="page"' : '' ?>>Übung 1</a>
    <a class="nav-link<?= $currentExercise === '2' ? ' active' : '' ?>" href="/exercises/2"<?= $currentExercise === '2' ? ' aria-current="page"' : '' ?>>Übung 2</a>
</nav>
