<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel='stylesheet' href='style.css' type='text/css'/>
</head>
<body>
<h1>Люди:</h1>
<ul>
    <li><a href='index.php'>Назад</a></li>
</ul>

<?php
error_reporting(-1);
require_once 'kitties_handler.php';
//    document_number,name,surname
$handler = new KittiesHandler();
$people = $handler->GetPeople();
foreach ($people as $el) {
    $name =$el['name'];
    $surname =$el['surname'];
    $document =$el['document_number'];
    echo("<form action='kitties_handler.php' method='post'><input type='hidden' name='id' value='$document'>");
    echo("<div>$name $surname(документ №$document)</div>");
    echo("<input type='submit' name='delHuman' value='Удалить'></form>");
}
?>

</body>
</html>