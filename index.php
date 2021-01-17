<!-- フォームに入力したデータをCSVファイルに書き込む -->
<?php
// 変数の初期化
// $error_text = array();

if( !empty($_POST['button'])) {
  
  // タイトルが未入力時のチェック
  if( empty($_POST['title'])) {
    $error_text[] =  'タイトルは必須です。<br>';
  }

  // タイトルが文字数30を超えた時のチェック
  if ( strlen($_POST['title']) >= 30) {
    $error_text[] =  'タイトルは30文字以下です。<br>';
  } 
  
  //記事が未入力時のチェック
  if ( empty($_POST['article'])) {
    $error_text[] =  '記事は必須です。';
  }
  
  if (empty($error_text)) {                            //csvファイルに書き込む判断をエラーメッセージの有無で判断する
    // フォームで入力された値をCSVファイルに書き込む
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {        //何がか投稿されたという意味
      $array = [$_POST['title'], $_POST['article']];  //書き込む配列を生成する
      $fp = fopen('data.csv', 'a+b');                 //data.cvsファイルを開く  追記したいのでa+を指定する
      fputcsv($fp, [$_POST['title'], $_POST['article']]);                           //行をcvs形式にフォーマットし、ファイルポインタに書き込む
      rewind($fp);                                   //先頭にポインタを戻す
    } 
      
    while ($row = fgetcsv($fp)) {                   //CVS１行を配列として取り出す 一時的に$rowに代入する
      $rows[] = $row;                               //$rowを$rowsに代入する
    }
    fclose($fp);                                    //ファイルを閉じる
  }


  header('Location: ./');
}

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="device-width, initial-scale=1.0">
    <title>Laravel News</title>
    <link rel="stylesheet" href=" ./style.css">
  </head>
  <body>
    <header>
      <p>Laravel News</p>
    </header>

    <div>
      <h2>さぁ、最新のニュースをシェアしましょう</h2>
    
      <!-- エラーメッセージ -->
      <?php if(!empty($error_text)): ?> 
        <ul class="error_title">
          <?php foreach( $error_text as $value): ?>
            <li><?php echo $value; ?></li>
          <?php endforeach; ?>
        <ul>
      <?php endif; ?>
      
      <!-- フォーム入力 -->
      <form method="POST" action="<?php echo($_SERVER['PHP_SELF'])?>">

      <div class="title">
        <label class="label_title">タイトル：</label>
        <input id="title" type="text" name="title" cols="50" value="">
      </div>
      
      <div class="article">
        <label class="article_title">記事：</label>
        <textarea id="article" type="text" name="article" cols="50" rows="10" value=""></textarea>
      </div>
      
        <input type="submit" class="button" name="button" value="投稿">

      </form>
      <hr>
    </div>
    <div>
      <!-- 入力データ表示 -->
      <?php if (!empty($rows)): ?>
        <?php foreach ($rows as $row): ?>
            <h3><?=$row[0]?></h3><br>
            <p><?=$row[1]?></p>
            <a href="edit.php">記事全文・コメントを見る</a>
            <hr>
        <?php endforeach; ?>
      <?php endif; ?>
    <div>

  <script src="script.js"></script>
  </body>
</html>