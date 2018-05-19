<?php

function my_decode($id = null)
{
    $CI =& get_instance();
    return $decode = $CI->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
}

function my_encode($id = null)
{
    $CI =& get_instance();
    return $encode = str_replace(array('+', '/', '='), array('-', '_', '~'), $CI->encrypt->encode($id));
}