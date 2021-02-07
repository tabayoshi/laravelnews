<!-- データの保存先をデータベースにする -->
<?php
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
    if ( empty($_POST['article'])) {
      $error_text[] =  '記事は必須です。';
    }
    
    //csvファイルへの書き込み -----------------------
    if (empty($error_text)) {                                     
      
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $fp = fopen('data.csv', 'a+b');
        $title = $_POST['title'];
        $article = $_POST['article'];
        
        // 投稿番号 -----------------------------------
        $data = 'data.csv';
        if(file_exists($data)) {
          $id = count(file($data)) + 1;
        }
        
        fputcsv($fp, [$id, $title, $article]);
        rewind($fp);
      }
      fclose($fp);
      header("Location:http://localhost/laravelnews/index.php");
    }  
  }
  
  // csvファイルからの読み込み -----------------------------------
  $fp = fopen('data.csv', 'a+b');
  while ($row = fgetcsv($fp)) {
    $rows[] = $row;
    //新しい投稿を1番上にする ----------------------------------
    $rows_reverse = array_reverse($rows); 
  }
  fclose($fp);

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
    
      <!-- エラーメッセージ表示 -->
      <?php if(!empty($error_text)): ?> 
        <ul>
          <?php foreach( $error_text as $value): ?>
            <li><?php echo $value; ?></li>
          <?php endforeach; ?>
        <ul>
      <?php endif; ?>
      
      <!-- フォーム入力 -->
      <form method="POST" action="">
        <div class="title">
          <input type="hidden" name="id" value="">
          <label class="label_title">タイトル：</label>
          <input type="text" class="title" name="title" cols="50" value="">
        </div>
        
        <div class="article">
          <label class="article_title">記事：</label>
          <textarea name="article" cols="50" rows="10" value=""></textarea>
        </div>
      
        <input type="submit" class="button" name="btn_submit" value="投稿">
      </form>
      <hr>
    </div>

      <!-- 入力データ表示 -->
    <div>
      <?php if (!empty($rows_reverse)): ?>
        <?php foreach ($rows_reverse as $row): ?>
          <p><?=$row[0]?></p>
          <h3><?=$row[1]?></h3>
          <p><?=$row[2]?></p>
          <a href="message.php?id=<?=$row[0] ?>">全文・コメントを見る</a>
          <hr>
        <?php endforeach; ?>
      <?php endif; ?>
    <div>

    <script src="script.js"></script>
  </body>
</html>