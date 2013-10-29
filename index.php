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
require_once 'KittiesDalc.php';

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
	 echo '<tr><td>'.$row['id'].'</td><td>'.$row['name'].'</td><td>'.$row['birth_date'].'</td><td>'.$row['breed'].'</td></tr>';
}
?>
</tbody>
</table>
<?php
}

mysql_close($link);
?>
</body>
</html>