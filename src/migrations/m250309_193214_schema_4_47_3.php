<?php

namespace BarrelStrength\SproutRedirects\migrations;

use BarrelStrength\Sprout\core\db\m000000_000000_sprout_plugin_migration;
use BarrelStrength\Sprout\core\db\SproutPluginMigrationInterface;
use BarrelStrength\SproutRedirects\SproutRedirects;

class m250309_193214_schema_4_47_3 extends m000000_000000_sprout_plugin_migration
{
    public function getPluginInstance(): SproutPluginMigrationInterface
    {
        return SproutRedirects::getInstance();
    }
}