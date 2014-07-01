<?php

namespace Common\Mapper;

use Doctrine\ORM\EntityManager;

abstract class AbstractMapper {

	protected $entityClass;
	protected $entityManager;

	public function __construct(EntityManager $entityManager, $entityClass = null) {
		$this->entityManager = $entityManager;
		if ($entityClass) {
			$this->setEntityClass($entityClass);
		}
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
		return $this->getEntityManager()->getRepository($this->getEntityClass());
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
