<?php

var_dump('$id');

$id = $_GET['id'];
echo $id ;
  $fp = fopen('data.csv', 'a+b');
  $data = 'data.csv';
 // --------------------------------------------------

  // -------------------------------------------------
          if(file_exists($data)) {
            $id = file($data);
          }
  while ($row = fgetcsv($fp)) { 
    $rows[] = $row;
    }

  fclose($fp);
  
  


  if( !empty($_POST['comment_btn'])) {
    
    // コメントが未入力時のチェック ------------------
    if( empty($_POST['comment'])) {
      $error_text[] =  'コメントは必須です。<br>';
    }

    // コメントが文字数50を超えた時のチェック --------
    if ( strlen($_POST['comment']) >= 50) {
      $error_text[] =  'タイトルは50文字以下です。<br>';
    } 

    // コメント ---------------------------------------
    if (empty($error_text)) {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $cmt = fopen('comment.csv', 'a+b');
        $comment = $_POST['comment'];

        fputcsv($cmt, [$comment]);
        rewind($cmt);
      } 
      header('Location:http://localhost/laravelnews/message.php');
      fclose($cmt);
    }
  }
    
  $cmt = fopen('comment.csv', 'a+b');
    while ($row_cmt = fgetcsv($cmt)) {
      $rows_cmt[] = $row_cmt;
    }
  fclose($cmt);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>laravelnews</title>
  <link rel="stylesheet" href=" ./style.css">
</head>
<body>
  <header>
    <p>Laravel News</p>
  </header>

    <!-- 投稿内容表示 -->
    <?php foreach ($rows as $row): ?>
      <h3><?=$row[1]?></h3>
      <p><?=$row[2]?></p>
    <?php endforeach; ?>
  <hr>

  <!-- エラーメッセージ -->
  <?php if(!empty($error_text)): ?> 
    <ul>
      <?php foreach( $error_text as $value): ?>
        <li><?php echo $value; ?></li>
      <?php endforeach; ?>
    <ul>
  <?php endif; ?>

  <div class="content">
    <!-- コメント入力 -->
    <div class="comment_box">
      <form action="" method="POST">
        <div>
          <textarea class="comment" type="text" name="comment" value=""></textarea>
        </div>
        <div>
          <input type="submit" class="comment_btn" name="comment_btn" value="コメントを書く">
        </div>
      </form>
  </div>

  <!-- コメント出力 -->
  <?php if (!empty($rows_cmt)): ?>
    <?php foreach ($rows_cmt as $row_cmt): ?>
      <div class="comment1_box">
        <p><?=$row_cmt[0]?></p><br>
        <input type="button" class="delete_btn" name="delete_btn" value="コメントを削除">  
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
  </div>

  <div>
    <hr>
    <a href="index.php">元のページに戻る</a>
  </div>
</body>
</html>