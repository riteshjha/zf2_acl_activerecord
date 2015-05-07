<?php
// module/User/src/User/Model/User.php:
namespace User\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class User extends \Custom\Model
{
    static $table_name = 'user';
    
    static $belongs_to = array(
      array('role', 'foreign_key' => 'role_id', 'class_name' => 'User\Model\Role')
    );

    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id']))     ? $data['id']     : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->username  = (isset($data['username']))  ? $data['username']  : null;
        $this->password  = (isset($data['password']))  ? $data['password']  : null;
    }

}