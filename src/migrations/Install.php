<?php
/**
 * @link      https://sprout.barrelstrengthdesign.com/
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license   http://sprout.barrelstrengthdesign.com/license
 */

namespace barrelstrength\sproutredirects\migrations;

use Craft;

use craft\db\Migration;
use craft\models\Structure;
use barrelstrength\sproutredirects\models\Settings;
use craft\services\Plugins;

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
        $this->createTables();
        return true;
    }

    /**
     * @return bool|void
     * @throws \Throwable
     */
    public function safeDown()
    {
        $this->dropTable('{{%sproutseo_redirects}}');
    }

    // Protected Methods
    // =========================================================================

    protected function createTables()
    {
        $table = '{{%sproutseo_redirects}}';

        if (!$this->db->tableExists($table)){
            $this->createTable($table, [
                'id' => $this->primaryKey(),
                'oldUrl' => $this->string()->notNull(),
                'newUrl' => $this->string(),
                'method' => $this->integer(),
                'regex' => $this->boolean()->defaultValue(false),
                'count' => $this->integer()->defaultValue(0),
                'dateCreated' => $this->dateTime()->notNull(),
                'dateUpdated' => $this->dateTime()->notNull(),
                'uid' => $this->uid(),
            ]);

            $this->createIndexes();
            $this->addForeignKeys();
        }

        $this->insertDefaultSettings();
    }

    protected function createIndexes()
    {
        $this->createIndex(null, '{{%sproutseo_redirects}}', 'id');
    }

    protected function addForeignKeys()
    {
        $this->addForeignKey(
            null,
            '{{%sproutseo_redirects}}', 'id',
            '{{%elements}}', 'id', 'CASCADE', null
        );
    }

    /**
     * @throws \craft\errors\StructureNotFoundException
     * @throws \yii\base\ErrorException
     * @throws \yii\base\Exception
     * @throws \yii\base\NotSupportedException
     * @throws \yii\web\ServerErrorHttpException
     */
    protected function insertDefaultSettings()
    {
        $settings = new Settings();
        $projectConfig = Craft::$app->getProjectConfig();

        $sproutSeo = Craft::$app->getPlugins()->getPlugin('sprout-seo');

        if ($sproutSeo){
            $seoSettings = $sproutSeo->getSettings();
            if ($seoSettings->structureId){
                $settings->structureId = $seoSettings->structureId;
                //remove structure id from seo plugin
                // Add our default plugin settings
                $pluginHandle = 'sprout-seo';
                $seoSettings->structureId = null;
                $projectConfig->set(Plugins::CONFIG_PLUGINS_KEY . '.' . $pluginHandle . '.settings', $seoSettings->toArray());
            }else{
                $settings->structureId = $this->getStructureId();
            }
        }

        // Add our default plugin settings
        $pluginHandle = 'sprout-redirects';
        $projectConfig->set(Plugins::CONFIG_PLUGINS_KEY . '.' . $pluginHandle . '.settings', $settings->toArray());
    }

    /**
     * @return int|null
     * @throws \craft\errors\StructureNotFoundException
     */
    private function getStructureId()
    {
        $maxLevels = 1;
        $structure = new Structure();
        $structure->maxLevels = $maxLevels;
        Craft::$app->structures->saveStructure($structure);

        return $structure->id;
    }
}
