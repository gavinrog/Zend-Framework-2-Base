<?php

namespace Users\Form;

use Zend\Form\Form,
	Users\Filter\LoginFilter,
	Zend\Stdlib\Hydrator\ClassMethods;

class LoginForm extends Form {

	public function __construct($name = null, $options = array()) {

		parent::__construct('login');

		$this->setAttribute('method', 'post');

		$this->setInputFilter(new LoginFilter);

		$this->setHydrator(new ClassMethods);

		$this->add(array(
			'name' => 'username',
			'type' => 'text',
			'options' => array(
				'label' => 'Username',
			)
		));

		$this->add(array(
			'name' => 'password',
			'type' => 'password',
			'options' => array(
				'label' => 'Password',
			)
		));

		$this->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type' => 'submit',
				'value' => 'Go',
				'class' => 'btn btn-primary',
			),
		));
	}

}
