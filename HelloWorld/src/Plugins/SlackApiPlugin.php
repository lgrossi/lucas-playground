<?php declare(strict_types=1);

namespace HelloWorld\Plugins;

use HelloWorld\Handlers\SlackEventHandlerFactory;
use Parable\Framework\Plugins\PluginInterface;
use Parable\Http\RequestFactory;
use Parable\Http\Response;
use Parable\Http\ResponseDispatcher;
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
            '/slack-api',
            $this->processSlackEvent()
        );
    }

    private function processSlackEvent(): void
    {
        $request = RequestFactory::createFromServer();
        if ($request->getBody()) {
            $event = json_decode($request->getBody());
            SlackEventHandlerFactory::getSlackEventHandler($event)->handle();
        }
    }

    private function sendResponse(?string $responseBody = null): void
    {
        $dispatcher = new ResponseDispatcher();
        $dispatcher->dispatch(new Response(200, $responseBody, 'application/json'));
    }
}
