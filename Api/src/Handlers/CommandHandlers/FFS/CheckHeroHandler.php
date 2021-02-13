<?php declare(strict_types=1);

namespace Api\Handlers\CommandHandlers\FFS;

use Api\Clients\GoogleSheetsClient;
use Api\Handlers\CommandHandlers\AbstractCommandHandler;
use Api\Handlers\CommandHandlers\FFS\Traits\TeamFinancialServicesTrait;
use Api\Handlers\CommandHandlers\FFS\Traits\WeekdaysOnlyTrait;

class CheckHeroHandler extends AbstractCommandHandler
{
    use TeamFinancialServicesTrait;
    use WeekdaysOnlyTrait;

    private static string $cachePath = __DIR__ . '/heroes-cache.json';

    public static array $nameToSlackUserIdMap = [
        "Bart" => "U9P2A158B",
        "Daniel" => "U9UENQYHL",
        "James" => "UL5RE884D",
        "Leo" => "U7799J7GB",
        "Lucas" => "UVBEZQ3JT",
        "Matheus" => "UP3DLA3L1",
        "Mihaela" => "UCK7KS8TZ",
        "Paulo" => "UKU14R200",
        "Robin" => "U44HDK58A",
        "Tariq" => "U01AWQUJBFS",
        "Thijs" => "U44KQSXHT",
        "Vesna" => "UF665HE6A"
    ];

    final protected function buildResponse(): string
    {
        ["H" => $hero, "B" => $backup] = $this->getHeroes();

        $message = "*Daily Support Hero Rotation*";
        if (!$hero && !$backup) {
            $message .= "\n\n:superman: *I couldn't find the hero today, can someone help me, please?*";
        } else {
            $message .= "\n\n:superman: <@" . self::$nameToSlackUserIdMap[$hero] . ">";
            $message .= $backup ? "\n:back_away: <@" . self::$nameToSlackUserIdMap[$backup] . ">" : "";
        }

        $message .= "\n\n*Reminders*";
        $message .= "\n:alert: Triage, Merge, Resolve, Ignore or Create issues for Sentry exceptions (see <https://mollie.atlassian.net/wiki/spaces/FFS/pages/1465057324/Support+Hero+Rotation|Confluence Page> for more). *Be mindful for exceptions that are flooding alerts on <#C74J3UW2F> or <#CE6SH5743>.*";
        $message .= "\n\n:firefighter: First line responder on the <#C9JJSRXLY> and this triage channel. Don’t forget to check for open request here. *YOU ARE NOT RESPONSIBLE FOR SOLVING ALL PROBLEMS.*";
        $message .= "\n\n:memo: At the end of (or during) the day keep the log of what happened in the <https://docs.google.com/spreadsheets/d/18ELe2dGmaj49TCdxJb--zHwgeRwIEN4muOWfq59kTec/edit#gid=857058015|Schedule Spreadsheet>.";
        $message .= "\n\n:muscle_skype: <@UT743GESU> is our support liaison. Make sure to keep him and <#C9JJSRXLY> updated on any development.";

        $message .= "\n\n*Thank you for your help and have a great day!*";

        return $message;
    }

    protected function getChannelId(): string
    {
        /* ffs-reporter-triage */
        return "UVBEZQ3JT";
    }

    private function getHeroes(): array
    {
        $heroes = $this->getCachedHeroes();
        if (!$heroes) {
            $heroes = GoogleSheetsClient::getHeroes();
            $this->cacheHeroes($heroes);
        }
        return $heroes;
    }

    private function getCachedHeroes(): ?array
    {
        if ($cacheFile = file_get_contents(self::$cachePath)) {
            $cached = explode(",", $cacheFile);
            $cacheDate = new \DateTime("@" . $cached[0]);

            if (date('d') === $cacheDate->format('d')) {
                return ["H" => $cached[1], "B" => $cached[2]];
            }
        }

        return null;
    }

    private function cacheHeroes(array $heroes): void
    {
        ["H" => $hero, "B" => $backup] = $heroes;
        $timestamp = (new \DateTime())->getTimestamp();
        file_put_contents(self::$cachePath, "{$timestamp},{$hero},{$backup}");
    }
}
