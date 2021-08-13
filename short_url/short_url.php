<?php
require_once('mysql.php');

$link = htmlspecialchars($_POST['url']);
if(empty($_POST['submit'])){}
if(empty($_POST['url'])){}
else{
    @$select = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM shorturl WHERE url = '$link'"));
    if($select){
        $result = [
            'url'  => $select['url'],
            'key'  => $select['url_key'],
            'link' => 'http://'.$_SERVER['HTTP_HOST'].'/-'.$select['url_key']
        ];
    }
    else{
        /* Генерация уникального url_key*/
        $letters='qwertyuiopasdfghjklzxcvbnm1234567890';
        $count=strlen($letters);
        $intval=time();
        $result='';
        for($i=0;$i<4;$i++) {
            $last=$intval%$count;
            $intval=($intval-$last)/$count;
            $result.=$letters[$last];
        }

        mysqli_query($db,"INSERT INTO shorturl (url, url_key) VALUES ('$link', '$result') ");
        @$select = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM shorturl WHERE url = '$link'"));
        $result = [
            'url'  => $select['url'],
            'key'  => $select['url_key'],
            'link' => 'http://'.$_SERVER['HTTP_HOST'].'/-'.$select['url_key']
        ];

    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo 'Сократитель ссылок'; ?></title>
    <meta name = "vieport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/templates/css/bootstrap.min.css">
    <link rel="stylesheet" href="/templates/css/font-awesome.min.css">
    <link rel="stylesheet" href="/templates/css/style.css">
</head>

<body style="height: 100%; width: 100%; position: fixed;">
<script src="/templates/js/jquery.min.js"></script>
<script src="/templates/js/bootstrap.js"></script>

<nav class="navbar navbar-light bg-light">
    <a class="navbar-brand">Сократитель ссылок</a>
</nav>
<br>
<center>
    <div class="mess"></div>
    <br>
    <div class="container-left shadow p-3 mb-5 bg-light rounded">

        <form  class="mv-form" method="post">
            <center>
                Для сокращения ссылки введите ваш url в поле ниже и нажмите сократить. Дальше ссылка вам будет доступна в укороченном варианте.
            </center>
            <p class="font-weight-bold">Ссылка:</p><input id="url" class="form-control" name="url" placeholder="Введите URL для сокращения">
            <br>
            <center>
                <button type="submit" class="btn btn-outline-info">Сократить</button>
            </center>
        </form>

    </div>

    <script src="/templates/js/jquery.min.js"></script>
    <script src="/templates/js/bootstrap.js"></script>

    <script type="text/javascript">
        $('.mv-form').submit(function(e){
            e.preventDefault();
            let th = $(this);
            let mess = $('.mess');
            let btn = th.find('.btn');
            btn.addClass('progress-bar-striped progress-bar-animated');
            $.ajax({
                url: '',
                type: 'POST',
                data: th.serialize(),
                success: function() {
                    btn.removeClass('progress-bar-striped progress-bar-animated');
                   // btn.text('Получить');
                }
            });
            setTimeout( function(){
            let url = $('#url').val();
            $.ajax({
                url: 'short_url/json.php',
                type: 'POST',
                data: {url:url},
                success: function(url) {
                    url = JSON.parse(url);
                    mess.html('<div class="alert-success"> URL успешно сокращен: '+url['domain']+'/-'+url['key']+'</div>')
            }
            })}, 500);

        });
    </script>
