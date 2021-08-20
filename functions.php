<?php
function dbconnect(){

  try{
    $dsn='mysql:dbname=practodo_todolist;host=mysql1.php.xdomain.ne.jp;charset=utf8';//サーバー名、データベース名、文字エンコード
    $user='practodo_sudo';
    $password ='kaname1224';
    $dbh = new PDO(
      $dsn, //PDOインスタンス作成
      $user,
      $password,
      array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,//エラー発生時に例外を投げる
        PDO::ATTR_EMULATE_PREPARES => false,//静的プレースホルダを使用するためエミュレートをオフにする
      )
    );
    return $dbh;
  }catch (PDOException $e) {
    $error = $e->getMessage();
  }
}

function h($str){
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function createToken() {
  if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
  }
}
