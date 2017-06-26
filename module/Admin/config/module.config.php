<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'category' => 'Admin\Controller\CategoryController',
            'article' => 'Admin\Controller\ArticleController',
            'comment' => 'Admin\Controller\CommentController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/admin/',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'category' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => 'category/[:action/][:id/]',
                            'defaults' => array(
                                'controller' => 'category',
                                'action' => 'index',
                            ),
                        ),
                    ),
                    'article' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => 'article/[:action/][:id/]',
                            'defaults' => array(
                                'controller' => 'article',
                                'action' => 'index',
                            ),
                        ),
                    ),
                    
                    'comment' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => 'comment/[:action/][:id/]',
                            'defaults' => array(
                                'controller' => 'comment',
                                'action' => 'index',
                            ),
                        ),
                    ),
                ), //child_routes
            ),
        ),
    ),
    
    
    //Навигация
    'service_manager' => array(
        'factories' => array(
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
            'admin_navigation' => 'Admin\Lib\AdminNavigationFactory',
        ),
    ),
    
    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Главная',
                'route' => 'home',
            ),
        ),
        'admin_navigation' => array(
            array(
                'label' => 'Панель управления сайтом',
                'route' => 'admin',
                'action' => 'index',
                'resource' => 'Admin\Controller\Index',
                'pages' => array(
                    array(
                        'label' => 'Статья',
                        'route' => 'admin/article',
                        'action' => 'index',
                    ),
                    array(
                        'label' => 'Добавить статью',
                        'route' => 'admin/article',
                        'action' => 'add',
                    ),
                    array(
                        'label' => 'Категории',
                        'route' => 'admin/category',
                        'action' => 'index',
                    ),
                    array(
                        'label' => 'Добавить категорию',
                        'route' => 'admin/category',
                        'action' => 'add',
                    ),
                    
                    array(
                        'label' => 'Комментарии',
                        'route' => 'admin/comment',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    //nav end
    
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'template_map' => array(
            'pagination_control' => __DIR__ . '/../view/layout/pagination_control.phtml',
        ),
    ),
    
    
    //Git: ericpaige/EdpModuleLayouts
    'module_layouts' => array(
        'Admin' => array(
            'default' => 'layout/admin-layout',
        )
    ),
);


