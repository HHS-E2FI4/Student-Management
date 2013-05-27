<?php
namespace Student\Model;
use Core\Model;

class Student extends \Core\Model\ModelAbstract
{
    private $prename = null;
    private $surname = null;
    private $birthdate = null;
    private $email = null;
    private $gender = null;
    private $course = null;
    private $tan = null;

    public function __construct()
    {
    }
    
    public function setPrename($prename)
    {
        $this->prename = $prename;
        return $this;
    }
    
    public function setSurname($surname)
    {
        $this->surname = $surname;
        return $this;
    }
    
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
        return $this;
    }
    
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
    
    public function setGender($gender)
    {
        $this->gender = $gender;
        return $this;
    }
    
    public function setCourse($course)
    {
        $this->course = $course;
        return $this;
    }
    
    public function setTan($tan)
    {
        $this->tan = $tan;
        return $this;
    }
    
    public function getPrename()
    {
        return $this->prename;
    }
    
    public function getSurname()
    {
        return $this->surname;
    }
    
    public function getBirthdate()
    {
        return $this->birthdate;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    
    public function getGender()
    {
        return $this->gender;
    }
    
    public function getCourse()
    {
        return $this->course;
    }
    
    public function getTan()
    {
        return $this->tan;
    }
    
    public function save()
    {
        $entry = array(
                        'table' => 'student',
                        'items' => array(
                            'username'   => array( 'value' => 'php!->'.'computeUsername',
                                                   'param' => array( 
                                                               'surname' => $this->getSurname(),
                                                               'prename' => $this->getPrename()
                                                              )
                                                 ),
                            'prename'    => array( 'value' => 'raw!->'.$this->getPrename() ),
                            'surname'    => array( 'value' => 'raw!->'.$this->getSurname() ),
                            'email'      => array( 'value' => 'raw!->'.$this->getEmail() ),
                            'birthdate'  => array( 'value' => 'raw!->'.$this->getBirthdate() ),
                            'gender'     => array( 'value' => 'raw!->'.$this->getGender() ),
                            'course'     => array( 'value' => 'raw!->'.$this->getCourse() ),
                       ),
                    );
        $resource = \StudentManagement::getModel('Student', 'Resource');
        $resource->write( $entry );
    }
      
    
}