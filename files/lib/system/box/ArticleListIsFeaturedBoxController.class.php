<?php
namespace wcf\system\box;
use wcf\data\article\AccessibleArticleList;
use wcf\system\WCF;

/**
 * Box controller for a list of featured articles.
 *
 * @author		Marcel Werk
 * @copyright	2001-2019 WoltLab GmbH
 * @license		GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package		WoltLabSuite\Core\System\Box
 * @since		3.0
 * @modified 	by <https://www.cls-design.com>
 * @package		com.cls-design.wcf.box.latestArticles
 */
class ArticleListIsFeaturedBoxController extends AbstractDatabaseObjectListBoxController {
	/**
	 * @inheritDoc
	 */
	protected static $supportedPositions = ['sidebarLeft', 'sidebarRight', 'contentTop', 'contentBottom', 'top', 'bottom', 'footerBoxes'];
	
	/**
	 * @inheritDoc
	 */
	protected $sortFieldLanguageItemPrefix = 'wcf.article.sortField';
	
	/**
	 * @inheritDoc
	 */
	public $defaultLimit = 3;
	
	/**
	 * @inheritDoc
	 */
	protected $conditionDefinition = 'com.woltlab.wcf.box.articleList.condition';
	
	/**
	 * @inheritDoc
	 */
	public $validSortFields = [
		'time',
		'comments',
		'views',
		'random'
	];
	
	/**
	 * @inheritDoc
	 */
	public function __construct() {
		if (!empty($this->validSortFields) && MODULE_LIKE) {
			$this->validSortFields[] = 'cumulativeLikes';
		}
		
		parent::__construct();
	}
	
	/**
	 * @inheritDoc
	 */
	protected function getObjectList() {
		$objectList = new AccessibleArticleList();
		
		switch ($this->sortField) {
			case 'comments':
				$objectList->getConditionBuilder()->add('article.comments > ?', [0]);
				break;
			case 'views':
				$objectList->getConditionBuilder()->add('article.views > ?', [0]);
				break;
		}
		
		if ($this->sortField === 'random') {
			$this->sortField = 'RAND()';
		}

		$objectList->getConditionBuilder()->add('article.articleIsFeatured = ?', [1]);
		
		return $objectList;
	}
	
	/**
	 * @inheritDoc
	 */
	protected function getTemplate() {
		return WCF::getTPL()->fetch('boxArticleList', 'wcf', [
			'boxArticleList' => $this->objectList,
			'boxSortField' => $this->sortField,
			'boxPosition' => $this->box->position
		], true);
	}
}