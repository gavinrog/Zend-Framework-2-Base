<?php

namespace Common\Mapper;

use Doctrine\ORM\EntityManager,
    Common\Mapper\Exception\NoEntityException;

abstract class AbstractMapper {

    protected $entityClass;
    protected $entityManager;

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

}
