<?php
require_once 'mysql.php';

$link = $_POST['url'];
    @$select = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM shorturl WHERE url = '$link'"));
    if($select){
        $result = [
            'url'  => $select['url'],
            'key'  => $select['url_key'],
            'link' => 'http://'.$_SERVER['HTTP_HOST'].'/-'.$select['url_key']
        ];
        $domain = 'http://'.$_SERVER['HTTP_HOST'];
        $result_json = json_encode(array(
            'url' => $result['url'], 'key' => $result['key'], 'domain' => $domain
        ));

        echo $result_json;

    }