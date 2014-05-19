<?php

class Application_Model_DbTable_List extends Zend_Db_Table_Abstract
{

    protected $_name = 'list';
    
    public function getList()
    {
        $list = $this->_db->select()
            ->from($this->_name, array('email' => 'email', 'auth_code' => 'auth_code', 'status' => 'status'))
            ->query()
            ->fetchAll();
            
        return $list;
    }
}

