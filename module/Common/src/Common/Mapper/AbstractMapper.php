<?php

namespace Common\Mapper;

use Zend\EventManager\EventManagerAwareInterface,
	Common\EventManager\EventsProviderTrait,
	Common\Mapper\Exception\NoEntityException,
	Doctrine\ORM\EntityManager;

abstract class AbstractMapper implements EventManagerAwareInterface {

	use EventsProviderTrait;

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

	public function persist($entity) {
		$manager = $this->getEntityManager();
		$manager->persist($entity);
		$manager->flush();
		return $entity;
	}

}
