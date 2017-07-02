<?php

namespace AuthDoctrine\Controller;

use Application\Controller\BaseController as BaseController;

use Blog\Entity\User;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class IndexController extends BaseController{
    
    public function indexAction() {

        $em = $this->getEntityManager();
        $users = $em->getRepository('Blog\Entity\User')->findAll();
        
        return array('users' => $users);
    }

    protected function getUserForm(User $user){
    	$builder = new AnnotationBuilder($this->getEntityManager());
    	$form = $builder->createForm('\Blog\Entity\User');
    	$form->setHydrator(new DoctrineHydrator($this->getEntityManager(), '\User'));
    	$form->bind($user);

    	return $form;
    }

    protected function getLoginForm(User $user){
    	$form = $this->getUserForm($user);
    	$form->setAttribute('action', '/auth-doctrine/index/login/');
    	$form->setValidationGroup('usrName', 'usrPassword');

    	return $form;
    }


    public function loginAction(){
    	$em = $this->getEntityManager();
    	$user = new User();
    	$form = $this->getLoginForm($user);

    	$messages = null;
    	$request = $this->getRequest();

    	if ($request->isPost()){
    		$form->setData($request->getPost());
    		if ($form->isValid()) {
    			$user = $form->getData();
    			$authResult = $em->getRepository('Blog\Entity\User')->login($user, $this->getServiceLocator());
    			if ($authResult->getCode() != \Zend\Authentication\Result::SUCCESS) {
    				foreach ($authResult->getMessages() as $message) {
    					$message .= "$message\n";
    				}
    			}else{
    				return array(
					);
    			}
    		}
    	}

    	return array(
    		'form' => $form,
    		'messages' => $messages,
    		);
    }

    public function logautAction(){
    	$auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');

    	if ($auth->hasIdentity()) {
    		$identity = $auth->getIdentity();
    	}

    	$auth->clearIdentity();
    	$sessionManager = new \Zend\Session\SessionManager();
    	$sessionManager->forgetMe();

    	return $this->redirect()->toRoute('auth-doctrine/default', array('controller' => 'index', 'action' => 'login'));
    }
}