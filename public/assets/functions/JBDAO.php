<?php

require '../config/config.php';

class JBDAO {
    public static function chkUser($user,$pass){
        $query = "SELECT * from ";
        $result = self::fetchQuery($query);
        return $result;
    }
}	
?>
