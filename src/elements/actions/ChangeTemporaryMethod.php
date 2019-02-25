<?php
    /**
     * @link      https://sprout.barrelstrengthdesign.com/
     * @copyright Copyright (c) Barrel Strength Design LLC
     * @license   http://sprout.barrelstrengthdesign.com/license
     */

namespace barrelstrength\sproutredirects\elements\actions;

use barrelstrength\sproutredirects\enums\RedirectMethods;
use barrelstrength\sproutredirects\SproutRedirects;
use craft\base\ElementAction;
use Craft;
use craft\elements\db\ElementQueryInterface;

/**
 * @todo - refactor and clean up
 *
 * @property string $triggerLabel
 */
class ChangeTemporaryMethod extends ElementAction
{
    // Properties
    // =========================================================================

    /**
     * @var string|null The confirmation message that should be shown before the elements get deleted
     */
    public $confirmationMessage;

    /**
     * @var string|null The message that should be shown after the elements get deleted
     */
    public $successMessage;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function getTriggerLabel(): string
    {
        return Craft::t('sprout-redirects', 'Update Method to 302');
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function getConfirmationMessage()
    {
        return $this->confirmationMessage;
    }

    /**
     * @param ElementQueryInterface $query
     *
     * @return bool
     * @throws \yii\db\Exception
     */
    public function performAction(ElementQueryInterface $query): bool
    {
        $elementIds = $query->ids();

        // Call updateMethods service
        $response = SproutRedirects::$app->redirects->updateRedirectMethod($elementIds, RedirectMethods::Temporary);

        $message = SproutRedirects::$app->redirects->getMethodUpdateResponse($response);

        $this->setMessage($message);

        return $response;
    }
}
