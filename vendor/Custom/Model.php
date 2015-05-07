<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Custom;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Model extends \ActiveRecord\Model implements InputFilterAwareInterface {

    public function setInputFilter(InputFilterInterface $inputFilter) {  }

    public function getInputFilter() { }
    
    public function getArrayCopy(){
        return $this->attributes();
    }
}
