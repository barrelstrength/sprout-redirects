<?php
/**
 * @link      https://sprout.barrelstrengthdesign.com/
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license   http://sprout.barrelstrengthdesign.com/license
 */

namespace barrelstrength\sproutredirects;

use barrelstrength\sproutbase\base\BaseSproutTrait;
use barrelstrength\sproutbase\SproutBaseHelper;
use barrelstrength\sproutbasefields\SproutBaseFieldsHelper;
use barrelstrength\sproutbaseredirects\SproutBaseRedirects;
use barrelstrength\sproutbaseredirects\SproutBaseRedirectsHelper;
use barrelstrength\sproutbaseredirects\models\Settings;
use Craft;
use craft\base\Plugin;
use craft\events\RegisterUrlRulesEvent;
use craft\events\RegisterUserPermissionsEvent;
use craft\services\UserPermissions;
use craft\web\ErrorHandler;
use craft\events\ExceptionEvent;
use craft\web\UrlManager;
use yii\base\Event;

/**
 *
 * @property mixed $cpNavItem
 * @property array $cpUrlRules
 * @property array $siteUrlRules
 */
class SproutRedirects extends Plugin
{
    use BaseSproutTrait;

    /**
     * Identify our plugin for BaseSproutTrait
     *
     * @var string
     */
    public static $pluginHandle = 'sprout-redirects';

    /**
     * @var bool
     */
    public $hasCpSection = true;

    /**
     * @var bool
     */
    public $hasCpSettings = true;

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    const EDITION_LITE = 'lite';
    const EDITION_PRO = 'pro';

    /**
     * @inheritdoc
     */
    public static function editions(): array
    {
        return [
            self::EDITION_LITE,
            self::EDITION_PRO,
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        SproutBaseHelper::registerModule();
        SproutBaseFieldsHelper::registerModule();
        SproutBaseRedirectsHelper::registerModule();

        Craft::setAlias('@sproutredirects', $this->getBasePath());

        Event::on(ErrorHandler::class, ErrorHandler::EVENT_BEFORE_HANDLE_EXCEPTION, function(ExceptionEvent $event) {
            SproutBaseRedirects::$app->redirects->handleRedirectsOnException($event);
        });

        Event::on(UrlManager::class, UrlManager::EVENT_REGISTER_CP_URL_RULES, function(RegisterUrlRulesEvent $event) {
            $event->rules = array_merge($event->rules, $this->getCpUrlRules());
        });

        Event::on(UserPermissions::class, UserPermissions::EVENT_REGISTER_PERMISSIONS, function(RegisterUserPermissionsEvent $event) {
            $event->permissions['Sprout Redirects'] = $this->getUserPermissions();
        });
    }

    public function getCpNavItem()
    {
        $parent = parent::getCpNavItem();
        // Allow user to override plugin name in sidebar
        if ($this->getSettings()->pluginNameOverride) {
            $parent['label'] = $this->getSettings()->pluginNameOverride;
        }

        return $parent;
    }

    /**
     * @return Settings
     */
    protected function createSettingsModel(): Settings
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    public function getSettings()
    {
        $settings = SproutBaseRedirects::$app->settings->getRedirectsSettings();

        return $settings;
    }

    /**
     * @return string|null
     * @throws \Twig_Error_Loader
     * @throws \yii\base\Exception
     */
    protected function settingsHtml()
    {
        return \Craft::$app->getView()->renderTemplate('sprout-redirects/settings', [
            'settings' => $this->getSettings()
        ]);
    }

    /**
     * @return array
     */
    private function getCpUrlRules(): array
    {
        return [
            // Redirects
            '<pluginHandle:sprout-redirects>/redirects/edit/<redirectId:\d+>/<siteHandle:.*>' =>
                'sprout-base-redirects/redirects/edit-redirect-template',
            '<pluginHandle:sprout-redirects>/redirects/edit/<redirectId:\d+>' =>
                'sprout-base-redirects/redirects/edit-redirect-template',
            '<pluginHandle:sprout-redirects>/redirects/new/<siteHandle:.*>' =>
                'sprout-base-redirects/redirects/edit-redirect-template',
            '<pluginHandle:sprout-redirects>/redirects/new' =>
                'sprout-base-redirects/redirects/edit-redirect-template',
            '<pluginHandle:sprout-redirects>/redirects/<siteHandle:.*>' =>
                'sprout-base-redirects/redirects/redirects-index-template',
            '<pluginHandle:sprout-redirects>/redirects' =>
                'sprout-base-redirects/redirects/redirects-index-template',
            '<pluginHandle:sprout-redirects>' =>
                'sprout-base-redirects/redirects/redirects-index-template',

            // Settings
            'sprout-redirects/settings/<settingsSectionHandle:.*>' =>
                'sprout/settings/edit-settings',

            'sprout-redirects/settings' =>
                'sprout/settings/edit-settings',
        ];
    }

    /**
     * @return array
     */
    public function getUserPermissions(): array
    {
        return [
            // We need this permission on top of the accessplugin- permission
            // so that we can support the matching permission in Sprout SEO
            'sproutRedirects-editRedirects' => [
                'label' => Craft::t('sprout-sitemaps', 'Edit Redirects')
            ],
        ];
    }
}
