<?php
/**
 * @link      https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license   https://craftcms.github.io/license
 */

namespace barrelstrength\sproutredirects\migrations;

use barrelstrength\sproutbaseredirects\migrations\m200307_000000_add_enable_redirects_setting;
use craft\db\Migration;

class m200307_000000_add_enable_redirects_setting_sproutredirects extends Migration
{
    /**
     * @return bool
     */
    public function safeUp(): bool
    {
        $migration = new m200307_000000_add_enable_redirects_setting();

        ob_start();
        $migration->safeUp();
        ob_end_clean();

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        echo "m200307_000000_add_enable_redirects_setting_sproutredirects cannot be reverted.\n";

        return false;
    }
}
