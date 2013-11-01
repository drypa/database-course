<!DOCTYPE html>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
 <link rel='stylesheet' href='style.css' type='text/css' />
</head>
<body>
<h1>Hello Kitty</h1>
<?php
error_reporting(1);
require_once 'kitties_dalc.php';

$dalc = new KittiesDalc();

$result = $dalc->SelectKitties();
if(count($result)<=0){
?>
<div>No kitties found</div>
<?php
}else{
?>
<table>
<thead>
<tr>
    <th>Id</th>
    <th>Name</th>
    <th>Birth date</th>
    <th>Breed</th>
</tr>
</thead>
<tbody>
<?php
foreach ($result as $row){
	 echo '<tr><td>'
	     .$row['id']
	     .'</td><td>'
	     .$row['name']
	     .'</td><td>'
	     .$row['birth_date']
	     .'</td><td>'
	     .$row['breed']
	     .'</td></tr>';
}
?>
</tbody>
</table>

<div>
    <div>Add Kitty</div>
    <form action='kitties_handler.php' method='POST'>
        <table>
            <tbody>
                <tr>
                <td><label for='kittyName'>Name</label></td>
                <td><input type='text' name='kittyName' /></td>
                </tr>
                <tr>
                <td><label for='birthDate'>Birth Date</label></td>
                <td><input type='text' name='birthDate' /></td>
                </tr>
                <tr>
                <td><label for='sex'>Sex</label></td>
                <td><input type='radio' name='sex' value='male'>Male</input> <input type='radio' name='sex' value='female' >Female</input></td>
                </tr>
                <td><label for='toilet'>Toilet Trained</label></td>
                <td><input type='checkbox' name='toilet'></input> </td>
                </tr>
                <tr>
                <td></td>
                <td><input type='submit' name='addKitty' value='Add kitty'></input> </td>
                </tr>
                <tr>
            </tbody>
        </table>
    </form>
</div>
<?php
}
$dalc->__destruct();
?>
</body>
</html>