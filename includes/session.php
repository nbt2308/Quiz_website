<?php 
    if(!defined('_PERMISSION')){
        die("Truy cập không hợp lệ") ;
    } 

    //set session
    function setSesstion($key, $value){
        if(!empty(session_id())){
            $_SESSION[$key]=$value;
            return true;
        }
        return false;
    }


    //get session
    function getSession($key=""){
        if(empty($key)){
            return $_SESSION;
        }
        else{
            if(isset($_SESSION[$key])){
                return $_SESSION[$key];
            }
        }
        return false;
    }

    //delete session
    function deleteSession($key=''){
        if(empty($key)){
            session_destroy();
            return true;
        }else{
             if(isset($_SESSION[$key])){
                unset($_SESSION[$key]);
            }
            return true;
        }
        return false;
    }

    //Tao session flash
    function setSesstionFlash($key, $value){
        $key=$key . 'Flasd';
        $rel=setSesstion($key,$value);
        return $rel; 
    }

    //get session flash
    function getSessionFlash($key){
        $key=$key .'Flash';
        $rel=getSession($key);

        deleteSession($key);
        return $rel;
    }