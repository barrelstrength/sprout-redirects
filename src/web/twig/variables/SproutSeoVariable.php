<?php
/**
 * @link      https://sprout.barrelstrengthdesign.com/
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license   http://sprout.barrelstrengthdesign.com/license
 */

namespace barrelstrength\sproutredirects\web\twig\variables;

use barrelstrength\sproutredirects\helpers\OptimizeHelper;
use barrelstrength\sproutredirects\models\Settings;
use barrelstrength\sproutredirects\SproutRedirects;
use Craft;
use craft\base\Field;
use craft\elements\Asset;

use craft\models\Site;
use DateTime;
use craft\fields\PlainText;
use craft\fields\Assets;

/**
 * Class SproutRedirectsVariable
 *
 * @package Craft
 */
class SproutRedirectsVariable
{
    /**
     * @var SproutRedirects
     */
    protected $plugin;

    /**
     * SproutRedirectsVariable constructor.
     */
    public function __construct()
    {
        $this->plugin = Craft::$app->plugins->getPlugin('sprout-redirects');
    }

    /**
     * @return \craft\base\Model|null
     */
    public function getSettings()
    {
        return Craft::$app->plugins->getPlugin('sprout-redirects')->getSettings();
    }

    /**
     * @param $id
     *
     * @return \craft\base\ElementInterface|null
     */
    public function getElementById($id)
    {
        $element = Craft::$app->elements->getElementById($id);

        return $element != null ? $element : null;
    }


    /**
     * @param $string
     *
     * @return DateTime
     */
    public function getDate($string)
    {
        return new DateTime($string['date'], new \DateTimeZone(Craft::$app->getTimeZone()));
    }

    /**
     * @return mixed
     */
    public function getSiteIds()
    {
        $sites = Craft::$app->getSites()->getAllSites();

        return $sites;
    }
}
