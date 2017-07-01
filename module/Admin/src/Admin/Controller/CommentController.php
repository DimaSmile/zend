<?php

namespace Admin\Controller;

use Application\Controller\BaseAdminController as BaseController;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

use Blog\Entity\Comment;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;

class CommentController extends BaseController{
    
    public function indexAction() {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query
                ->select('a')
                ->from('\Blog\Entity\Comment', 'a')
                ->orderBy('a.id', 'DESC');
        
        $adapter = new DoctrineAdapter(new ORMPaginator($query));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        
        return array('comments' => $paginator);
    }
    
    protected function getCommentForm(Comment $comment) {
        $builder = new AnnotationBuilder($this->getEntityManager());
        $form = $builder->createForm(new Comment());
        $form->setHydrator(new DoctrineHydrator($this->getEntityManager(), '\Comment'));
        $form->bind($comment);
        
        return $form;
    }
    
    public function editAction() {
        $message = $status = '';
        $em = $this->getEntityManager();
        
        $id = (int) $this->params()->fromRoute('id', 0);
        $comment = $em->find('Blog\Entity\Comment', $id);
        
        if (empty($comment)) {
            $message = 'Комментарий не найден';
            $status = 'error';
            $this->flashMessenger()
                    ->setNamespace($status)
                    ->addMessage($message);
            return $this->redirect()->toRoute('admin/comment');
        }
        
        $form = $this->getCommentForm($comment);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            
            $data = $request->getPost();
            $form->setData($data);
            
            if ($form->isValid()) {
                
                $em->persist($comment);
                $em->flush();
                
                $status = 'success';
                $message = 'Комментарий обновлен';
                
            }else{
                $status = 'error';
                $message = 'Ошибка параметров';
                foreach ($form->getInputFilter()->getInvalidInput() as $errors) {
                    foreach ($errors->getMessages() as $error) {
                        $message .=  ' ' .$error;
                    }
                }
            }    
        }else{
            return array('form' => $form, 'id' => $id, 'comment' => $comment);
        }
        
        if ($message) {
            $this->flashMessenger()
                    ->setNamespace($status)
                    ->addMessage($message);
        }
        return $this->redirect()->toRoute('admin/comment');
    }
}
