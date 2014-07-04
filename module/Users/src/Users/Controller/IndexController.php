<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Users\Controller;

use Zend\Http\PhpEnvironment\Response,
    Zend\Mvc\Controller\AbstractActionController,
    Zend\Stdlib\Parameters,
    Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    private $usersMapper;
    private $userService;

    public function indexAction() {

        $user = $this->getUsersMapper()->fetchOne(1);

        return new ViewModel(compact('user'));
    }

    public function loginAction() {

        $service = $this->getUserService();

        $prg = $this->prg($this->url()->fromRoute('users/default', array('action' => 'login')), true);

        if ($prg instanceof Response) {
            return $prg;
        }

        if ($prg !== false) {
            if ($service->login(new Parameters($prg))) {
                return $this->redirect()->toRoute('users');
            }
        }

        return new ViewModel(array(
            'form' => $service->getLoginForm()
        ));
    }

    public function getUsersMapper() {
        if (!$this->usersMapper) {
            $this->usersMapper = $this->getServiceLocator()->get('UsersMapper');
        }
        return $this->usersMapper;
    }

    public function getUserService() {

        if (!$this->userService) {
            $this->userService = $this->getServiceLocator()->get('UserService');
        }

        return $this->userService;
    }

}
