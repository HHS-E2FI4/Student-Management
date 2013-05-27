<?php
namespace Student\Model;
use Core\Model;


class Resource extends \Core\Model\ResourceAbstract
{
    protected function computeUsername( $param = array() )
    {
        $surname = $param['surname'];
        $prename = $param['prename'];
        
        $username = $surname.$prename[0].$prename[1];
        
        $id = $this->getAvailableIdForUsername($username);
        if( 0 !== $id ) {
            $username = $username.(++$id);
        }
        return $username;
    }
    
    protected function getAvailableIdForUsername($username)
    {
        $sql = 'SELECT * FROM student WHERE username LIKE'.$this->quote($username.'%').';';
        return count(  $this->query($sql)->fetchAll() );
    }
    
}