<?php
/**
 * @link      https://sprout.barrelstrengthdesign.com/
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license   http://sprout.barrelstrengthdesign.com/license
 */

namespace barrelstrength\sproutredirects\models;


use barrelstrength\sproutbase\base\SproutSettingsInterface;
use craft\base\Model;
use Craft;

/**
 *
 * @property array $settingsNavItems
 */
class Settings extends Model implements SproutSettingsInterface
{
    /**
     * @var string
     */
    public $pluginNameOverride = '';

    /**
     * @var string
     */
    public $structureId = '';

    /**
     * @var bool
     */
    public $enable404RedirectLog = false;

    /**
     * @var int
     */
    public $total404Redirects = 250;

    /**
     * @var bool
     */
    public $enableMultilingualSitemaps = false;

    /**
     * @inheritdoc
     */
    public function getSettingsNavItems(): array
    {
        return [
            'general' => [
                'label' => Craft::t('sprout-redirects', 'General'),
                'url' => 'sprout-redirects/settings/general',
                'selected' => 'general',
                'template' => 'sprout-redirects/settings/general'
            ],
            'redirects' => [
                'label' => Craft::t('sprout-redirects', 'Redirects'),
                'url' => 'sprout-redirects/settings/redirects',
                'selected' => 'redirects',
                'template' => 'sprout-redirects/settings/redirects'
            ]
        ];
    }
}