<?php
    require_once 'kitties_dalc.php';
    class KittiesHandler{
        private $dalc;
        public function KittiesHandler(){
            $dalc = new KittiesDalc();
        }
        public GetKitties(){
            return $dalc->SelectKitties();
        }
        public AddKitty($name,$birthDate,$sex,$breedId,$toiletTrained){
            $dalc->AddKitty($name,$birthDate,$sex,$breedId,$toiletTrained);
        }

        public function AddBreed($name){
            $dalc->AddBreed($name);
        }
        public function SelectBreeds(){
            $dalc->SelectBreeds();
        }

        public __destruct(){
           $dalc->__destruct();
        }
    }
?>