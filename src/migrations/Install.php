<?php
/**
 * @link      https://sprout.barrelstrengthdesign.com/
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license   http://sprout.barrelstrengthdesign.com/license
 */

namespace barrelstrength\sproutredirects\migrations;

use Craft;

use craft\db\Migration;
use barrelstrength\sproutbaseredirects\migrations\Install as SproutBaseRedirectsInstall;

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
    public function safeUp()
    {
        $migration = new SproutBaseRedirectsInstall();
        ob_start();
        $migration->safeUp();
        ob_end_clean();
        return true;
    }
}
