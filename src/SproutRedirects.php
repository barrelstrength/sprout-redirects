<?php
/**
 * @link      https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license   https://craftcms.github.io/license
 */

namespace barrelstrength\sproutredirects;

use barrelstrength\sproutbase\config\base\SproutCentralInterface;
use barrelstrength\sproutbase\config\configs\CampaignsConfig;
use barrelstrength\sproutbase\config\configs\EmailConfig;
use barrelstrength\sproutbase\config\configs\GeneralConfig;
use barrelstrength\sproutbase\config\configs\RedirectsConfig;
use barrelstrength\sproutbase\config\configs\ReportsConfig;
use barrelstrength\sproutbase\config\configs\SentEmailConfig;
use barrelstrength\sproutbase\SproutBase;
use barrelstrength\sproutbase\SproutBaseHelper;
use Craft;
use craft\base\Plugin;
use craft\helpers\UrlHelper;
use craft\web\ErrorHandler;
use yii\base\Event;

class SproutRedirects extends Plugin implements SproutCentralInterface
{
    const EDITION_LITE = 'lite';
    const EDITION_PRO = 'pro';

    /**
     * @var string
     */
    public $schemaVersion = '1.3.2';

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
            GeneralConfig::class,
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

        Craft::setAlias('@sproutredirects', $this->getBasePath());

        $redirectsService = SproutBase::$app->redirects;
        Event::on(ErrorHandler::class, ErrorHandler::EVENT_BEFORE_HANDLE_EXCEPTION, [
            $redirectsService, 'handleRedirectsOnException'
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getUpgradeUrl()
    {
        if (!SproutBase::$app->config->isEdition('sprout-redirects', self::EDITION_PRO)) {
            return UrlHelper::cpUrl('sprout-redirects/upgrade');
        }

        return null;
    }
}
