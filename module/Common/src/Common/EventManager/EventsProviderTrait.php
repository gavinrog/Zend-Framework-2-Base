<?php

namespace Common\EventManager;

use Zend\EventManager\EventManagerInterface,
	Zend\EventManager\EventManager;

trait EventsProviderTrait {

	protected $eventManager;

	public function setEventManager(EventManagerInterface $eventManager) {

		$identifiers = array_merge($eventManager->getIdentifiers(), array(__CLASS__, get_called_class()));

		if (!empty($this->eventIdentifier)) {
			$identifiers = array_merge($identifiers, (array) $this->eventIdentifier);
		}

		$eventManager->setIdentifiers(array_unique($identifiers));
		$this->eventManager = $eventManager;

		return $this;
	}

	public function getEventManager() {
		if (!$this->eventManager) {
			$this->setEventManager(new EventManager);
		}
		return $this->eventManager;
	}

}
