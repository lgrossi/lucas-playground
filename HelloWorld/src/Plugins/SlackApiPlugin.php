<?php declare(strict_types=1);

namespace HelloWorld\Plugins;

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
        // Set up your config and routing here and Parable handles the rest.
        $this->router->add(
            ['POST'],
            'slack-api',
            '/slack-api',
            function () {
                $request = RequestFactory::createFromServer();
                $requestBody = json_decode($request->getBody());

                $responseBody = sprintf(
                    '{"challenge": "%s"}',
                    $requestBody ? $requestBody->challenge : null
                );

                $dispatcher = new ResponseDispatcher();
                $dispatcher->dispatch(new Response(200, $responseBody, 'application/json'));
            },
        );
    }
}
