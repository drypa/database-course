<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel='stylesheet' href='style.css' type='text/css'/>
</head>
<body>
<h1>Hello Kitty</h1>
<ul>
    <li><a href='search_kitty.php'>Search</a></li>
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
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
        <?php
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
                . '<form method="POST" action=kitties_handler.php><input type="hidden" name="kittyId" value="' . $row['id'] .
                '" /><input type="submit" name="delKitty" value="To adopt" /></form> <a href="edit_kitty.php?id='.$row['id'].'">Edit</a>'
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
<div>
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
</div>
<div>
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
</div>
</body>
</html>
<?php
$handler->__destruct();
?>