<?php
require_once('mysql.php');

$key = htmlspecialchars($_GET['key']);
if(empty($_GET['key'])){}
else{
    @$select = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM shorturl WHERE url_key = '$key'"));
    if($select){
        $result = [
            'url' => $select['url'],
            'key' => $select['url_key']
        ];
        // а теперь собственно сам редирект
        header('location: '.$result['url']);
        // проверяем
    }
}