<?php
    require_once 'kitties_dalc.php';
    class KittiesHandler{
        private $dalc;
        public function KittiesHandler(){
            $dalc = new KittiesDalc();
        }
        public function GetKitties(){
            return $dalc->SelectKitties();
        }
        public function AddKitty($name,$birthDate,$sex,$breedId,$toiletTrained){
            $dalc->AddKitty($name,$birthDate,$sex,$breedId,$toiletTrained);
        }

        public function AddBreed($name){
            $dalc->AddBreed($name);
        }
        public function SelectBreeds(){
            $dalc->SelectBreeds();
        }

        public function __destruct(){
           $dalc->__destruct();
        }
    }

 if (isset($_POST['addKitty'])){
        die('kitties add is not implemented');
 }
 if (isset($_POST['addBreed'])){
    die('breed add is not implemented');
 }
?>