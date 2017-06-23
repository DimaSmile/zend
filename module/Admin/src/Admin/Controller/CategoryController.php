<?php

namespace Admin\Controller;

use Application\Controller\BaseAdminController as BaseController;
use Admin\Form\CategoryAddForm;
use Blog\Entity\Category;


class CategoryController extends BaseController
{
    public function indexAction()
    {        
        $query = $this->getEntityManager()->createQuery('SELECT u FROM Blog\Entity\Category u ORDER BY u.id DESC');
        $rows =  $query->getResult();
        
        return array('category' => $rows);
    }
    
    public function addAction() {
        
        $form = new CategoryAddForm;
        $status = $message = '';
        $em = $this->getEntityManager();
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                
                $category = new Category();
                $category->exchangeArray($form->getData());
                
                $em->persist($category);
                $em->flush();
                
                $status = 'success';
                $message = 'Категория добавлена';
            }else{
                $status = 'error';
                $message = 'Ошибка параметров';
            }
        } else {
            return array('form' => $form);
        }
        
        if ($message) {
            $this->flashMessenger()
                    ->setNamespace($status)
                    ->addMessage($message);
        }
        
        return $this->redirect()->toRoute('admin/category');
    }
}
