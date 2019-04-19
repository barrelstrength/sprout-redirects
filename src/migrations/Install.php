<?php
/**
 * @link      https://sprout.barrelstrengthdesign.com/
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license   http://sprout.barrelstrengthdesign.com/license
 */

namespace barrelstrength\sproutredirects\migrations;

use craft\db\Migration;
use barrelstrength\sproutbaseredirects\migrations\Install as SproutBaseRedirectsInstall;
use barrelstrength\sproutbase\migrations\Install as SproutBaseInstall;

class Install extends Migration
{
    // Public Properties
    // =========================================================================

    /**
     * @var string The database driver to use
     */
    public $driver;

    // Public Methods
    // =========================================================================

    /**
     * @return bool
     * @throws \Throwable
     */
    public function safeUp(): bool
    {
        $migration = new SproutBaseInstall();
        ob_start();
        $migration->safeUp();
        ob_end_clean();

        $migration = new SproutBaseRedirectsInstall();

        ob_start();
        $migration->safeUp();
        ob_end_clean();

        return true;
    }
}
