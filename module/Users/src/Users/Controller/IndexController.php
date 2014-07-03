<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController,
	Zend\View\Model\ViewModel,
	Users\Form\LoginForm,
	Users\Entity\User as UserEntity;

class IndexController extends AbstractActionController {

	private $usersMapper;

	public function indexAction() {

		$user = $this->getUsersMapper()->fetchOne(1);

		return new ViewModel(compact('user'));
	}

	public function loginAction() {

		$form = new LoginForm;

		$form->bind(new UserEntity);

		if ($this->request->isPost()) {

			$form->setData($this->request->getPost());

			if ($form->isValid()) {

				$user = $form->getObject();

				$adapter = $this->user()->getAuthAdapter();
				$adapter->setIdentityValue($user->getUsername());
				$adapter->setCredentialValue($user->getPassword());

				$result = $this->user()->authenticate();

				if (!$result->isValid()) {
					die('Logged in');
				}

				die('Not Logged In');
			}
		}

		return new ViewModel(compact('form'));
	}

	private function getUsersMapper() {
		if (!$this->usersMapper) {
			$this->usersMapper = $this->getServiceLocator()->get('UsersMapper');
		}
		return $this->usersMapper;
	}

}
