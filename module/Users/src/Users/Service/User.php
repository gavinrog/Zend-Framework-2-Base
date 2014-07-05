<?php

namespace Users\Service;

use Common\EventManager\EventsProviderTrait,
    Common\Mapper\AbstractMapper,
    Users\Form\LoginForm,
    Zend\Authentication\AuthenticationServiceInterface,
    DoctrineModule\Authentication\Adapter\ObjectRepository,
    Zend\Crypt\Password\Bcrypt,
    Zend\Crypt\Password\PasswordInterface,
    Zend\EventManager\EventManagerAwareInterface,
    Zend\Form\FormInterface,
    Zend\ServiceManager\ServiceLocatorAwareInterface,
    Zend\ServiceManager\ServiceLocatorAwareTrait,
    Zend\ServiceManager\ServiceLocatorInterface,
    Zend\Stdlib\Parameters;

class User implements EventManagerAwareInterface, ServiceLocatorAwareInterface {

    use EventsProviderTrait,
        ServiceLocatorAwareTrait;

    protected $authAdapter;
    protected $authService;
    protected $loginForm;
    protected $passwordTreatment;
    protected $userMapper;

    public function __construct(ServiceLocatorInterface $serviceLocator) {
        $this->setServiceLocator($serviceLocator);
    }

    public function setLoginForm(FormInterface $form) {
        $this->loginForm = $form;
        return $this;
    }

    public function getLoginForm() {
        if (!$this->loginForm) {
            $this->setLoginForm(new LoginForm);
        }
        return $this->loginForm;
    }

    public function setUserMapper(AbstractMapper $mapper) {
        $this->userMapper = $mapper;
        return $this;
    }

    public function getUserMapper() {
        if (!$this->userMapper) {
            $this->setUserMapper($this->getServiceLocator()->get('UsersMapper'));
        }
        return $this->userMapper;
    }

    public function setAuthAdapter(ObjectRepository $adapter) {
        $this->authAdapter = $adapter;
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
        if (!$this->authService) {
            $this->setAuthService($this->getServiceLocator()->get('AuthService'));
        }
        return $this->authService;
    }

    public function getPasswordTreatment() {
        if (!$this->passwordTreatment) {
            $this->setPasswordTreatment(new Bcrypt);
        }
        return $this->passwordTreatment;
    }

    public function setPasswordTreatment(PasswordInterface $passwordTreatment) {
        $this->passwordTreatment = $passwordTreatment;
        return $this;
    }

    public function login(Parameters $params) {

        $form = $this->getLoginForm();

        $entityClass = $this->getUserMapper()->getEntityClass();

        $form->bind(new $entityClass);
        $form->setData($params);

        if (!$form->isValid()) {
            return false;
        }

        $user = $form->getData();

        $adapter = $this->getAuthAdapter();

        $adapter->setIdentityValue($user->getUsername());
        $adapter->setCredentialValue($user->getPassword());

        $adapter->getOptions()->setCredentialCallable(function($entity, $password) {
            return $this->getPasswordTreatment()->verify($password, $entity->getPassword());
        });

        $result = $this->getAuthService()->authenticate();

        $this->getEventManager()->trigger('authenticate', $this, compact('result'));

        return $result->isValid();
    }

}
