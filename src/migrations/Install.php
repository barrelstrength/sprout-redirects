<?php
/**
 * @link      https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license   https://craftcms.github.io/license
 */

namespace barrelstrength\sproutredirects\migrations;

use barrelstrength\sproutbase\config\base\DependencyInterface;
use barrelstrength\sproutbase\migrations\Install as SproutBaseInstall;
use barrelstrength\sproutbase\SproutBase;
use barrelstrength\sproutbase\app\redirects\migrations\Install as SproutBaseRedirectsInstall;
use barrelstrength\sproutredirects\SproutRedirects;
use craft\db\Migration;
use Throwable;

class Install extends Migration
{
    /**
     * @var string The database driver to use
     */
    public $driver;

    /**
     * @return bool
     * @throws Throwable
     */
    public function safeUp(): bool
    {
        SproutBase::$app->config->runInstallMigrations(SproutRedirects::getInstance());

        return true;
    }

    /**
     * @return bool
     */
    public function safeDown(): bool
    {
        SproutBase::$app->config->runUninstallMigrations(SproutRedirects::getInstance());

        return true;
    }
}
