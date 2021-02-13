<?php declare(strict_types=1);

namespace Api\Plugins;

use Api\Handlers\CommandHandlers\AbstractCommandHandler;
use Api\Handlers\CommandHandlers\FFS\CheckHeroHandler;
use Api\Handlers\CommandHandlers\FFS\PublicReminderHandler;
use Parable\Framework\Plugins\PluginInterface;
use Parable\Http\RequestFactory;
use Parable\Routing\Router;

class FFSPlugin implements PluginInterface
{
    public function __construct(
        protected Router $router
    ) {}

    public function run(): void
    {
        $this->router->add(
            ['POST'],
            'ffs-check-hero',
            '/ffs/check-hero',
            [FFSPlugin::class, "checkHero"]
        );

        $this->router->add(
            ['POST'],
            'ffs-public-reminder',
            '/ffs/public-reminder',
            [FFSPlugin::class, "publicReminder"]
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
