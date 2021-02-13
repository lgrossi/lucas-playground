<?php declare(strict_types=1);

namespace Api\Plugins;

use Api\Clients\GoogleSheetsClient;
use Api\Handlers\CommandHandlers\AbstractCommandHandler;
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
        self::handleCommand(new CheckHeroHandler());
    }

    public static function publicReminder(): void
    {
        self::handleCommand(new PublicReminderHandler());
    }

    private static function handleCommand(AbstractCommandHandler $handler): void
    {
        $body = RequestFactory::createFromServer()->getBody();
        $handler->setParams($body ? json_decode($body) : null);
        $handler->handle();
    }
}
