<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel='stylesheet' href='style.css' type='text/css'/>
</head>
<body>
<h1>Hello Kitty</h1>
<ul>
    <li><a href='index.php'>Back to main page</a></li>
</ul>
<?php
error_reporting(-1);
require_once 'kitties_handler.php';
$handler = new KittiesHandler();
?>
<form action='search_kitty.php' method="POST">
    <label>Name:
        <input type='text' name='name'/>
    </label>
    <label>Birth date after:
        <input type='text' name='dateStart'/>
    </label>
    <label>Birth date before:
        <input type='text' name='dateEnd'/>
    </label>
    <label>Breed:
        <select name='breed'>
            <option value="0">Undefined</option>
            <?php
            $breeds = $handler->GetBreeds();
            foreach ($breeds as $el) {
                echo '<option value="' . $el['id'] . '">' . $el['name'] . '</option>';
            }
            ?>
        </select>
    </label>

    <div class='order-settings'>Order by:
        <label>Id
            <input type='radio' name='order' value='k.id' checked="checked"/>
        </label>
        <label>Name
            <input type='radio' name='order' value='k.name'/>
        </label>
        <label>BirthDate
            <input type='radio' name='order' value='k.birth_date'/>
        </label>
        <label>Breed
            <input type='radio' name='order' value='breed'/>
        </label>
    </div>
    <input type='submit' value="Search" name="searchKitty"/>
</form>

<div class='search-results'>
    <?php
    if (isset($_POST['searchKitty'])) {
        $name = $_POST['name'];
        $start = $_POST['dateStart'];
        $end = $_POST['dateEnd'];
        $breed = $_POST['breed'];
        $order = $_POST['order'];
        $result = $handler->GetKitties($order, $name, $start, $end, $breed);
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
                        . ($row['toilet_trained'] == '1' ? 'Trained' : 'Not trained')
                        . '</td><td>'
                        . $row['colors']
                        . '</td></tr>';
                }
                ?>
            </tbody>
        </table>
        <?php
    }
    ?>
</div>

</body>
</html>
<?php
$handler->__destruct();
?>