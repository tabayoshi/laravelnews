<?php

  $id = $_GET['id'];
  $article_id = $id;
  // テスト用
  // echo $id ;
  // echo "<br>";

  // 上の表示 -----------------------------------------------
  // 外部からのデータベース接続コード読み込み ---------------
  include 'data_base.php';
  if (mysqli_connect_errno() > 0) {
      die("接続失敗" . mysqli_connect_error());
    } else {
      // テスト用
      // echo "データベース接続成功0";
      // echo "<br>";
    }

  // 文字化け防止 ---------------------------
  mysqli_set_charset($mysqli, 'utf8');

  // index.phpで選んだ投稿を表示す---------------------
  // $link = mysqli_init();
  $result_read = mysqli_query($link, "SELECT id, title, text FROM articles");
  if(!$result_read) {
    die("クエリ失敗" . mysqli_error());
  } else {
  // テスト用
    // echo "クエリ成功";
    // echo "<br>";
  }
  while ($row = mysqli_fetch_assoc($result_read)) {
    if($row['id'] === $id) {
  //   // テスト用
    // echo "id=" . $row['id'] . "<br>";
    // echo "title=" . $row['title'] . "<br>";
    // echo "text=" . $row['text']. "<br>";
      $rows[] = $row;
    }
  }
      
    // データベース切断
    $close = mysqli_close($link);
    if ($close) {
      // echo "切断成功0";
      // echo "<br><br>";
    }
// 上の表示はここまで --------------------------------------

// 下の表示 ---------------------------------------------
//外部からデータベース接続コード読み込み ------------
    include 'data_base.php';
    if (mysqli_connect_errno() > 0) {
    die("接続失敗" . mysqli_connect_error());
  } else {
    // テスト用
    // echo "データベース接続成功1";
    // echo "<br><br>";
  }
  // 文字化け防止 ---------------------------
  mysqli_set_charset($mysqli, 'utf8');

// コメント書くボタンを押した時 -------------------------------
  if( !empty($_POST['comment_btn'])) {
    // コメントが未入力時のチェック ------------------
    if( empty($_POST['comment'])) {
      $error_text[] =  'コメントは必須です。';
    }
    
    // コメントが文字数50を超えた時のチェック --------
    if ( strlen($_POST['comment']) >= 50) {
      $error_text[] =  'タイトルは50文字以下です。<br>';
    } 
    
    // コメント入力 ---------------------------
    if (empty($error_text)) {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $article_id = $_GET['id'];
        $comment = $_POST['comment'];
        // INSERT文の発行 ---------------------------
        mysqli_query($link, "INSERT INTO comments(article_id, comment) VALUES  ('$article_id', '$comment')");
      }
      // データベース切断
      $close = mysqli_close($link);
      if ($close) {
        // echo "切断成功0";
        // echo "<br>";
      }
      header('Location:http://localhost:8888/laravelnews/message.php?id=' . $id);
    }   
  }
  
  // 外部からデータベース接続コード読み込み ------------
    include 'data_base.php';
    if (mysqli_connect_errno() > 0) {
    die("接続失敗" . mysqli_connect_error());
  } else {
    // テスト用
    // echo "データベース接続成功2";
    // echo "<br><br>";
  }
  // // コメント出力 ------------------------------------
  // SELECT文の発行 ---------------------------
  $result_comment_read = mysqli_query($link, "SELECT id, article_id, comment FROM comments");
  if(!$result_comment_read) {
    die("クエリ失敗" . mysqli_error());
  } else {
    // テスト用
    // echo "クエリ成功";
    // echo "<br><br>";
  }
  // データの取得及び取得データの表示 ---------------------------
  while ($row = mysqli_fetch_assoc($result_comment_read)) {
    if ($row['article_id'] === $article_id) {
      // テスト用
      // echo "id=" . $row['id'] . "<br>";
      // echo "title=" . $row['article_id'] . "<br>";
      // echo "text=" . $row['comment']. "<br>";
      $rows[] = $row;
    }
  }
  
  // 新しい投稿を1番上にする ----------------------------------
  $rows_reverse = array_reverse($rows); 
  
  // データベース切断
  $close = mysqli_close($link);
  if ($close) {
    //テスト用
    // echo "切断成功2";
    // echo "<br>";
    // echo "<br>";
  }
  // データの削除 -------------------------------------
  // 外部からデータベース接続コード読み込み ------------
    include 'data_base.php';
    if (mysqli_connect_errno() > 0) {
    die("接続失敗" . mysqli_connect_error());
  } else {
    // テスト用
    // echo "データベース接続成功3";
    // echo "<br><br>";
  }

  // 文字化け防止 ---------------------------
  mysqli_set_charset($mysqli, 'utf8');
    
  //コメントを削除ボタンを押した時 --------------------
  if( !empty($_POST['delete'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // DELETE文の発行 ---------------------------
      $result_delete = mysqli_query($link, "DELETE FROM comments WHERE id = $id");
      if(!$result_delete) {
    die("クエリ失敗" . mysqli_error());
  } else {
    // テスト用
    echo "クエリ成功";
    // echo "<br><br>";
  }
    } 
    
    // データベース切断
    $close = mysqli_close($link);
    if ($close) {
      // echo "切断成功3";
      // echo "<br>";
    }
  }

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

    <!-- 投稿内容表示(触らない！)-->
    <?php foreach ($rows_reverse as $row): ?>
      <h3><?php echo $row['title'] ?></h3>
          <p><?php echo $row['text'] ?></p>
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
    <!-- コメント入力(触らない！) -->
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
  <?php if (!empty($rows_reverse)): ?>
    <?php foreach ($rows_reverse as $row): ?>
      <div class="comment1_box">
        <?php echo $row['id'] ?><br>  <!--テスト用 後で消す-->
        <?php echo $row['article_id'] ?><br>  <!--テスト用 後で消す-->
        <?php echo $row['comment'] ?><br>
        <input type="submit" class="delete_btn" name="delete" value="コメントを削除"> 
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