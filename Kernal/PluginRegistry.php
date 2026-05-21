<?php
namespace Kernal;

use Illuminate\Support\Facades\File;

class PluginRegistry
{
    /**
     * Scan the plugins directory and boot all valid modules.
     */
    public static function discoverAndRegister(): void
    {
        $pluginsPath = base_path('plugins');

        if (!File::exists($pluginsPath)) {
            return;
        }

        // Gather all subdirectory folders inside /plugins
        $pluginDirectories = File::directories($pluginsPath);

        foreach ($pluginDirectories as $directory) {
            $pluginName = basename($directory);

            // Expected convention: plugins/Auth/src/AuthPluginServiceProvider.php
            $providerClass = "Plugins\\{$pluginName}\\src\\{$pluginName}PluginServiceProvider";

            if (class_exists($providerClass)) {
                // Dynamically register the plugin's Service Provider into Laravel's core engine
                app()->register($providerClass);
            }
        }
    }
}
