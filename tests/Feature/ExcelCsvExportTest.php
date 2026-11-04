<?php

use App\Support\ExcelCsvExport;

test('CSV exports include UTF-8 data and protect spreadsheet formulas', function () {
    $response = ExcelCsvExport::download('clients.csv', ['Nom', 'Valeur'], [
        ['Élodie; Martin', '15,50'],
        ['=HYPERLINK("https://example.test")', '+212600000000'],
    ]);

    ob_start();
    $response->sendContent();
    $content = ob_get_clean();

    expect(substr($content, 0, 3))->toBe("\xEF\xBB\xBF");

    $records = array_map(
        static fn (string $line): array => str_getcsv($line, ';', '"', ''),
        array_filter(explode("\r\n", substr($content, 3)), static fn (string $line): bool => $line !== ''),
    );

    expect($records)->toBe([
        ['Nom', 'Valeur'],
        ['Élodie; Martin', '15,50'],
        ['\'=HYPERLINK("https://example.test")', "'+212600000000"],
    ]);
});
