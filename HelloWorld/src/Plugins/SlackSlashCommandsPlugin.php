<?php declare(strict_types=1);

namespace HelloWorld\Plugins;

use HelloWorld\Handlers\CommandHandlers\CheckHeroHandler;
use HelloWorld\Handlers\EventHandlers\SlackEventHandlerFactory;
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
    }

    public static function checkHero(): void
    {
        (new CheckHeroHandler())->handle();
    }
}
