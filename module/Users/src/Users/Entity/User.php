<?php

namespace Users\Entity;

class User {

	protected $id;
	protected $username;
	protected $password;
	protected $passwordRequiresHash = false;

	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	public function getId() {
		return $this->id;
	}

	public function setUsername($username) {
		$this->username = $username;
		return $this;
	}

	public function getUsername() {
		return $this->username;
	}

	public function setPassword($password) {
		$this->password = $password;
		$this->passwordRequiresHash = true;
		return $this;
	}

	public function getPassword() {
		return $this->password;
	}

	public function hashPassword() {
		if (!empty($this->password) && $this->passwordRequiresHash) {
			$this->password = password_hash($this->password, PASSWORD_BCRYPT);
			$this->passwordRequiresHash = false;
		}
		return $this;
	}

}
