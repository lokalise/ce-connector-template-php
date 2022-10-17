<?php

if ($argc != 3) {
    echo "Usage: " . $argv[0] . " <path/to/index.xml> <threshold>\n";
    exit(-1);
}

$file = $argv[1];
$threshold = (double) $argv[2];

$coverage = simplexml_load_file($file);
$ratio = (double) $coverage->project->directory->totals->lines["percent"];

echo "Line coverage: $ratio%\n";
echo "Threshold: $threshold%\n";

if ($ratio < $threshold) {
    echo "FAILED!\n";
    exit(-1);
}

echo "SUCCESS!\n";
