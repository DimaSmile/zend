<?php


namespace Admin;

class Module
{
    

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

     public function getServiceConfig(){
        return array(
            'factories' => array(
                'Admin\Service\IsExistValidator' => function($serviceLocator){
                    $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
                    $repository = $entityManager->getRepository('Blog\Entity\User');

                    return new \Admin\Service\IsExistValidator($repository);
                },
            ),
        );
    }
}
