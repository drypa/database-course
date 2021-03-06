<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel='stylesheet' href='style.css' type='text/css'/>
</head>
<script type="text/javascript" >
    <?php
    if(isset($_GET['res'])){
        if($_GET['res']>0){
            echo("alert('успешно');");

        }else{
            echo("alert('не удалось');");
        }
        $_GET['res'] = '';
        echo("window.location.search = ''");
    }
    ?>
</script>

<body>
<h1>Hello Kitty</h1>
<ul>
    <li><a href='search_kitty.php'>Search</a></li>
    <li><a href='colors.php'>Colors</a></li>
    <li><a href='breeds.php'>Breeds</a></li>
    <li><a href='people.php'>People</a></li>
    <li><a href='food.php'>Food</a></li>
</ul>
<?php
error_reporting(-1);
require_once 'kitties_handler.php';

$handler = new KittiesHandler();

$result = $handler->GetKitties();

if (count($result) <= 0) {
    ?>
<div>No kitties found</div>
    <?php
} else {
    ?>
<table class='kitties-list'>
    <thead>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Birth date</th>
        <th>Breed</th>
        <th>Sex</th>
        <th>Toilet trained</th>
        <th>Colors</th>
        <th>Food</th>
        <th>Adopt</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
        <?php
        $people = $handler->GetPeople();
            function GetPeopleOptions($people,$human_id){
                $res='<option value="0" >-</option>';
                foreach($people as $human){
                    if($human_id && $human['document_number']== $human_id){
                        $res.='<option  selected value="'.$human['document_number'].'">'.$human['name'].' '.$human['surname'].'</option>';
                    }else{
                        $res.='<option value="'.$human['document_number'].'">'.$human['name'].' '.$human['surname'].'</option>';
                    }

                }
                return $res;
            }

        foreach ($result as $row) {
            echo '<tr><td>'
                . $row['id']
                . '</td><td>'
                . $row['name']
                . '</td><td>'
                . $row['birth_date']
                . '</td><td>'
                . $row['breed']
                . '</td><td>'
                . ($row['sex'] == '1' ? 'Male' : 'Female')
                . '</td><td>'
                . ($row['toilet_trained'] == '1' ? 'Trained' : 'Not trained =(')
                . '</td><td>'
                . $row['colors']
                . '</td><td>'
                . $row['food']
                . '</td><td>'
                . '<form method="POST" action=kitties_handler.php><input type="hidden" name="kittyId" value="' . $row['id']
                . '"/><select name="person">'.GetPeopleOptions($people,$row['human_id']).'</select><input type="submit" name="adoptKitty" value="Adopt" /></form>'
                . '</td><td>'
                . '<form method="POST" action=kitties_handler.php><input type="hidden" name="kittyId" value="' . $row['id'] .
                '" /><input type="submit" name="delKitty" value="Delete" />
                    </form> <a href="edit_kitty.php?id='.$row['id'].'">Edit</a>'
                . '</td></tr>';
        }
        ?>
    </tbody>
</table>
    <?php
}
?>
<div class='add-kitty'>
    <div class='title'>Add Kitty</div>
    <form action='kitties_handler.php' method='POST'>
        <table>
            <tbody>
            <tr>
                <td><label>Name</label></td>
                <td><input type='text' name='kittyName'/></td>
            </tr>
            <tr>
                <td><label>Birth Date</label></td>
                <td><input type='text' name='birthDate'/></td>
            </tr>
            <tr>
                <td><label></label>Sex</label></td>
                <td>
                    <input type='radio' name='sex' value='1'>Male</input>
                    <input type='radio' name='sex' value='0'>Female</input>
                </td>
            </tr>
            <tr>
                <td><label>Breed</label></td>
                <td><select type='select' name='breed'>
                    <?php
                    $breeds = $handler->GetBreeds();
                    var_dump($breeds);
                    foreach ($breeds as $el) {
                        echo '<option value="' . $el['id'] . '">' . $el['name'] . '</option>';
                    }
                    ?>
                </select></td>
            </tr>
            <tr>
                <td><label>Colors</label></td>
                <td>
                    <?php
                        $colors = $handler->GetColors();
                        foreach ($colors as $el) {
                            echo '<label><input type="checkbox" name="color[]" value=" '. $el['id'] . '" />'. $el['name'].'</label>';
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td><label>Food</label></td>
                <td>
                    <?php
                    $colors = $handler->GetFood();
                    foreach ($colors as $el) {
                        echo '<label><input type="checkbox" name="food[]" value=" '. $el['id'] . '" />'. $el['name'].'</label>';
                    }
                    ?>
                </td>
            </tr>
            <tr>
            <td><label>Toilet Trained</label></td>
            <td><input type='checkbox' name='toilet'/></td>
            </tr>
            <tr>
                <td></td>
                <td><input type='submit' name='addKitty' value='Add kitty'/></td>
            </tr>
            <tr>
            </tbody>
        </table>
    </form>
</div>
<span class='add-widget'>
    <div>Add Breed</div>
    <form action='kitties_handler.php' method='POST'>
        <table>
            <tbody>
            <tr>
                <td><label>Breed name</label></td>
                <td><input type='text' name='breedName'/></td>
            </tr>
            <tr>
                <td></td>
                <td><input type='submit' name='addBreed' value='Add breed'/></td>
            </tr>
            </tbody>
        </table>
    </form>
</span>
<span class='add-widget'>
    <div>Add Color</div>
    <form action='kitties_handler.php' method='POST'>
        <table>
            <tbody>
            <tr>
                <td><label>Color</label></td>
                <td><input type='text' name='colorName'/></td>
            </tr>
            <tr>
                <td></td>
                <td><input type='submit' name='addColor' value='Add color'/></td>
            </tr>
            </tbody>
        </table>
    </form>
</span>
<span class='add-widget'>
    <div>Add Food</div>
    <form action='kitties_handler.php' method='POST'>
        <table>
            <tbody>
            <tr>
                <td><label>Food</label></td>
                <td><input type='text' name='foodName'/></td>
            </tr>
            <tr>
                <td></td>
                <td><input type='submit' name='addFood' value='Add food'/></td>
            </tr>
            </tbody>
        </table>
    </form>
</span>
<span class='add-widget'>
    <div>Add Human</div>
    <form action='kitties_handler.php' method='POST'>
        <table>
            <tbody>
            <tr>
                <td><label>Document number</label></td>
                <td><input type='text' name='humanDocument'/></td>
            </tr>
            <tr>
                <td><label>Name</label></td>
                <td><input type='text' name='humanName'/></td>
            </tr>
            <tr>
                <td><label>Surname</label></td>
                <td><input type='text' name='humanSurName'/></td>
            </tr>
            <tr>
                <td><label>Address</label></td>
                <td><input type='text' name='humanAddress'/></td>
            </tr>
            <tr>
                <td></td>
                <td><input type='submit' name='addHuman' value='Add human'/></td>
            </tr>
            </tbody>
        </table>
    </form>
</span>
</body>
</html>
<?php
$handler->__destruct();
?>