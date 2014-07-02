<?php

namespace Common\Mapper;

use Zend\EventManager\EventManagerAwareInterface,
	Zend\EventManager\EventManagerInterface,
	Zend\EventManager\EventManager,
	Doctrine\ORM\EntityManager,
	Common\Mapper\Exception\NoEntityException;

abstract class AbstractMapper implements EventManagerAwareInterface {

	protected $entityClass;
	protected $entityManager;
	protected $eventManager;

	public function __construct(EntityManager $entityManager) {
		if (!$this->entityClass) {
			throw new NoEntityException('You must set an entity class');
		}
		$this->entityManager = $entityManager;
	}

	public function setEntityManager(EntityManager $entityManager) {
		$this->entityManager = $entityManager;
		return $this;
	}

	public function getEntityManager() {
		return $this->entityManager;
	}

	public function getEntityClass() {
		return $this->entityClass;
	}

	public function setEntityClass($entityClass) {
		$this->entityClass = $entityClass;
		return $this;
	}

	public function setEventManager(EventManagerInterface $eventManager) {
		$this->eventManager = $eventManager;
	}

	public function getEventManager() {
		if (!$this->eventManager) {
			$this->setEventManager(new EventManager(array(__CLASS__, get_called_class())));
		}
		return $this->eventManager;
	}

	protected function getRepository() {
		return $this->getEntityManager()->getRepository($this->entityClass);
	}

	public function fetchOne($id) {
		return $this->getRepository()->find($id);
	}

	public function fetchAll() {
		return $this->getRepository()->fetchAll();
	}

	public function fetchBy(array $criteria) {
		return $this->getRepository()->findBy($criteria);
	}

}
