<?php
/**
 * @link https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license https://craftcms.github.io/license
 */

namespace barrelstrength\sproutredirects;

use barrelstrength\sproutbase\base\BaseSproutTrait;
use barrelstrength\sproutbase\SproutBase;
use barrelstrength\sproutbase\SproutBaseHelper;
use barrelstrength\sproutbaseredirects\models\Settings;
use barrelstrength\sproutbaseredirects\SproutBaseRedirects;
use barrelstrength\sproutbaseredirects\SproutBaseRedirectsHelper;
use Craft;
use craft\base\Plugin;
use craft\db\Query;
use craft\events\RegisterUrlRulesEvent;
use craft\events\RegisterUserPermissionsEvent;
use craft\helpers\UrlHelper;
use craft\services\UserPermissions;
use craft\web\ErrorHandler;
use craft\web\UrlManager;
use yii\base\Event;
use yii\web\Response;

/**
 *
 * @property mixed                                                             $cpNavItem
 * @property array                                                             $cpUrlRules
 * @property array                                                             $userPermissions
 * @property mixed                                                             $settings
 * @property null                                                              $upgradeUrl
 * @property \yii\console\Response|\craft\web\Response|\yii\web\Response|mixed $settingsResponse
 * @property array                                                             $siteUrlRules
 */
class SproutRedirects extends Plugin
{
    use BaseSproutTrait;

    const EDITION_LITE = 'lite';

    const EDITION_PRO = 'pro';

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
    public $schemaVersion = '1.2.3';

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
        SproutBaseRedirectsHelper::registerModule();

        Craft::setAlias('@sproutredirects', $this->getBasePath());

        $redirectsService = SproutBaseRedirects::$app->redirects;
        Event::on(ErrorHandler::class, ErrorHandler::EVENT_BEFORE_HANDLE_EXCEPTION, [
            $redirectsService, 'handleRedirectsOnException'
        ]);

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

        // Query the db directly because the SproutBaseRedirects Yii module may not yet be available
        $pluginSettings = (new Query())
            ->select('settings')
            ->from('{{%sprout_settings}}')
            ->where([
                'model' => Settings::class
            ])
            ->scalar();

        $settings = json_decode($pluginSettings, true);

        // Allow user to override plugin name in sidebar
        if (isset($settings['pluginNameOverride']) && $settings['pluginNameOverride']) {
            $parent['label'] = $settings['pluginNameOverride'];
        }

        if (Craft::$app->getUser()->checkPermission('sproutRedirects-editRedirects')) {
            $parent['subnav']['redirects'] = [
                'label' => Craft::t('sprout-redirects', 'Redirects'),
                'url' => 'sprout-redirects/redirects'
            ];
        }

        if (Craft::$app->getUser()->getIsAdmin()) {
            $parent['subnav']['settings'] = [
                'label' => Craft::t('sprout-redirects', 'Settings'),
                'url' => 'sprout-redirects/settings'
            ];
        }

        return $parent;
    }

    /**
     * @inheritDoc
     */
    public function getUpgradeUrl()
    {
        if (!SproutBase::$app->settings->isEdition('sprout-redirects', self::EDITION_PRO)) {
            return UrlHelper::cpUrl('sprout-redirects/upgrade');
        }

        return null;
    }

    /**
     * Redirect to Sprout Sitemaps settings
     *
     * @return \craft\web\Response|mixed|\yii\console\Response|Response
     */
    public function getSettingsResponse()
    {
        $url = UrlHelper::cpUrl('sprout-redirects/settings');

        return Craft::$app->getResponse()->redirect($url);
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
                'label' => Craft::t('sprout-redirects', 'Edit Redirects')
            ],
        ];
    }

    /**
     * @return Settings
     */
    protected function createSettingsModel(): Settings
    {
        return new Settings();
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

            // Settings
            'sprout-redirects/settings/<settingsSectionHandle:.*>' => [
                'route' => 'sprout/settings/edit-settings',
                'params' => [
                    'sproutBaseSettingsType' => Settings::class
                ]
            ],
            'sprout-redirects/settings' => [
                'route' => 'sprout/settings/edit-settings',
                'params' => [
                    'sproutBaseSettingsType' => Settings::class
                ]
            ]
        ];
    }
}
