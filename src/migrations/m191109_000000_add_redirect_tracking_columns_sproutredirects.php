<?php

namespace barrelstrength\sproutredirects\migrations;

use barrelstrength\sproutbaseredirects\migrations\m191109_000000_add_redirect_tracking_columns;
use craft\db\Migration;
use Throwable;

/**
 * m191109_000000_add_redirect_tracking_columns_sproutredirects migration.
 */
class m191109_000000_add_redirect_tracking_columns_sproutredirects extends Migration
{
    /**
     * @inheritdoc
     *
     * @return bool
     * @throws Throwable
     */
    public function safeUp(): bool
    {
        $migration = new m191109_000000_add_redirect_tracking_columns();

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
        echo "m191109_000000_add_redirect_tracking_columns_sproutredirects cannot be reverted.\n";
        return false;
    }
}
