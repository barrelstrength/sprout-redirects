<?php
/**
 * @link      https://sprout.barrelstrengthdesign.com/
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license   http://sprout.barrelstrengthdesign.com/license
 */

namespace barrelstrength\sproutredirects\services;

use craft\base\Component;

class App extends Component
{
    /**
     * @var Redirects
     */
    public $redirects;

    /**
     * @var Settings
     */
    public $settings;

    public function init()
    {
        $this->redirects = new Redirects();
        $this->settings = new Settings();
    }
}