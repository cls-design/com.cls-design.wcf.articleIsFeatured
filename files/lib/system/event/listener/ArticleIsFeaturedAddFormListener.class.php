<?php
namespace wcf\system\event\listener;
use wcf\acp\form\ArticleAddForm;
use wcf\acp\form\ArticleEditForm;
use wcf\form\IForm;
use wcf\page\IPage;
use wcf\system\WCF;
use wcf\util\ClassUtil;
use wcf\util\StringUtil;

/**
 * Handles setting the article featured settings
 *
 * @author	cls-design
 * @copyright	2001-2017 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	WoltLabSuite\Core\System\Event\Listener
 */
class ArticleIsFeaturedAddFormListener implements IParameterizedEventListener {
	/**
	 * birthday of the created or edited person
	 * @var	string
	 */
	protected $articleIsFeatured = 0;
	
	/**
	 * @see	IPage::assignVariables()
	 */
	protected function assignVariables() {
		WCF::getTPL()->assign('articleIsFeatured', $this->articleIsFeatured);
	}
	
	/**
	 * @inheritDoc
	 */
	public function execute($eventObj, $className, $eventName, array &$parameters) {
		if (method_exists($this, $eventName) && $eventName !== 'execute') {
			$this->$eventName($eventObj);
		}
		else {
			throw new \LogicException('Unreachable');
		}
	}
	
	/**
	 * @see	IPage::readData()
	 */
	protected function readData(ArticleEditForm $form) {
		if (empty($_POST)) {
			$this->articleIsFeatured = $form->article->articleIsFeatured;
		}
	}
	
	/**
	 * @see	IForm::readFormParameters()
	 */
	protected function readFormParameters() {
		if (isset($_POST['articleIsFeatured'])) {
			$this->articleIsFeatured = intval($_POST['articleIsFeatured']);
		}
	}
	
	/**
	 * @see	IForm::save()
	 */
	protected function save(ArticleAddForm $form) {
		$form->additionalFields['articleIsFeatured'] = $this->articleIsFeatured;
	}
	
	/**
	 * @see	IForm::saved()
	 */
	protected function saved() {
		$this->articleIsFeatured = 0;
	}
	
	/**
	 * @see	IForm::validate()
	 */
	protected function validate() {
		if (empty($this->articleIsFeatured)) {
			return;
		}
	}
}
