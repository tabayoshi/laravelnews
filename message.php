<?php
$id = $_GET['id'];
// echo $id ;

// index.phpで選んだ投稿を表示する---------------------
  $fp = fopen('data.csv', 'a+b');
    while ($row = fgetcsv($fp)) {
      if($row[0] === $id) {
        $rows[] = $row;
      }
    }
  fclose($fp);
// --------------------------------------------------
  if( !empty($_POST['comment_btn'])) {
    
    // コメントが未入力時のチェック ------------------
    if( empty($_POST['comment'])) {
      $error_text[] =  'コメントは必須です。<br>';
    }

    // コメントが文字数50を超えた時のチェック --------
    if ( strlen($_POST['comment']) >= 50) {
      $error_text[] =  'タイトルは50文字以下です。<br>';
    } 

    // コメント番号 -----------------------------------
    $data_comment = 'comment.csv';
          if(file_exists($data_comment)) {
            $id_comment = count(file($data_comment)) + 1;
          }

    // コメント入力 ------------------------------------
    if (empty($error_text)) {
      
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $comment_file = fopen('comment.csv', 'a+b');
        $comment = $_POST['comment'];
        
        fputcsv($comment_file, [$id_comment, $comment]);
        rewind($comment_file);
      } 
      header('Location:http://localhost/laravelnews/message.php?id=' . $id);
      fclose($comment_file);
    }
  }
  
  // コメント出力 ------------------------------------
  $comment_file = fopen('comment.csv', 'a+b');
  while ($row_comment = fgetcsv($comment_file)) {
    $rows_comment[] = $row_comment;
  }
  fclose($comment_file);

  // コメント削除 ------------------------------------
  $file = file('test.txt');
  unset($file[1]);
  file_put_contents('test.txt', $file);
  // -------------------------------------------------






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
          <textarea class="comment" name="comment" value=""></textarea>
        </div>
        <div>
          <input type="submit" class="comment_btn" name="comment_btn" value="コメントを書く">
        </div>
      </form>
  </div>

  <!-- コメント出力 -->
  <?php if (!empty($rows_comment)): ?>
    <?php foreach ($rows_comment as $row_comment): ?>
      <div class="comment1_box">
        <p><?=$row_comment[0]?><?=$row_comment[1]?></p><br>
        <input type="button" class="delete_btn" name="delete_btn" value="コメントを削除"> 
        <!-- <a href="?action=delete&id=<?php echo $value['id_cmt']; ?>">コメントを削除</a>  -->
        <a href="">コメントを削除</a> 
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