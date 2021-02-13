<?php declare(strict_types=1);

namespace Api\Clients;

use Api\Handlers\CommandHandlers\FFS\CheckHeroHandler;
use JetBrains\PhpStorm\Pure;

class GoogleSheetsClient
{
    public static function loadFFSHeroes(): array
    {
        $rowMin = 6;
        $ffsSheetId = '18ELe2dGmaj49TCdxJb--zHwgeRwIEN4muOWfq59kTec';
        $rowMax = $rowMin + count(CheckHeroHandler::$nameToSlackUserIdMap) - 1;

        /*
         * Transforms day to spreadsheet column index
         * 1 -> C
         * 2 -> D
         * ...
         * 24 -> Z
         * 25 -> AA
         * ...
         * 31 -> AG
         * */
        $column = (function ()  {
            $base = 1;
            $day = date('d');
            $lettersCount = 26;
            $initialOffset = $lettersCount - $base;
            $alphabet = range('A', 'Z');

            if ((int)$day < $initialOffset) {
                return $alphabet[$base + (int)$day];
            }

            $offset = max(ceil(($day - $initialOffset) / $lettersCount) - 1, 0);
            return $alphabet[$offset] . $alphabet[$day - $initialOffset - ($lettersCount * $offset)];
        })();

        /*
         * Loads names column (sheetTitle!A{min}:A{max}) and day column (sheetTitle!{$column}{$min}:{$column}{$max})
         * sheetTitle = month/Year (e.g. 02/2021)
         */
        $ranges = [date('m/Y') . "!{$column}{$rowMin}:{$column}{$rowMax}", date('m/Y') . "!A${rowMin}:A${rowMax}"];

        $response = self::getService()->spreadsheets_values->batchGet($ffsSheetId, ["ranges" => $ranges]);

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

    private static function getService(): \Google_Service_Sheets
    {
        $client = new \Google_Client();
        $client->setApplicationName('Google Sheets and PHP');
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');

        $client->setAuthConfig(self::getCredentials());

        return new \Google_Service_Sheets($client);
    }

    private static function getCredentials(): array
    {
        return json_decode(getenv('SERVICE_ACCOUNT'), true);
    }
}
