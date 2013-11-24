<?php
require_once 'kitties_dalc.php';
class KittiesHandler
{
    private $dalc;

    public function KittiesHandler()
    {
        $this->dalc = new KittiesDalc();
    }

    public function GetKitties($order=null,$name=null, $startDate=null, $endDate=null, $breed=null)
    {
        $kitties = $this->dalc->SelectKitties($order,$name, $startDate, $endDate, $breed);
        for ($i = 0; $i < count($kitties); $i++) {
            $colors = $this->dalc->SelectColorsForKitty($kitties[$i]['id']);
            $colorsString = join(',', $colors);
            $kitties[$i]['colors'] = $colorsString;

            $food = $this->dalc->SelectFoodForKitty($kitties[$i]['id']);
            $foodString = join(',', $food);
            $kitties[$i]['food'] = $foodString;
        }
        return $kitties;
    }
    public function GetKitty($id){
       $kitty = $this->dalc->SelectKitty($id);
       $colors = $this->dalc->SelectColorsIdForKitty($id);
       $kitty['color_id'] = $colors;
       return $kitty;
    }

    public function AddKitty($name, $birthDate, $sex, $breedId, $toiletTrained)
    {
        return $this->dalc->AddKitty($name, $birthDate, $sex, $breedId, $toiletTrained);
    }

    public function AddBreed($name)
    {
        return $this->dalc->AddBreed($name);
    }

    public function AddColor($name)
    {
        return $this->dalc->AddColor($name);
    }

    public function GetBreeds()
    {
        return $this->dalc->SelectBreeds();
    }

    public function GetColors()
    {
        return $this->dalc->SelectColors();
    }

    public function DeleteKitty($id)
    {
        $this->dalc->DeleteKitty($id);
    }

    public function GetKittyColors($id)
    {
        return $this->dalc->SelectColorsForKitty($id);
    }

    public function __destruct()
    {
        $this->dalc->__destruct();
    }

    public function AddKittyColor($id, $color)
    {
        return $this->dalc->AddKittyColor($id, $color);
    }

    public function UpdateKitty($id, $name, $birthDate, $sex, $breed, $toilet)
    {
        return $this->dalc->UpdateKitty($id, $name, $birthDate, $sex, $breed, $toilet);
    }
    public function DeleteColorsForKitty($id)
    {
        return $this->dalc->DeleteColorsForKitty($id);
    }

    public function AddFood($name)
    {
        return $this->dalc->AddFood($name);
    }

    public function GetFood()
    {
        return $this->dalc->SelectFood();
    }

    public function AddKittyFood($id, $food)
    {
        return $this->dalc->AddKittyFood($id, $food);
    }

    public function AddHuman($doc,$name,$sur, $address)
    {
        return $this->dalc->AddHuman($doc,$name, $sur,$address);
    }

    public function GetPeople()
    {
        return $this->dalc->SelectPeople();
    }

    public function AdoptKitty($id, $human_id)
    {
        return $this->dalc->AdoptKitty($id, $human_id);
    }

    public function DeleteFoodForKitty($id)
    {
        return $this->dalc->DeleteFoodForKitty($id);
    }

    public function DeleteColor($id)
    {
        return $this->dalc->DeleteColor($id);
    }
}

if (isset($_POST['addKitty'])) {
    $handler = new KittiesHandler();
    $name = $_POST['kittyName'];
    $birthDate = $_POST['birthDate'];
    $sex = $_POST['sex'];
    $toilet = $_POST['toilet'] == 'on' ? 1 : 0;
    $breed = $_POST['breed'];
    $id = $handler->AddKitty($name, $birthDate, (int)$sex, (int)$breed, (int)$toilet);
    foreach ($_POST['color'] as $key => $value) {
        $handler->AddKittyColor($id, $value);

    }
    foreach ($_POST['food'] as $key => $value) {
        $handler->AddKittyFood($id, $value);

    }

    $handler->__destruct();
    header("Location: index.php");

    return;
}
if (isset($_POST['updateKitty'])) {
    $handler = new KittiesHandler();
    $name = $_POST['kittyName'];
    $id = $_POST['kittyId'];
    $birthDate = $_POST['birthDate'];
    $sex = $_POST['sex'];
    $toilet = $_POST['toilet'] == 'on' ? 1 : 0;
    $breed = $_POST['breed'];
    $handler->UpdateKitty($id, $name, $birthDate, (int)$sex, (int)$breed, (int)$toilet);
    $handler->DeleteColorsForKitty($id);
    foreach ($_POST['color'] as $key => $value) {
        $handler->AddKittyColor($id, $value);

    }
    $handler->DeleteFoodForKitty($id);
    foreach ($_POST['food'] as $key => $value) {
        $handler->AddKittyFood($id, $value);

    }

    $handler->__destruct();
    header("Location: index.php");

    return;
}


if (isset($_POST['delKitty'])) {
    $handler = new KittiesHandler();
    $id = $_POST['kittyId'];
    $handler->DeleteKitty($id);
    $handler->__destruct();
    header("Location: index.php");
    return;
}

if (isset($_POST['adoptKitty'])) {
    $handler = new KittiesHandler();
    $id = $_POST['kittyId'];
    $human_id = $_POST['person'];
    if($human_id == 0){
        $handler->AdoptKitty($id,null);
    }else{
        $handler->AdoptKitty($id,$human_id);
    }

    $handler->__destruct();
    header("Location: index.php");
    return;
}


if (isset($_POST['addBreed'])) {
    $name = $_POST['breedName'];
    $handler = new KittiesHandler();
    $handler->AddBreed($name);
    header("Location: index.php");
    return;
}
if (isset($_POST['addColor'])) {
    $name = $_POST['colorName'];
    $handler = new KittiesHandler();
    $handler->AddColor($name);
    header("Location: index.php");
    return;
}
if (isset($_POST['addFood'])) {
    $name = $_POST['foodName'];
    $handler = new KittiesHandler();
    $handler->AddFood($name);
    header("Location: index.php");
    return;
}
if (isset($_POST['addHuman'])) {
    $doc = $_POST['humanDocument'];
    $name = $_POST['humanName'];
    $sur = $_POST['humanSurName'];
    $address = $_POST['humanAddress'];
    $handler = new KittiesHandler();
    $handler->AddHuman($doc,$name,$sur,$address);
    header("Location: index.php");
    return;
}

if (isset($_POST['delColor'])) {
    $handler = new KittiesHandler();
    $id = $_POST['id'];
    $handler->DeleteColor($id);
    $handler->__destruct();
    header("Location: index.php");
    return;
}
?>