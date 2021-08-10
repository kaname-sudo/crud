<?php

require_once 'functions.php';

$id=0;
$update = false;
$name= '';
$location= '';

// データを挿入

if (isset($_POST['save'])){
  $name = $_POST['name'];
  $location = $_POST['location'];
  $name = htmlspecialchars($name, ENT_QUOTES);
  $location = htmlspecialchars($location, ENT_QUOTES);
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
if(isset($_GET['delete'])){
  $id = $_GET['delete'];//パラメータを取得
  $dbh = dbconnect();
  $sql = "DELETE FROM data WHERE id= '".$id."'";
  $stmt = $dbh->prepare($sql);
  $stmt->execute();

  $_SESSION['message'] = "削除されました";
  $_SESSION['msg_type'] = "danger";
  header("location: index.php");
}

// データを編集
if(isset($_GET['edit'])){
  $id = $_GET['edit'];
  $dbh = dbconnect();
  $update = true;
}

if(isset($_POST['update'])){
  $id = $_POST['id'];
  $name = $_POST['name'];
  $location = $_POST['location'];

  $dbh = dbconnect();
  $sql = "UPDATE data SET name='".$name."', location='".$location."' WHERE id='".$id."'";
  $stmt = $dbh->prepare($sql);
  $stmt->execute();

  $_SESSION['message'] = "変更されました";
  $_SESSION['msg_type'] = "warning";
  header("location: index.php");
}
