<?php
require_once 'settings.php';
    class KittiesDalc{
        private $connection;
        public function KittiesDalc(){
           $this->connection= mysql_connect(Settings::$dbUrl,Settings::$dbLogin,Settings::$dbPassword);
            if(!$this->connection){
            	die ('MySql connection problem: ' .mysql_error(). '<br />');
            }
            mysql_select_db(Settings::$dbName,$this->connection);

            mysql_set_charset('utf8');
        }
        public function SelectKitties(){
            $result = mysql_query('SELECT k.id,k.name,k.birth_date,k.sex,k.toilet_trained, b.name as breed FROM kitties AS k INNER JOIN breeds AS b ON b.id = k.breed_id',$this->connection);
            if(!$result){
                die(mysql_error());
            }
            $kitties = array();
            while($row = mysql_fetch_array($result)){
                array_push($kitties,$row);
            }
            mysql_free_result($result);
            return $kitties;
        }
        public function AddKitty($name,$birthDate,$sex,$breedId,$toiletTrained){
            $query = 'INSERT INTO `kitties` (`name`,`birth_date`,`sex`,`breed_id`,`toilet_trained`) VALUES("'
                .$name.'","'.$birthDate.'",'.$sex.','.$breedId.','.$toiletTrained.')';

            return mysql_query($query);
        }
        public function DeleteKitty($id){
            $query = 'DELETE FROM `kitties` WHERE `id` = '.$id;
            return mysql_query($query);
        }


        public function AddBreed($name){

        }
        public function SelectBreeds(){
             $result = mysql_query('select * from breeds',$this->connection);
             if(!$result){
                die(mysql_error());
            }
              $breeds = array();
            while($row = mysql_fetch_array($result)){
                array_push($breeds,$row);
             }

             var_dump($result);
            mysql_free_result($result);
             return $breeds;
        }
        public function __destruct(){
            mysql_close($this->connection);
        }
    }
?>