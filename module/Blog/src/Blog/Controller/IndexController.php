<?php

namespace Blog\Controller;

use Application\Controller\BaseController as BaseController;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Blog\Entity\Comment;

class IndexController extends BaseController
{
    public function indexAction()
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        
        $query
            ->add('select', 'a')
            ->add('from', 'Blog\Entity\Article a')
            ->add('where', 'a.isPublic=1')
            ->add('orderBy', 'a.id ASC');
        
        $adapter = new DoctrineAdapter(new ORMPaginator($query));
        
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(1);
        $paginator->setCurrentPageNumber( (int) $this->params()->fromQuery('page', 1));
        
        return array('articles' => $paginator);
                
    }
    
    protected function getCommentForm(Comment $comment) {
        $builder = new AnnotationBuilder($this->getEntityManager());
        $form = $builder->createForm(new Comment());
        $form->setHydrator(new DoctrineHydrator($this->getEntityManager(), '\Comment'));
        $form->bind($comment);
        
        return $form;
    }
    
    public function articleAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        $em = $this->getEntityManager();
        $article = $em->find('Blog\Entity\Article', $id);
        
        if (empty($article)) {
            return $this->notFoundAction();
        }
        
        
        $comment = new Comment();
        $form = $this->getCommentForm($comment);
        
        
        return array('article' => $article, 'form' => $form);
    }
    
    public function commentAddAction() {
        $em = $this->getEntityManager();
        $comment = new Comment();
        
        $form = $this->getCommentForm($comment);
        $request = $this->getRequest();
        $response = $this->getResponse();
        
        $data = $request->getPost();
        
        if (!empty($data)) {
            
            $form->setData($data);
            $messages = null;
            
            if (! $form->isValid()) {
                $errors = $form->getMessages();
                foreach ($errors as $key => $row) {
                    if (!empty($row) && $key != 'submit') {
                        foreach ($row as $keyer => $rower){
                            $messages[$key][] = $rower;
                        }
                    }
                }
            }
            
            if (!empty($messages)){
                $response->setContent(\Zend\Json\Json::encode($messages));
            }else{
                $em->persist($comment);
                $em->flush($comment);
                $response->setContent(\Zend\Json\Json::encode(array('success' => 1)));
            }
        }
        return $response;
    }
}
