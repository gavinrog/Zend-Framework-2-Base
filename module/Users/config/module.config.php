<?php

use Users\Mapper\Users as UsersMapper;

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
return array(
	'doctrine' => array(
		'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'Users\Entity\User',
                'identity_property' => 'username',
                'credential_property' => 'password',
				'credential_callable' => function($entity, $password){
					return $entity->getPassword() == md5($password);
				}
            ),
        ),
		'driver' => array(
			'user_entity' => array(
				'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
				'paths' => __DIR__ . '/xml/users'
			),
			'orm_default' => array(
				'drivers' => array(
					'Users\Entity' => 'user_entity'
				)
			)
		),		
	),
	'service_manager' => array(
		'factories' => array(
			'AuthService' => function($sm){
				return $sm->get('doctrine.authenticationservice.orm_default');
			},
			'UsersMapper' => function($sm){
				return new UsersMapper($sm->get('Doctrine\ORM\EntityManager'));
			},					
		)
	),
	'controllers' => array(
		'invokables' => array(
			'Users\Controller\Index' => 'Users\Controller\IndexController'
		),
	),
	'router' => array(
		'routes' => array(
			'users' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/account',
					'defaults' => array(
						'__NAMESPACE__' => 'Users\Controller',
						'controller' => 'Index',
						'action' => 'index',
					),
				),
				'may_terminate' => true,
				'child_routes' => array(
					'default' => array(
						'type' => 'Segment',
						'options' => array(
							'route' => '/[:controller[/:action]]',
							'constraints' => array(
								'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							),
						),
					),
				),
			),
		),
	),
	'view_manager' => array(
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
	),
);
