<!-- フォームに入力したデータをCSVファイルに書き込む -->
<?php
// 変数宣言
$title = $_POST['title'];
$article = $_POST['article'];
$button = $_POST['button'];

// 変数の初期値
$error_text = array();

if( !empty($button)) {
  
  // タイトルの入力チェック
  if( empty($title)) {
    $error_text[] =  'タイトルは必須です。<br>';
  }
  if ( strlen($title) >= 30) {
    $error_text[] =  'タイトルは30文字以下です。<br>';
  } 
  
  //記事の入力チェック
  if ( empty($article)) {
    $error_text[] =  '記事は必須です。';
  }
  
  if( empty($error_text)) { //$error_textが空であるか確認する
    if ($_SERVER['REQUEST_METHOD'] === 'POST') { //何がか投稿されたという意味
      $fp = fopen('data.csv', 'a+b'); //data.cvsファイルを開く  読み出しをできるようにa+にする
      fputcsv($fp, [$title, $article]); //行をcvs形式にフォーマットし、ファイルポインタに書き込む
      rewind($fp); //先頭にポインタを戻す
    }
      while ($row = fgetcsv($fp)) { //CVS１行を配列として取り出す 一時的に$rowに代入する
        $rows[] = $row; //$rowを$rowsに代入する
      }
      fclose($fp); //ファイルを閉じる
  }
}
?>

<?php

      ?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="device-width, initial-scale=1.0">
  <title>Laravel News</title>
</head>
<body>
  <div>
    <h1>Laravel News</h1>
  </div>

  <div>
    <h2>さあ、最新のニュースをシェアしましょう</h2>
  
    <!-- エラーメッセージ -->
    <?php if(!empty($error_text)): ?> 
      <ul class="error_title">
        <?php foreach( $error_text as $value): ?> <!-- $error_textから１つずつ値を取り出して$valueに代入 -->
          <li><?php echo $value; ?></li>
        <?php endforeach; ?>
      <ul>
    <?php endif; ?>
    
    <!-- フォーム入力 -->
    <form method="POST" action="<?php echo($_SERVER['PHP_SELF'])?>">
    
      タイトル:<input id="title" type="text" name="title" value=""><br>
          記事:<textarea id="article" type="text" name="article" value=""></textarea><br>
      <input type="submit" class="button" name="button" value="投稿"></input>
    </form>
    <hr>
  </div>
  <div>
    <!-- 入力データ表示 -->
    <?php if (!empty($rows)): ?>
    <?php foreach ($rows as $row): ?>
    <!-- idを入れる -->
        <h3><?=$row[0]?></h3><br>
        <p><?=$row[1]?></p>
        <a href="edit.php">記事全文・コメントを見る</a>
        <hr>
    <?php endforeach; ?>
    <?php else: ?>
      <p>投稿はまだありません</p>
    <?php endif; ?>
  <div>

<script src="script.js"></script>
</body>
</html>

<!-- アラートはjs -->
<!-- 注意書きはphp -->