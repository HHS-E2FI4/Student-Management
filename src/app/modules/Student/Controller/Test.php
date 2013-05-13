<?php
namespace Student\Controller;
use Core\Controller;

class Test extends \Core\Controller\ControllerAbstract
{    
    public function debugAction($request)
    {
        $student = \StudentManagement::getModel('Student','Student');

        $student->setPrename($request['prename'])
             ->setSurname($request['surname'])
             ->setBirthdate($request['birthdate'])
             ->setEmail($request['email'])
             ->setGender($request['gender'])
             ->setCourse($request['course'])
             ->save();
    }
}