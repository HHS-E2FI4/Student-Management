<?php
namespace Student\Controller;
use Core\Controller;

class Test extends \Core\Controller\ControllerAbstract
{    
    public function indexAction($request)
    {
        $view = \StudentManagement::getView('Student', 'Test');
        $view->render('add');
    }
    
    public function addAction($request)
    {
        $student = \StudentManagement::getModel('Student','Student');
        $view = \StudentManagement::getView('Student', 'Test');

        $result = $student->setPrename($request['prename'])
                         ->setSurname($request['surname'])
                         ->setBirthdate($request['birthdate'])
                         ->setEmail($request['email'])
                         ->setGender($request['gender'])
                         ->setCourse($request['course'])
                         ->save();
        
        $view->setQuery($result)->render('success');
        
    }
}