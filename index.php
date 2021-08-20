<?php require_once 'processdb.php';
require_once 'functions.php';
createToken();
?>

<!doctype html>
<html lang="ja">
<head>
  <title>PHP CRUD</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>

  <!-- jQuery、Popper.js、Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

  <?php
  if(isset($_SESSION['message'])): ?>
  <div class="alert alert-<?=$_SESSION['msg_type']?>">
    <?php
    echo $_SESSION['message'];
    unset($_SESSION['message']);
    ?>
  </div>
 <?php endif ?>

<div class="container">

  <?php
  $dbh = dbconnect();
  $sql = 'SELECT * FROM data';
  $stmt = $dbh->prepare($sql);//sql文をする準備
  $stmt = $dbh->query($sql);//sql文を実行
  ?>

  <div class="row justify-content-center">
    <table class="table">
      <thead>
        <tr>
          <th>名前</th>
          <th>住所</th>
          <th colspan="2">編集／削除</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
          <td class="align-middle"><?php echo $row['name'] ; ?></td>
          <td class="align-middle"><?php echo $row['location']; ?></td>
          <td>
            <a href="index.php?edit=<?php echo $row['id'];?> & token=<?= h($_SESSION['token']);?>"
              class="btn btn-info">編集</a>
            <a href="processdb.php?delete=<?php echo $row['id'];?> & token=<?= h($_SESSION['token']);?>"
              class="btn btn-danger">削除</a>
          </td>
        </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <div class="row justify-content-center">
      <form action="processdb.php" method="POST">
        <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
        <input type="hidden" name="id" value="<?php echo h($id); ?>">
        <div class="form-group">
          <label>名前</label>
          <input maxlength='20' required autofocus type="text" name="name" class="form-control" value="<?php echo h($name);?>" placeholder= "名前を入力">
        </div>
        <div class="form-group">
          <label>住所</label>
          <input maxlength='100' required autofocus type="text" name="location" class="form-control" value="<?php echo h($location);?>" placeholder= "住所を入力">
        </div>
        <div class="form-group">
          <?php
          if($update === true):
            ?>
            <button type="submit" class="btn btn-info" name="update">編集</button>
          <?php else: ?>
            <button type="submit" class="btn btn-primary" name="save">保存</button>
          <?php endif; ?>
        </div>
      </form>
    </div>

    <div class="row justify-content-center">
      <button type="button" class="btn btn-secondary" onclick="location.href='index.php'">戻る</button>
    </div>
  </div>
</body>
</html>
