<?php declare(strict_types=1);

namespace HelloWorld\Plugins;

use HelloWorld\Handlers\CommandHandlers\CheckHeroHandler;
use HelloWorld\Handlers\EventHandlers\SlackEventHandlerFactory;
use Parable\Framework\Plugins\PluginInterface;
use Parable\Http\RequestFactory;
use Parable\Routing\Router;

class SlackApiPlugin implements PluginInterface
{
    public function __construct(
        protected Router $router
    ) {}

    public function run(): void
    {
        $this->router->add(
            ['POST'],
            'slack-api',
            '/slack/api',
            [SlackApiPlugin::class, "processSlackEvent"]
        );
    }

    public static function processSlackEvent(): void
    {
        $request = RequestFactory::createFromServer();
        if ($request->getBody()) {
            $event = json_decode($request->getBody());
            SlackEventHandlerFactory::getSlackEventHandler($event)->handle();
        }
    }
}
