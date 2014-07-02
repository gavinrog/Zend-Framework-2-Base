<?php

namespace Users\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin,
	Zend\Authentication\Adapter\AdapterInterface,
	Zend\Authentication\AuthenticationServiceInterface;

class User extends AbstractPlugin {

	protected $authAdapter;
	protected $authService;

	public function setAuthAdapter(AdapterInterface $adapter) {
		$this->adapter = $adapter;
		return $this;
	}

	public function getAuthAdapter() {
		return $this->authAdapter;
	}

	public function setAuthService(AuthenticationServiceInterface $authService) {
		$this->authService = $authService;
		return $this;
	}

	public function getAuthService() {
		return $this->authService;
	}

}
