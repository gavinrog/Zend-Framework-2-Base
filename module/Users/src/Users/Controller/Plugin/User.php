<?php

namespace Users\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin,
    Zend\Authentication\AuthenticationServiceInterface;

class User extends AbstractPlugin {

    protected $authService;

    public function __construct(AuthenticationServiceInterface $authService) {
        $this->setAuthService($authService);
    }

    public function setAuthService(AuthenticationServiceInterface $authService) {
        $this->authService = $authService;
        return $this;
    }

    public function getAuthService() {
        return $this->authService;
    }

    public function getIdentity() {
        return $this->getAuthService()->getIdentity();
    }

    public function hasIdentity() {
        return $this->getAuthService()->hasIdentity();
    }

}
