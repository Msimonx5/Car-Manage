<?php

namespace App\Support;

use RuntimeException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExcelCsvExport
{
    public static function download(string $filename, array $headers, iterable $rows): StreamedResponse
    {
        return response()->streamDownload(function () use ($headers, $rows): void {
            $output = fopen('php://output', 'wb');

            if ($output === false) {
                throw new RuntimeException('Unable to open the export output stream.');
            }

            try {
                if (fwrite($output, "\xEF\xBB\xBF") !== 3) {
                    throw new RuntimeException('Unable to write the export encoding marker.');
                }

                self::writeRow($output, $headers);

                foreach ($rows as $row) {
                    self::writeRow($output, $row);
                }
            } finally {
                fclose($output);
            }
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private static function writeRow($output, array $row): void
    {
        $cells = array_map(static function ($value): string {
            $cell = is_scalar($value) ? (string) $value : '';

            if (preg_match('/^[\x00-\x20]*[=+\-@]/', $cell) === 1) {
                $cell = "'".$cell;
            }

            return $cell;
        }, $row);

        if (fputcsv($output, $cells, ';', '"', '', "\r\n") === false) {
            throw new RuntimeException('Unable to write a row to the export.');
        }
    }
}
