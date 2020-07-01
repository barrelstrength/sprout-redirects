<?php
/**
 * @link      https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license   https://craftcms.github.io/license
 */

namespace barrelstrength\sproutredirects\migrations;

use barrelstrength\sproutbase\SproutBase;
use barrelstrength\sproutredirects\SproutRedirects;
use craft\db\Migration;
use ReflectionException;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\base\NotSupportedException;
use yii\web\ServerErrorHttpException;

class Install extends Migration
{
    /**
     * @throws ErrorException
     * @throws Exception
     * @throws NotSupportedException
     * @throws ServerErrorHttpException
     */
    public function safeUp()
    {
        SproutBase::$app->config->runInstallMigrations(SproutRedirects::getInstance());
    }

    /**
     * @return bool
     * @throws ReflectionException
     */
    public function safeDown(): bool
    {
        SproutBase::$app->config->runUninstallMigrations(SproutRedirects::getInstance());
    }
}
