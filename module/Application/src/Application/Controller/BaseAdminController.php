<?php

namespace Application\Controller;

class BaseAdminController extends BaseController
{
    public function onDispatch( \Zend\Mvc\MvcEvent $e) {
        return parent::onDispatch($e);
    }
}


