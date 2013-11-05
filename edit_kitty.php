<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel='stylesheet' href='style.css' type='text/css'/>

</head>
<body>
<h1>Edit Kitty</h1>
<?php
error_reporting(-1);
require_once 'kitties_handler.php';
if(isset($_GET['id'])){
    $handler = new KittiesHandler();
    $kitty = $handler->GetKitty($_GET['id']);
    ?>
<div class='edit-kitty'>
    <form action='kitties_handler.php' method='POST'>
        <input type='hidden' name='kittyId' value="<?php echo($kitty['id']); ?>"/>
        <table>
            <tbody>
            <tr>
                <td><label>Name</label></td>
                <td><input type='text' name='kittyName' value='<?php echo($kitty['name']); ?>'/></td>
            </tr>
            <tr>
                <td><label>Birth Date</label></td>
                <td><input type='text' name='birthDate' value='<?php echo($kitty['birth_date']); ?>'/></td>
            </tr>
            <tr>
                <td><label></label>Sex</label></td>
                <td>
                    <input type='radio' name='sex' value='1' <?php echo($kitty['sex'] ==1 ? " checked='checked'": "" ); ?> >Male</input>
                    <input type='radio' name='sex' value='0' <?php echo($kitty['sex'] ==0 ? " checked='checked'": "" ); ?> >Female</input>
                </td>
            </tr>
            <tr>
                <td><label>Breed</label></td>
                <td><select type='select' name='breed' class='breed'>
                    <?php
                    $breeds = $handler->GetBreeds();
                    //var_dump($breeds);
                    foreach ($breeds as $el) {
                        if($el['id'] == $kitty['breed_id']){
                            echo '<option selected="selected" value="' . $el['id'] . '">' . $el['name'] . '</option>';
                        }else{
                        echo '<option value="' . $el['id'] . '">' . $el['name'] . '</option>';
                        }
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
                        if(in_array ($el['id'],$kitty['color_id'])){
                            echo '<label><input type="checkbox" checked="checked" name="color[]" value=" '. $el['id'] . '" />'. $el['name'].'</label>';
                        }else{
                            echo '<label><input type="checkbox" name="color[]" value=" '. $el['id'] . '" />'. $el['name'].'</label>';
                        }

                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><label>Toilet Trained</label></td>
                <td><input type='checkbox' name='toilet' <?php echo($kitty['toilet_trained'] ==1 ? " checked='checked'": "" ); ?> /></td>
            </tr>
            <tr>
                <td></td>
                <td><input type='submit' name='updateKitty' value='Update kitty'/></td>
            </tr>
            <tr>
            </tbody>
        </table>
    </form>
</div>
<div><a href="index.php">Back </a> </div>

</body>
</html>
<?php
}else{
    header("Location: index.php");
}


$handler->__destruct();
?>
