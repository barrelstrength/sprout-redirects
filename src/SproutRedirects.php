<?php
/**
 * @link      https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license   https://craftcms.github.io/license
 */

namespace barrelstrength\sproutredirects;

use barrelstrength\sproutbase\config\base\SproutBasePlugin;
use barrelstrength\sproutbase\config\configs\ControlPanelConfig;
use barrelstrength\sproutbase\config\configs\RedirectsConfig;
use barrelstrength\sproutbase\SproutBase;
use barrelstrength\sproutbase\SproutBaseHelper;
use Craft;
use craft\helpers\UrlHelper;
use craft\web\ErrorHandler;
use yii\base\Event;

class SproutRedirects extends SproutBasePlugin
{
    const EDITION_LITE = 'lite';
    const EDITION_PRO = 'pro';

    /**
     * @var string
     */
    public $schemaVersion = '1.3.2';

    /**
     * @var string
     */
    public $minVersionRequired = '1.5.2';

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

    public static function getSproutConfigs(): array
    {
        return [
            ControlPanelConfig::class,
            RedirectsConfig::class
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        SproutBaseHelper::registerModule();

        $redirectsService = SproutBase::$app->redirects;

        Event::on(
            ErrorHandler::class,
            ErrorHandler::EVENT_BEFORE_HANDLE_EXCEPTION, [
            $redirectsService, 'handleRedirectsOnException'
        ]);
    }

    public function getUpgradeUrl()
    {
        if (!SproutBase::$app->config->isEdition('sprout-redirects', self::EDITION_PRO)) {
            return UrlHelper::cpUrl('sprout-redirects/upgrade');
        }

        return null;
    }
}
