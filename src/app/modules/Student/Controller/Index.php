<?php
namespace Student\Controller;
use Core\Controller;

class Index extends \Core\Controller\ControllerAbstract
{    
    public function indexAction($request)
    {
        $view = \StudentManagement::getView('Student', 'Student');
        $view->render('add');
    }
    
    public function addAction($request)
    {
        $student = \StudentManagement::getModel('Student','Student');
        $view = \StudentManagement::getView('Student', 'Student');
        
        $convert = function($phrase){
                        $helper = \StudentManagement::getHelper('Student', 'Data');
                        return $helper->convertEncoding(
                                   $helper->convertUmlauts($phrase)
                                );
                    };
        
        $result = $student->setPrename( $convert($request['prename']) )
                          ->setSurname( $convert($request['surname']) )
                          ->setBirthdate( $convert($request['birthdate']) )
                          ->setEmail( $convert( $request['email']) )
                          ->setGender( $convert( $request['gender']) )
                          ->setCourse( $convert( $request['course']) )
                          ->setTan( $convert( $request['tan']) )
                          ->save();
                 
        $view->setQuery($result)->render('success');
    }
}