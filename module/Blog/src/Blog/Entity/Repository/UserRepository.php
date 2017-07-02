<?php

namespace Blog\Entity\Repository;

use Doctrine\ORM\EntityRepository;

	
class UserRepository extends EntityRepository
{
	
	public function login(\Blog\Entity\User $user, $em){
		$authService = $em->get('Zend\Authentication\AuthenticationService');
		$adapter = $authService->getAdapter();
		$adapter->setIdentityValue($user->getUsrName());
		$adapter->setCredentialValue($user->getUsrPassword());
		$authResult = $authService->authenticate();
		$identity = null;

		if ($authResult->isValid()) {
			$identity = $authResult->getIdentity();
			$authService->getStorage()->write($identity);
		}
		return $authResult;
	}
	
}