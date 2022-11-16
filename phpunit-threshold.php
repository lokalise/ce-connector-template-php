<?php

$thresholds = [
    'Classes' => (float) $argv[1],
    'Methods' => (float) $argv[2],
    'Paths' => (float) $argv[3],
    'Branches' => (float) $argv[4],
    'Lines' => (float) $argv[5],
];

$coverageText = file_get_contents('coverage.txt');
$coverageParts = array_filter(array_map('trim', explode("\n", $coverageText)));

$status = 'SUCCESS';

foreach ($coverageParts as $coveragePart) {
    foreach ($thresholds as $metricLabel => $threshold) {
        if (str_starts_with($coveragePart, $metricLabel)) {
            $metricLabelLength = strlen($metricLabel) + 1;
            $positionPercentage = strpos($coveragePart, '%');

            $coverage = (float) trim(
                substr(
                    $coveragePart,
                    $metricLabelLength,
                    $positionPercentage - $metricLabelLength
                ),
            );

            if ($coverage < $threshold) {
                $status = 'FAILED';
            }

            echo "$metricLabel coverage: $coverage%\n";
            echo "$metricLabel threshold: $threshold%\n\n";
        }
    }
}

echo "$status!\n";

if ('FAILED' === $status) {
    exit(-1);
}
