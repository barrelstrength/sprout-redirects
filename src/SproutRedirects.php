<?php

namespace BarrelStrength\SproutRedirects;

use BarrelStrength\Sprout\core\db\MigrationHelper;
use BarrelStrength\Sprout\core\db\SproutPluginMigrationInterface;
use BarrelStrength\Sprout\core\db\SproutPluginMigrator;
use BarrelStrength\Sprout\core\editions\Edition;
use BarrelStrength\Sprout\core\modules\Modules;
use BarrelStrength\Sprout\redirects\RedirectsModule;
use Craft;
use craft\base\Plugin;
use craft\db\MigrationManager;
use craft\events\RegisterComponentTypesEvent;
use craft\helpers\UrlHelper;
use yii\base\Event;

class SproutRedirects extends Plugin implements SproutPluginMigrationInterface
{
    public string $minVersionRequired = '1.5.3';

    public string $schemaVersion = '4.44.444';

    public static function editions(): array
    {
        return [
            Edition::LITE,
            Edition::PRO,
        ];
    }

    public static function getSchemaDependencies(): array
    {
        return [
            RedirectsModule::class,
        ];
    }

    public function getMigrator(): MigrationManager
    {
        return SproutPluginMigrator::make($this);
    }

    public function init(): void
    {
        parent::init();

        Event::on(
            Modules::class,
            Modules::INTERNAL_SPROUT_EVENT_REGISTER_AVAILABLE_MODULES,
            static function(RegisterComponentTypesEvent $event) {
                $event->types[] = RedirectsModule::class;
            }
        );

        $this->instantiateSproutModules();
        $this->grantModuleEditions();
    }

    protected function instantiateSproutModules(): void
    {
        RedirectsModule::isEnabled() && RedirectsModule::getInstance();
    }

    protected function grantModuleEditions(): void
    {
        if ($this->edition === Edition::PRO) {
            RedirectsModule::isEnabled() && RedirectsModule::getInstance()->grantEdition(Edition::PRO);
        }
    }

    protected function afterInstall(): void
    {
        MigrationHelper::runMigrations($this);

        if (Craft::$app->getRequest()->getIsConsoleRequest()) {
            return;
        }

        // Redirect to welcome page
        $url = UrlHelper::cpUrl('sprout/welcome/redirects');
        Craft::$app->getResponse()->redirect($url)->send();
    }

    protected function beforeUninstall(): void
    {
        MigrationHelper::runUninstallMigrations($this);
    }
}
