<?php declare(strict_types=1);

namespace Api\Clients;

class GoogleSheetsClient
{
    public static function getHeroes(): array
    {
        $client = new \Google_Client();
        $client->setApplicationName('Google Sheets and PHP');
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');
        $client->setAuthConfig(__DIR__ . '/../../credentials.json');

        $service = new \Google_Service_Sheets($client);
        $column = self::getColumn();
        $ranges = [date('m/Y') . "!{$column}6:{$column}17", date('m/Y') . "!A6:A17"];
        $response = $service->spreadsheets_values->batchGet('18ELe2dGmaj49TCdxJb--zHwgeRwIEN4muOWfq59kTec', ["ranges" => $ranges]);

        $heroes = ["H" => null, "B" => null];
        foreach ($response->getValueRanges()[0] as $index => $row) {
            if (current($row)) {
                $heroes[current($row)] = current($response->getValueRanges()[1][$index]);
            }
        }

        if (!$heroes["H"]) {
           return ["H" => $heroes["B"], "B" => null];
        }

        return $heroes;
    }

    private static function getColumn(int $base = 1) {
        $day = date('d');
        $lettersCount = 26;
        $initialOffset = $lettersCount - $base;
        $alphabet = range('A', 'Z');

        $day = 15;

        if ((int)$day < $initialOffset) {
            return $alphabet[$base + (int)$day];
        }

        $offset = max(ceil(($day - $initialOffset) / $lettersCount) - 1, 0);
        return $alphabet[$offset] . $alphabet[$day - $initialOffset - ($lettersCount * $offset)];
    }
}
