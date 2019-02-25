<?php
/**
 * @link      https://sprout.barrelstrengthdesign.com/
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license   http://sprout.barrelstrengthdesign.com/license
 */

namespace barrelstrength\sproutredirects\validators;

use yii\validators\Validator;
use barrelstrength\sproutredirects\enums\RedirectStatuses;
use Craft;

class StatusValidator extends Validator
{
    /**
     * @inheritdoc
     */
    public function validateAttribute($object, $attribute)
    {
        if (!in_array($object->$attribute, [RedirectStatuses::ON, RedirectStatuses::OFF], true)) {
            $this->addError($object, $attribute, Craft::t('sprout-redirects', 'The status must be either "ON" or "OFF".'));
        }
    }
}
