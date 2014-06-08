<?php

class Application_Form_Element_ThemeSelect extends Zend_Form_Element_Select {
    public function init() {
        $themes = new Application_Model_DbTable_Themes();  // insert themes model
        $this->addMultiOption(2, 'Please select...');
        foreach ($themes->fetchAll($themes->select()->where("id != 2")) as $theme) {
            $this->addMultiOption($theme['id'], $theme['name']);
        }
    }
}