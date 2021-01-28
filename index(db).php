<?php
//データベースへの接続 ---------------------------------
$user = 'root';
$password = 'root';
$db = 'laravel_news';
$host = 'localhost';
$port = 3306;

$link = mysqli_init();

$mysqli = mysqli_real_connect(
$link,
$host,
$user,
$password,
$db,
$port
);

var_dump($mysqli);

if( mysqli_connect_errno($mysqli)) {
  echo "データベース接続失敗" . PHP_EOL;
  echo "errno" . mysqli_connect_errno() . PHP_EOL;
  echo "error" . mysqli_connect_error() . PHP_EOL;
  exit();
}

echo 'データベース接続成功';

// 直近のエラーを返す
mysqli_errno($mysqli);

// 文字化け防止
mysqli_set_charset($mysqli, 'utf8');

// データベースからの取得 ---------------------------

$query = "SELECT * FROM articles";
$result = $mysqli->query($query);
if($result = $mysqli->querey($query)) {
  while($row = $result->fetch_assoc()) {
    echo $row['title'];
  }
}


//送信ボタン押したとき ------------------------------
if( !empty($_POST['btn_submit'])) {
  
  // タイトルが未入力時のチェック -----------------
  if( empty($_POST['title'])) {
    $error_text[] =  'タイトルは必須です。';
  }
  
  // タイトルが文字数30を超えた時のチェック --------
  if ( strlen($_POST['title']) >= 30) {
    $error_text[] =  'タイトルは30文字以下です。';
  } 
  
  //記事が未入力時のチェック -----------------------
  if ( empty($_POST['text'])) {
    $error_text[] =  '記事は必須です。';
  }
  
  //csvファイルへの書き込み -----------------------
  // if (empty($error_text)) {                                     
    
    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      //   $title = $_POST['title'];
      //   $text = $_POST['text'];
      
      
      //   }
      //   header("Location:http://localhost/laravelnews/index.php");
      // }  
    }
    
    // csvファイルからの読み込み -----------------------------------
    // $fp = fopen('data.csv', 'a+b');
    // while ($row = fgetcsv($fp)) {
      //   $rows[] = $row;
      //新しい投稿を1番上にする ----------------------------------
      // $rows_reverse = array_reverse($rows); 
      // }
      
      
      // データベース切断
      // $mysqli->close();
      ?>
    


<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <!-- <meta name="viewport" content="device-width, initial-scale=1.0"> -->
    <title>Laravel News</title>
    <link rel="stylesheet" href=" ./style.css">
  </head>
  <body>
    <header>
      <p>Laravel News</p>
    </header>

    <div>
      <h2>さぁ、最新のニュースをシェアしましょう</h2>
    
      <!-- エラーメッセージ表示 -->
      <?php if(!empty($error_text)): ?> 
        <ul>
          <?php foreach( $error_text as $value): ?>
            <li><?php echo $value; ?></li>
          <?php endforeach; ?>
        <ul>
      <?php endif; ?>
      
      <!-- フォーム入力 データベースへの書き込みに変更-->
      <form method="POST" action="">
        <div class="title">
          <label class="label_title">タイトル：</label>
          <input type="text" class="title" name="title" cols="50" value="">
        </div>
        
        <div class="text">
          <label class="text_title">記事：</label>
          <textarea name="text" cols="50" rows="10" value=""></textarea>
        </div>
      
        <input type="submit" class="button" name="btn_submit" value="投稿">
      </form>
      <hr>
    </div>

      <!-- 入力データ表示 データベースに変更-->
    <div>
      <?php if (!empty($rows)): ?>
        <?php foreach ($rows as $row): ?>
          <h3><?=$row['title']?></h3>
          <p><?=$row['text']?></p>
          <a href="message.php?id=<?=$row[0] ?>">全文・コメントを見る</a>
          <hr>
        <?php endforeach; ?>
      <?php endif; ?>
    <div>

    <script src="script.js"></script>
  </body>
</html>