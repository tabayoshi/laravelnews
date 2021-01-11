
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="device-width, initial-scale=1.0">
  <title>Laravel News</title>
</head>
<body>
  <h1>Laravel News</h1>
  <p>さあ、最新のニュースをシェアしよう</p>
  <form method="POST" action="<?php echo($_SERVER['PHP_SELF'])?>">

  <?php

// 変数設定
  $title = $_POST['title'];
  $article = $_POST['article'];

  // 初期値設定
  $title_alert = 'null';
  $article_alert = 'null';

// タイトルと記事が入力されていない場合
  if ($title == '') {
    echo '・タイトルは必須です。<br>';
  } else {
    echo '';
  }

  if ($title <= 30) {
    echo '・タイトルは30文字以下です。<br>';
  } else {
    echo '';
  }

  if ($article == '') {
    echo '・記事は必須です。<br>';
  } else {
    echo '';
  }
    
  ?>

<!-- 入力フォーム -->
  <br>
    タイトル:
    <input type="text" name="title"><br>
    記事:
    <input type="textarea" name="article" cols="50" rows="10"><br>
    <input type="submit" action="" value="投稿">
  </form>
  <hr>

  <?php

//入力された記事を投稿するアラート
// $test_alert = "<script type='text/javascript'>alert('テストです。')</script>";
// echo $test_alert;

// 入力された記事を表示する
echo('<h2>' . $title . '</h2>');
echo('<p>' . $article . '</p>');
if ($title !== '' && $article !== '') {
  echo('<a href="#">記事全文・コメントを見る</a>');
  echo('<hr>');
}


//１ページの記事の表示数
define('MAX', '10');

// ページング
echo('<a herf="#"></a>');
  ?>
</body>
</html>