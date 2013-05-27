<?php
namespace Student\Model;
use Core\Model;


class CollectionAbstract extends \Core\Model\ResourceAbstract
{
    protected function computeUsername( $param = array() )
    {
        $surname = $param['surname'];
        $prename = $param['prename'];
        
        $username = $surname.$prename[0].$prename[1];
        if( true ) {
            $id = null;
        } else {
            $id = null;            
        }
        return $username.$id;
    }
}