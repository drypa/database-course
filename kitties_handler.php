<?php
require_once 'kitties_dalc.php';
class KittiesHandler
{
    private $dalc;

    public function KittiesHandler()
    {
        $this->dalc = new KittiesDalc();
    }

    public function GetKitties()
    {
        $kitties = $this->dalc->SelectKitties();
        for ($i = 0; $i < count($kitties); $i++) {
            $colors = $this->dalc->SelectColorsForKitty($kitties[$i]['id']);
            $colorsString = join(',', $colors);
            $kitties[$i]['colors'] = $colorsString;
        }
        return $kitties;
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
}

if (isset($_POST['addKitty'])) {
    $handler = new KittiesHandler();
    $name = $_POST['kittyName'];
    $birthDate = $_POST['birthDate'];
    $sex = $_POST['sex'];
    $toilet = $_POST['toilet'] == 'on' ? 1 : 0;
    $breed = $_POST['breed'];
    $id = $handler->AddKitty($name, $birthDate, (int)$sex, (int)$breed, (int)$toilet);
    $i = 1;
    while ($_POST['color' . $i]) {
        $handler->AddKittyColor($id, $_POST['color' . $i]);
        ++$i;
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
?>