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
            //mysql_query("SET NAMES 'utf8';");
        }
        public function SelectKitties($order='k.id',$name=null, $startDate=null, $endDate=null, $breed=null){
            $query = $this->BuildQueryToSearchKitty($order,$name,$startDate,$endDate,$breed);
            $result = mysql_query($query,$this->connection);
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

        public function SelectKitty($id){
            $result = mysql_query('SELECT k.id,
                                          k.name,
                                          k.birth_date,
                                          k.sex,
                                          k.toilet_trained,
                                          b.name as breed,
                                          b.id as breed_id FROM kitties AS k INNER JOIN breeds AS b ON b.id = k.breed_id where k.id = '.$id.' order by k.id',$this->connection);
            if(!$result){
                die(mysql_error());
            }
            $kitty = mysql_fetch_array($result);

            mysql_free_result($result);
            return $kitty;
        }

        public function AddKitty($name,$birthDate,$sex,$breedId,$toiletTrained){
            $query = 'INSERT INTO `kitties` (`name`,`birth_date`,`sex`,`breed_id`,`toilet_trained`) VALUES("'
                .$name.'","'.$birthDate.'",'.$sex.','.$breedId.','.$toiletTrained.');';
             mysql_query($query);
            return mysql_insert_id();
        }
        public function DeleteKitty($id){
            $query = 'DELETE FROM `kitties` WHERE `id` = '.$id;
            return mysql_query($query);
        }
        public function SelectColorsForKitty($id){
            $query = 'SELECT c.name FROM `kitties` as k
                        join `kitties_colors` as kc
                        on k.id = kc.kitty_id
                        join colors as c
                        on c.id = kc.color_id
                        where k.id= '.$id;
            $result = mysql_query($query);
            if(!$result){
                die(mysql_error());
            }
            $colors = array();
            while($row = mysql_fetch_array($result)){
                if($row['name']){
                    array_push($colors,$row['name']);
                }
            }
            mysql_free_result($result);
            return $colors;
        }
        public function SelectColorsIdForKitty($id){
            $query = 'SELECT kc.color_id as color_id FROM `kitties` as k
                        join `kitties_colors` as kc
                        on k.id = kc.kitty_id
                        where k.id= '.$id;
            $result = mysql_query($query);
            if(!$result){
                die(mysql_error());
            }
            $colors = array();
            while($row = mysql_fetch_array($result)){
                if($row['color_id']){
                    array_push($colors,$row['color_id']);
                }
            }
            mysql_free_result($result);
            return $colors;
        }

        public function SelectColors(){
            $query = 'SELECT id,name from `colors`';
            $result = mysql_query($query);
            if(!$result){
                die(mysql_error());
            }
            $colors = array();
            while($row = mysql_fetch_array($result)){
                array_push($colors,$row);
            }
            mysql_free_result($result);
            return $colors;
        }


        public function AddBreed($name){
            $query = 'INSERT INTO `breeds` ( `name` ) values("'.$name.'")';
            return mysql_query($query);
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

             //var_dump($result);
            mysql_free_result($result);
             return $breeds;
        }
        public function __destruct(){
            mysql_close($this->connection);
        }

        public function AddColor($name)
        {
            $query = 'INSERT INTO `colors` ( `name` ) values("'.$name.'")';
            return mysql_query($query);
        }

        public function AddKittyColor($id, $color)
        {
            $query = 'INSERT INTO `kitties_colors` (`kitty_id`, `color_id`) SELECT '.$id.', '.$color.'
            FROM dual WHERE not exists (SELECT * FROM `kitties_colors` WHERE `kitty_id` = '.$id.' AND `color_id` = '.$color.' )';
            return mysql_query($query);
        }

        public function UpdateKitty($id, $name, $birthDate, $sex, $breed, $toilet)
        {
            $query = 'UPDATE `kitties` set
            `name`="'.$name.'",
            `birth_date`="'.$birthDate.'",
            `toilet_trained`='.$toilet.',
            `breed_id`='.$breed.',
            `sex`='.$sex.' where `id`="'.$id.'" ';
            return mysql_query($query);
        }

        public function DeleteColorsForKitty($id)
        {
            $query = 'DELETE FROM `kitties_colors` WHERE `kitty_id` = '.$id;
            return mysql_query($query);
        }
        private function BuildQueryToSearchKitty($order=null,$name=null, $startDate=null, $endDate=null, $breed=null){
            $query = " SELECT k.id,
                             k.name,
                             k.birth_date,
                             k.sex,
                             k.toilet_trained,
                             b.name as breed
                             FROM kitties AS k
                             INNER JOIN breeds AS b ON
                             b.id = k.breed_id";
            if($name || $startDate || $endDate || $breed){
                 $query.=' where ';
            }
            if($name){
                $query.=" k.name like '%".$name."%'";
            }
            if($startDate){
                if($name){
                    $query.=' and ';
                }
                $query.=" k.birth_date >= '".$startDate."'";
            }
            if($endDate){
                if($name || $startDate){
                    $query.=' and ';
                }
                $query.=" k.birth_date <= '".$endDate."'";
            }
            if($breed){
                if($name || $startDate || $endDate){
                    $query.=' and ';
                }
                $query.=(' b.id ='.$breed);
            }

            if($order){
                $query.=(' order by '.$order);
            }
            //die($query);
            return $query;
        }
    }
?>