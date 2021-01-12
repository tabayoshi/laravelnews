<?php

  $fp = fopen('data.csv', 'a+b');
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    fputcsv($fp, [$_POST['title'], $_POST['article']]);
    rewind($fp);
  }
    while ($row = fgetcsv($fp)) {
      $rows[] = $row;
    }
    fclose($fp);
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
  

  <form method="POST" action="<?php echo($_SERVER['PHP_SELF'])?>">
    タイトル:<input type="text" name="title" value=""><br>
        記事:<input type="text" name="article" value=""><br>
    <!-- <input type="button" action="alert.php"  method="POST" value="投稿"></input> -->
    <input type="submit" value="投稿"></input>
  </form>
  <hr>
  </div>

    <?php if (!empty($rows)): ?>
    <?php foreach ($rows as $row): ?>
        <h3><?=$row[0]?></h3><br>
        <p><?=$row[1]?></p>
        <a href="edit.php">記事全文・コメントを見る</a>
        <hr>
    <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p>投稿はまだありません</p>
    <?php endif; ?>
  <div>
  <?php

// 初期値設定
//   $title_alert = 'null';
//   $article_alert = 'null';

// タイトルと記事が入力されていない場合
//   if ($title == '') {
//     echo '・タイトルは必須です。<br>';
//   } else {
//     echo '';
//   }
  
// // タイトルが30文字以上の場合
//   if ($title >= 30) {
//     echo '・タイトルは30文字以下です。<br>';
//   } else {
//     echo '';
//   }

//   if ($article == '') {
//     echo '・記事は必須です。<br>';
//   } else {
//     echo '';
//   }
    
  ?>

</body>
</html>