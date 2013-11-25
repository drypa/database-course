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
            return $this->SelectEntity('colors');
        }

        public function SelectBreeds(){
            return $this->SelectEntity('breeds');
        }
        public function __destruct(){
            mysql_close($this->connection);
        }

        public function AddBreed($name){
            return $this->AddEntity('breeds',$name);
        }

        public function AddColor($name)
        {
            return $this->AddEntity('colors',$name);
        }

        public function AddFood($name)
        {
            return $this->AddEntity('food',$name);
        }

        private function AddEntity($entity,$name){
            $query = 'INSERT INTO `'.$entity.'` ( `name` ) values("'.$name.'")';
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
            return $this->DeleteEntitiesForKitty('kitties_colors',$id);
        }
        public function DeleteFoodForKitty($id)
        {
            return $this->DeleteEntitiesForKitty('kitties_food',$id);
        }

        private function DeleteEntitiesForKitty($entity,$kitty_id){
            $query = 'DELETE FROM `'.$entity.'` WHERE `kitty_id` = '.$kitty_id;
            return mysql_query($query);
        }


        private function BuildQueryToSearchKitty($order=null,$name=null, $startDate=null, $endDate=null, $breed=null){
            $query = " SELECT k.id,
                             k.name,
                             k.birth_date,
                             k.sex,
                             k.toilet_trained,
                             b.name as breed,
                             p.name as human_name,
                             p.document_number as human_id
                             FROM `kitties` AS k
                             INNER JOIN `breeds` AS b ON
                             b.id = k.breed_id
                             LEFT join `people` as p ON
                             p.document_number = k.human_id
                             ";
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
            return $query;
        }

        public function SelectFoodForKitty($id)
        {
            $query = 'SELECT f.name FROM `kitties` as k
                        join `kitties_food` as kf
                        on k.id = kf.kitty_id
                        join `food` as f
                        on f.id = kf.food_id
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

        public function SelectFood()
        {
            return $this->SelectEntity('food');
        }

        public function AddKittyFood($id, $food)
        {
            $query = 'INSERT INTO `kitties_food` (`kitty_id`, `food_id`) SELECT '.$id.', '.$food.'
            FROM dual WHERE not exists (SELECT * FROM `kitties_food` WHERE `kitty_id` = '.$id.' AND `food_id` = '.$food.' )';
            return mysql_query($query);
        }

        public function AddHuman($doc,$name,$sur, $address)
        {
            $query = "INSERT INTO `people` (`document_number`,`name`, `surname`,`address`) VALUES ('".$doc."','".$name."','".$sur."','".$address."')";
            return mysql_query($query);
        }
        private function SelectEntity($entity){
            $query = 'SELECT id,name from `'.$entity.'`';
            $result = mysql_query($query);
            if(!$result){
                die(mysql_error());
            }
            $arr = array();
            while($row = mysql_fetch_array($result)){
                array_push($arr,$row);
            }
            mysql_free_result($result);
            return $arr;
        }

        public function SelectPeople()
        {
            $query = 'SELECT document_number,name,surname from `people`';
            $result = mysql_query($query);
            if(!$result){
                die(mysql_error());
            }
            $arr = array();
            while($row = mysql_fetch_array($result)){
                array_push($arr,$row);
            }
            mysql_free_result($result);
            return $arr;
        }

        public function AdoptKitty($id, $human_id)
        {
            if($human_id == null){
                $query = "UPDATE `kitties` set `human_id` = null where `id`=".$id;
            }else{
                $query = "UPDATE `kitties` set `human_id` = '".$human_id."' where `id`=".$id;
            }
            return mysql_query($query);
        }
        private function DeleteEntity($entity,$id){
            $query = "DELETE from `$entity` where `id`=$id";
            return mysql_query($query);
        }

        public function DeleteColor($id)
        {
            return $this->DeleteEntity('colors',$id);
        }
        public function DeleteBreed($id)
        {
            return $this->DeleteEntity('breeds',$id);
        }
        public function DeleteFood($id)
        {
            return $this->DeleteEntity('food',$id);
        }
        public function DeleteHuman($id){
            $query = "DELETE from `people` where `document_number`='$id'";
            return mysql_query($query);
        }
    }
?>