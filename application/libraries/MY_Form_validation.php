<?php

/**
 * Base model to enhance form validation library
 */
class MY_Form_validation extends CI_Form_validation {

    function run($module = '', $group = '')
    {
        (is_object($module)) AND $this->CI = &$module;
        return parent::run($group); // TODO: Change the autogenerated stub
    }

}