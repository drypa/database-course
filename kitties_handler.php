<?php
    require_once 'kitties_dalc.php';
    class KittiesHandler{
        private $dalc;
        public function KittiesHandler(){
            $this->dalc = new KittiesDalc();
        }
        public function GetKitties(){
            return $this->dalc->SelectKitties();
        }
        public function AddKitty($name,$birthDate,$sex,$breedId,$toiletTrained){
            $this->dalc->AddKitty($name,$birthDate,$sex,$breedId,$toiletTrained);
        }

        public function AddBreed($name){
            $this->dalc->AddBreed($name);
        }
        public function GetBreeds(){
            return $this->dalc->SelectBreeds();
        }

        public function __destruct(){
           $this->dalc->__destruct();
        }
    }

 if (isset($_POST['addKitty'])){
        die('kitties add is not implemented');
 }
 if (isset($_POST['addBreed'])){
    die('breed add is not implemented');
 }
?>