<?php
require_once 'settings.php';
    class KittiesDalc{
        private $connection;
        public function KittiesDalc(){
            $connection = mysql_connect(Settings::$dbUrl,Settings::$dbLogin,Settings::$dbPassword);
            if(!$connection){
            	die ('MySql connection problem: ' .mysql_error(). '<br />');
            }
            mysql_select_db(Settings::$dbName,$connection);

            mysql_set_charset('utf8');
        }
        public function SelectKitties(){
            $result = mysql_query('call select_kitties_with_breed()');
            if(!$result){
                die(mysql_error());
            }
            $kitties = array();
            while($row = mysql_fetch_array($result)){
                array_push($kitties,$row);
             }

             return $kitties;
        }
    }
?>