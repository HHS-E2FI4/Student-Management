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
    
    public function save() {
        
        $values = array(
                md5($this->getEmail()),
                $this->getSurname().$this->getPrename()[0].$this->getPrename()[1],
                '12345678901234567890',
                $this->getSurname(),
                $this->getPrename(),
                $this->getGender(),
                $this->getEmail(),
                $this->getBirthdate(),
                $this->getCourse(),
            );
        
        $sql = 'INSERT INTO student( sid, username, tan, surname, prename, gender, email, birthday, course
        ) VALUES ('.implode(',',$values).');';
        
        
        return $sql;
    }
      
    
}