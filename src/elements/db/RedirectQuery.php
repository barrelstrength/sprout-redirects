<?php
/**
 * @link      https://sprout.barrelstrengthdesign.com/
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license   http://sprout.barrelstrengthdesign.com/license
 */

namespace barrelstrength\sproutredirects\elements\db;


use barrelstrength\sproutredirects\elements\Redirect;
use craft\db\Connection;
use craft\elements\db\ElementQuery;
use craft\helpers\Db;


use barrelstrength\sproutredirects\SproutRedirects;

/**
 * RedirectQuery represents a SELECT SQL statement for Redirect Elements in a way that is independent of DBMS.
 *
 * @method Redirect[]|array all($db = null)
 * @method Redirect|array|null one($db = null)
 * @method Redirect|array|null nth(int $n, Connection $db = null)
 */
class RedirectQuery extends ElementQuery
{
    // General - Properties
    // =========================================================================

    public $oldUrl;

    public $newUrl;

    public $method;

    public $regex;

    public $count;

    public $status;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->withStructure === null) {
            $this->withStructure = true;
        }

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function __construct($elementType, array $config = [])
    {
        // Default orderBy
        if (!isset($config['orderBy'])) {
            $config['orderBy'] = 'sproutseo_redirects.dateCreated';
        }

        parent::__construct($elementType, $config);
    }

    /**
     * @param false|int|int[]|null $id
     * @return $this|ElementQuery
     */
    public function id($id)
    {
        $this->id = $id;

        return $this;
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function beforePrepare(): bool
    {
        /*
         *@todo - for some reason the reorder is not working on the element index page
         * the prevId values is not sent by post (check categories behavior)
        */
        if ($this->structureId === null) {
            $this->structureId = SproutRedirects::$app->redirects->getStructureId();
        }

        $this->joinElementTable('sproutseo_redirects');

        $this->query->select([
            'sproutseo_redirects.id',
            'sproutseo_redirects.oldUrl',
            'sproutseo_redirects.newUrl',
            'sproutseo_redirects.method',
            'sproutseo_redirects.regex',
            'sproutseo_redirects.count'
        ]);

        $this->query->orderBy = ['structureelements.lft' => SORT_DESC];

        if ($this->id) {
            $this->subQuery->andWhere(Db::parseParam(
                'sproutseo_redirects.id', $this->id)
            );
        }

        if ($this->oldUrl) {
            $this->subQuery->andWhere(Db::parseParam(
                'sproutseo_redirects.oldUrl', $this->oldUrl)
            );
        }

        if ($this->newUrl) {
            $this->subQuery->andWhere(Db::parseParam(
                'sproutseo_redirects.newUrl', $this->newUrl)
            );
        }

        if ($this->method) {
            $this->subQuery->andWhere(Db::parseParam(
                'sproutseo_redirects.method', $this->method)
            );
        }

        return parent::beforePrepare();
    }
}