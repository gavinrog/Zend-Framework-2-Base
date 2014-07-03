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
	Users\Form\LoginForm;

class IndexController extends AbstractActionController {

	private $usersMapper;

	public function indexAction() {

		$user = $this->getUsersMapper()->fetchOne(1);

		$user->setPassword('test');

		$this->getUsersMapper()->persist($user);

		return new ViewModel(compact('user'));
	}

	public function loginAction() {

		$form = new LoginForm;

		if ($this->request->isPost()) {

			$form->setData($this->request->getPost());

			if ($form->isValid()) {

				$data = $form->getData();

				$adapter = $this->user()->getAuthAdapter();

				$adapter->setIdentityValue($data['username']);
				$adapter->setCredentialValue($data['password']);

				$result = $this->user()->authenticate();

				if ($result->isValid()) {
					echo "logged in";
				}
				else {
					echo "not logged in";
				}
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
