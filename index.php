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

// echo '<動作確認用>';
// echo '<br>';

// var_dump($mysqli);
// echo "<br><br>";

if (mysqli_connect_errno() > 0) {
  die("接続失敗" . mysqli_connect_error());
} else {
  // echo "接続成功";
  // echo "<br><br>";
}

// 文字化け防止 ---------------------------
mysqli_set_charset($mysqli, 'utf8');

// INSERT文の発行 ---------------------------
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $text = $_POST['text'];
    $result_write = mysqli_query($link, "INSERT INTO articles(title, text) VALUES  ('$title', '$text')");
    header("Location:http://localhost:8888/laravelnews/index.php");
  }

// SELECT文の発行 ---------------------------
$result_read = mysqli_query($link, "SELECT id, title, text FROM articles");
if(!$result_read) {
  die("クエリ失敗" . mysqli_error());
} else {
  // echo "クエリ成功";
  // echo "<br><br>";
}

// データの取得及び取得データの表示 ---------------------------
while ($row = mysqli_fetch_assoc($result_read)) {
  // echo "id=" . $row['id'] . "<br>";
  // echo "title=" . $row['title'] . "<br>";
  // echo "text=" . $row['text'] . "<br><br>";
  $rows[] = $row;
}

// 新しい投稿を1番上にする ----------------------------------
$rows_reverse = array_reverse($rows); 

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
}
  
// データベース切断
$close = mysqli_close($link);
if ($close) {
  // echo "<p>切断成功</p>";
}

?>


<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
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
        </ul>
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
      <?php if (!empty($rows_reverse)): ?>
        <?php foreach ($rows_reverse as $row): ?>
          <h3><?php echo $row['title'] ?></h3>
          <div><?php echo $row['text'] ?></div>
          <a href="message.php?id=<?php $row['id'] ?>">全文・コメントを見る</a>
          <hr>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <script src="script.js"></script>
  </body>
</html>