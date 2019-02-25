<?php
/**
 * @link      https://sprout.barrelstrengthdesign.com/
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license   http://sprout.barrelstrengthdesign.com/license
 */

namespace barrelstrength\sproutredirects\records;


use craft\db\ActiveRecord;


/**
 * SproutRedirects - RedirectLog
 */
class RedirectLog extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%sproutseo_redirects_log}}';
    }
}
