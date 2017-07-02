<?php

namespace Admin\Service;

use Doctrine\Common\Persistence\ObjectRepository;
use DoctrineModule\Validator\ObjectExists;


class IsExistValidator
{
	protected $validator;
	protected $repository;

	public function __construct(ObjectRepository $objectRepository){
		$this->repository = $objectRepository; 
	}

	public function exists($value, $fields){
		$this->validator = new ObjectExists(array(
			'object_repository' => $this->repository,
			'fields' => $fields
			));
		return $this->validator->isValid($value);
	}
}


