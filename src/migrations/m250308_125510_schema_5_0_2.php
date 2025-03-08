<?php

namespace BarrelStrength\SproutRedirects\migrations;

use BarrelStrength\Sprout\core\db\m000000_000000_sprout_plugin_migration;
use BarrelStrength\Sprout\core\db\SproutPluginMigrationInterface;
use BarrelStrength\SproutRedirects\SproutRedirects;

class m250308_125510_schema_5_0_2 extends m000000_000000_sprout_plugin_migration
{
    public function getPluginInstance(): SproutPluginMigrationInterface
    {
        return SproutRedirects::getInstance();
    }
}