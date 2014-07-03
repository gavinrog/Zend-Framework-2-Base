<?php

namespace Users\Filter;

use Zend\InputFilter\InputFilter,
	Zend\EventManager\EventManagerAwareInterface,
	Common\EventManager\EventsProviderTrait,
	Zend\Validator\NotEmpty;

class LoginFilter extends InputFilter implements EventManagerAwareInterface {

	use EventsProviderTrait;

	public function __construct() {

		$this->add(array(
			'name' => 'username',
			'required' => true,
			'validators' => array(
				array(
					'name' => 'NotEmpty',
					'options' => array(
						'messages' => array(
							NotEmpty::IS_EMPTY => 'You must enter a username'
						)
					),
				),
			),
		));

		$this->add(array(
			'name' => 'password',
			'required' => true,
			'validators' => array(
				array(
					'name' => 'NotEmpty',
					'options' => array(
						'messages' => array(
							NotEmpty::IS_EMPTY => 'You must enter a password'
						)
					),
				),
			),
		));

		$this->getEventManager()->trigger('init', $this);
	}

}
