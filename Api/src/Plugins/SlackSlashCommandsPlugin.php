<?php declare(strict_types=1);

namespace Api\Plugins;

use Api\Clients\GoogleSheetsClient;
use Api\Handlers\CommandHandlers\CheckHeroHandler;
use Api\Handlers\CommandHandlers\PublicReminderHandler;
use Parable\Framework\Plugins\PluginInterface;
use Parable\Http\RequestFactory;
use Parable\Routing\Router;

class SlackSlashCommandsPlugin implements PluginInterface
{
    public function __construct(
        protected Router $router
    ) {}

    public function run(): void
    {
        $this->router->add(
            ['POST'],
            'slack-check-hero',
            '/slack/check-hero',
            [SlackSlashCommandsPlugin::class, "checkHero"]
        );

        $this->router->add(
            ['POST'],
            'slack-public-reminder',
            '/slack/public-reminder',
            [SlackSlashCommandsPlugin::class, "publicReminder"]
        );
    }

    public static function checkHero(): void
    {
        $params = json_decode(RequestFactory::createFromServer()->getBody());
        (new CheckHeroHandler($params))->handle();
    }

    public static function publicReminder(): void
    {
        $params = json_decode(RequestFactory::createFromServer()->getBody());
        (new PublicReminderHandler($params))->handle();
    }
}
