<?php declare(strict_types=1);

namespace HelloWorld;

use HelloWorld\Plugins\HomepagePlugin;
use HelloWorld\Plugins\SlackApiPlugin;
use Parable\Framework\Application;

class Boot
{
    /**
     * The key is the time slot the plugins will be registered and executed in,
     * the values the class names.
     *
     * @return string[][]
     */
    public static function getPluginsToRegister(): array
    {
        return [
            Application::PLUGIN_BEFORE_BOOT => [
                HomepagePlugin::class,
                SlackApiPlugin::class,
            ],
            Application::PLUGIN_AFTER_BOOT => [
            ],
        ];
    }
}
