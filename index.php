<!DOCTYPE html>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<h1>Hello Kitty</h1>
<?php
error_reporting(1);
$link = mysql_connect('localhost:3306','root','123456');
if(!$link){
	die ('MySql connection problem' .mysql_error(). '<br />');
}
mysql_set_charset('utf8');
mysql_select_db('kitties',$link);
$result = mysql_query('call select_kitties_with_breed()');
if(!$result){
	die(mysql_error());
}
echo '<table><thead><tr><th>Id</th><th>Name</th><th>Birth date</th><th>Breed</th></tr></thead><tbody>';
while($row = mysql_fetch_array($result)){
	 echo '<tr><td>'.$row['id'].'</td><td>'.$row['name'].'</td><td>'.$row['birth_date'].'</td><td>'.$row['breed'].'</td></tr>';
}
echo '</tbody></table>';



mysql_close($link);
?>
</body>
</html>