<?php declare(strict_types=1);

namespace HelloWorld\Plugins;

use Parable\Framework\Plugins\PluginInterface;
use Parable\Routing\Router;

class HomepagePlugin implements PluginInterface
{
    public function __construct(
        protected Router $router
    ) {}

    public function run(): void
    {
        // Set up your config and routing here and Parable handles the rest.
        $this->router->add(
            ['GET'],
            'welcome',
            '/',
            function () {
            },
            ['template' => 'src/welcome.phtml']
        );
    }
}
