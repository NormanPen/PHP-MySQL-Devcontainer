<?php

// Lädt alle Übungskonfigurationen aus config/exercises/*.php
// und gibt ein Array im Format ['exercise1' => [...], 'exercise2' => [...], ...] zurück.

$all = [];

foreach (glob(__DIR__ . '/exercises/*.php') as $file) {
    $id       = basename($file, '.php');
    $all[$id] = require $file;
}

return $all;
