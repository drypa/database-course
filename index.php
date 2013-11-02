<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel='stylesheet' href='style.css' type='text/css'/>
</head>
<body>
<h1>Hello Kitty</h1>
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
<table>
    <thead>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Birth date</th>
        <th>Breed</th>
        <th>Sex</th>
        <th>Toilet trained</th>
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
                . '<form method="POST" action=kitties_handler.php><input type="hidden" name="kittyId" value="' . $row['id'] .
                '" /><input type="submit" name="delKitty" value="To adopt" /></form>'
                . '</td></tr>';
        }
        ?>
    </tbody>
</table>
    <?php
}
?>
<div>
    <div>Add Kitty</div>
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
                <td><input type='radio' name='sex' value='1'>Male</input>
                    <input type='radio' name='sex' value='0'>Female</input></td>
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
</body>
</html>
<?php
$handler->__destruct();
?>