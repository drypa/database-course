<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel='stylesheet' href='style.css' type='text/css'/>
</head>
<body>
<h1>Список цветов:</h1>
<ul>
    <li><a href='index.php'>Назад</a></li>
</ul>

<?php
error_reporting(-1);
require_once 'kitties_handler.php';

$handler = new KittiesHandler();
    $colors = $handler->GetColors();
    foreach ($colors as $el) {
        $name =$el['name'];
        $id =$el['id'];
        echo("<form action='kitties_handler.php' method='post'><input type='hidden' name='id' value='$id'>");
        echo("<div>$name</div>");
        echo("<input type='submit' name='delColor' value='Удалить'></form>");
    }
?>

</body>
</html>