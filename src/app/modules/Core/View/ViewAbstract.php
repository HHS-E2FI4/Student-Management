<?php
namespace Core\View;

abstract class ViewAbstract extends \Core\Model\Container
{
    public function render( $templateName ) {
        include './template/'.$templateName.'.phtml';
    }
    
    public function __( $string ) {
        echo $string;
    }
}