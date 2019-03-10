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
use barrelstrength\sproutbaseredirects\SproutBaseRedirectsHelper;
use barrelstrength\sproutredirects\models\Settings;
use barrelstrength\sproutredirects\services\App;
use barrelstrength\sproutredirects\web\twig\variables\SproutRedirectsVariable;

use Craft;
use craft\base\Plugin;
use craft\events\RegisterUrlRulesEvent;
use craft\web\twig\variables\CraftVariable;
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
     * Enable use of SproutRedirects::$app-> in place of Craft::$app->
     *
     * @var \barrelstrength\sproutredirects\services\App
     */
    public static $app;

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
     * @var string
     */
    public $schemaVersion = '1.0.0';

    /**
     * @inheritdoc
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        SproutBaseHelper::registerModule();
        SproutBaseFieldsHelper::registerModule();
        SproutBaseRedirectsHelper::registerModule();

        $this->setComponents([
            'app' => App::class
        ]);

        self::$app = $this->get('app');

        Craft::setAlias('@sproutredirects', $this->getBasePath());

        Event::on(UrlManager::class, UrlManager::EVENT_REGISTER_CP_URL_RULES, function(RegisterUrlRulesEvent $event) {
            $event->rules = array_merge($event->rules, $this->getCpUrlRules());
        });

        Event::on(CraftVariable::class, CraftVariable::EVENT_INIT, function(Event $event) {
            $variable = $event->sender;
            $variable->set('sproutRedirects', SproutRedirectsVariable::class);
        });
    }

    public function getCpNavItem()
    {
        $parent = parent::getCpNavItem();

        // Allow user to override plugin name in sidebar
        if ($this->getSettings()->pluginNameOverride) {
            $parent['label'] = $this->getSettings()->pluginNameOverride;
        }

        return array_merge($parent, [
            'subnav' => [
                'redirects' => [
                    'label' => Craft::t('sprout-redirects', 'Redirects'),
                    'url' => 'sprout-base-redirects/redirects'
                ],
                'settings' => [
                    'label' => Craft::t('sprout-redirects', 'Settings'),
                    'url' => 'sprout-redirects/settings'
                ],
            ]
        ]);
    }

    /**
     * @return Settings
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @return array
     */
    private function getCpUrlRules()
    {
        return [
            'sprout-redirects' => [
                'template' => 'sprout-base-redirects/redirects'
            ],

            // Redirects
            'sprout-base-redirects/redirects/edit/<redirectId:\d+>/<siteHandle:.*>' =>
                'sprout-base-redirects/redirects/edit-redirect',

            'sprout-base-redirects/redirects/edit/<redirectId:\d+>' =>
                'sprout-base-redirects/redirects/edit-redirect',

            'sprout-base-redirects/redirects/new/<siteHandle:.*>' =>
                'sprout-base-redirects/redirects/edit-redirect',

            'sprout-base-redirects/redirects/new' =>
                'sprout-base-redirects/redirects/edit-redirect',

            'sprout-base-redirects/redirects/<siteHandle:.*>' =>
                'sprout-base-redirects/redirects/redirects-index-template',

            'sprout-base-redirects/redirects' =>
                'sprout-base-redirects/redirects/redirects-index-template',

            // Settings
            'sprout-redirects/settings/<settingsSectionHandle:.*>' =>
                'sprout/settings/edit-settings',

            'sprout-redirects/settings' =>
                'sprout/settings/edit-settings',
        ];
    }
}
