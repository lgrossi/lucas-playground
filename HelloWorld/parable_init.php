<?php declare(strict_types=1);

/**
 * This file is part of the Parable Framework package and may be overwritten
 * upon running `parable install`. This can be needed on an upgrade that requires
 * changes to this file.
 *
 * If you absolutely need to make changes here, you can copy over the changes
 * from the Parable Framework package's parable_init.php_template file manually
 * instead.
 */

use Parable\Framework\Plugins\PluginManager;
use HelloWorld\Boot;

foreach (Boot::getPluginsToRegister() as $trigger => $pluginClassNames) {
    foreach ($pluginClassNames as $pluginClassName) {
        PluginManager::addPlugin(
            $trigger,
            $pluginClassName
        );
    }
}
