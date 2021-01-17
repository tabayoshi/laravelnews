<?php

$fp = fopen('data.csv', 'r'); 
  while ($row = fgetcsv($fp)) { 
         $rows[0] = $row;
        var_dump($rows[0]);
      }
fclose($fp);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laravel News</title>
  <link rel="stylesheet" href="./style.css">
</head>
<body>
  <header>
    <p>Laravel News</p>
  </header>
  <div>
    <?php foreach ($rows as $row): ?>
      <h3><?=$row[0]?></h3><br>
      <p><?=$row[1]?></p>
      <hr>
    <?php endforeach; ?>
  </div>
  <div class="comment_box">
    <form action="" id="" method="POST">
      <div>
        <textarea class="comment" type="text" name="comment" value=""></textarea>
      </div>
      <div>
        <input type="submit" class="comment_btn" name="button" value="コメントを書く">
      </div>
    </form>
  </div>
  <div>
    <a href="index.php">元のページに戻る</a>
  </div>
</body>
</html>