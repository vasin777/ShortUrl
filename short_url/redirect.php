<?php
require_once('mysql.php');
//Редирект с короткой ссылки на оригинальную ссылку
$key = htmlspecialchars($_GET['key']);  //Преобразование встречающихся специальных символов в HTML сущности
if(empty($_GET['key'])){} //проверка
else{
    @$select = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM shorturl WHERE url_key = '$key'"));
    if($select){
        $result = [
            'url' => $select['url'],
            'key' => $select['url_key']
        ];
   //переходим по оригинальной ссылке
        header('location: '.$result['url']);
       
    }
}
