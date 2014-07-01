<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

	private $usersMapper;

	public function indexAction() {

		$user = $this->getUsersMapper()->fetchOne(1);

		return new ViewModel(compact('user'));
	}

	private function getUsersMapper() {
		if (!$this->usersMapper) {
			$this->usersMapper = $this->getServiceLocator()->get('UsersMapper');
		}
		return $this->usersMapper;
	}

}
