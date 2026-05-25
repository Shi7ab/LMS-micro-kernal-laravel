<?php

namespace Tests\Unit\Kernel;

use Tests\TestCase;
use Illuminate\Support\Facades\File;

class PluginRegistryTest extends TestCase
{
    /** @test */
    public function it_can_discover_and_register_available_plugins_dynamically()
    {
        $pluginsPath = base_path('plugins');

        $this->assertTrue(File::exists($pluginsPath), 'مجلد Plugins الرئيسي غير موجود في النواة');

        $discoveredPlugins = File::directories($pluginsPath);

        $pluginNames = array_map(function ($path) {
            return basename($path);
        }, $discoveredPlugins);

        $this->assertContains('Auth', $pluginNames, 'النواة فشلت في العثور على إضافة الحسابات');

        $hasCoursePlugin = in_array('Course', $pluginNames) || in_array('Courses', $pluginNames);
        $this->assertTrue($hasCoursePlugin, 'النواة فشلت في العثور على إضافة الكورسات (Course/Courses)');

        $this->assertContains('Media', $pluginNames, 'النواة فشلت في العثور على إضافة الميديا');
    }
}
