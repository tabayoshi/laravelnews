<?php
//データベースへの接続 ---------------------------------

  $user = 'root';
  $password = 'root';
  $dbname = 'laravel_news';
  $host = 'localhost';
  $port = 3306;

  $link = mysqli_init();

  $mysqli = mysqli_real_connect(
    $link,
    $host,
    $user,
    $password,
    $dbname,
    $port
  );

  // echo '<テスト用>';
  // echo '<br>';

  // var_dump($mysqli);
  // echo "<br><br>";
?>