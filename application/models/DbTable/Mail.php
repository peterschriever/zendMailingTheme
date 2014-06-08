<?php

class Application_Model_DbTable_Mail extends Zend_Db_Table_Abstract
{

    protected $_name = 'mails';

    public function getNextId() {
        $c = $this->fetchAll()->count();
        $c = $c+1;
        return $c;
    }

}

