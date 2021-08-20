<?php session_start();
require_once 'functions.php';
$id=0;
$update = false;
$name= '';
$location= '';

// データを挿入
if (isset($_POST['save'],$_POST['token'])
&& $_POST['token'] === $_SESSION['token']) {
  $name = $_POST['name'];
  $location = $_POST['location'];
  $name = h($name);
  $location = h($location);
  $dbh = dbconnect();
  $sql = 'INSERT INTO data (name,location) VALUES (?,?)';//name,locationをデータベースに挿入
  $stmt = $dbh->prepare($sql);//SQL文の実行準備をしPDOStatementクラスのインスタンスを返す
  $stmt->bindValue(1, $name, PDO::PARAM_STR);//?にnameとユーザーから入力されたタスク名の値を紐づけ　値をバインドする
  $stmt->bindValue(2, $location, PDO::PARAM_STR);
  $stmt->execute();//SQL文が実行され、データが格納される
  $dbh = null;
  unset($name);
  unset($location);
  $_SESSION['message'] = "保存されました";//$_SESSIONに代入
  $_SESSION['msg_type'] = "success";//$_SESSIONに代入
  header("location: index.php");
}

// データを削除
if(isset($_GET['delete'],$_GET['token'])
&& $_GET['token'] === $_SESSION['token']) {
  $id = $_GET['delete'];//パラメータを取得
  $dbh = dbconnect();
  $sql = 'DELETE FROM data WHERE id = :id;';
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':id', $id, PDO::PARAM_INT);
  $stmt->execute();
  $_SESSION['message'] = "削除されました";
  $_SESSION['msg_type'] = "danger";
  header("location: index.php");
}

//データを編集
if(isset($_GET['edit'],$_GET['token'])
&& $_GET['token'] === $_SESSION['token']) {
  $id = $_GET['edit'];
  $dbh = dbconnect();
  $update = true;
  $sql = 'SELECT * FROM data WHERE id = :id';
  $stmt = $dbh->prepare($sql);//sql文をする準備
  $stmt->bindValue(':id', $id, PDO::PARAM_INT);
  $stmt->execute();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $name= $row['name'];
  $location = $row['location'];
}
if(isset($_POST['update'],$_POST['token'])
&& $_POST['token'] === $_SESSION['token']) {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $location = $_POST['location'];
  $name = h($name);
  $location = h($location);
  $dbh = dbconnect();
  $sql = 'UPDATE data SET name = :name, location = :location WHERE id = :id';
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':name', $name, PDO::PARAM_STR);
  $stmt->bindValue(':location', $location, PDO::PARAM_STR);
  $stmt->bindValue(':id', $id, PDO::PARAM_INT);
  $stmt->execute();
  $_SESSION['message'] = "変更されました";
  $_SESSION['msg_type'] = "warning";
  header("location: index.php");
}
