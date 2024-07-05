<?php

//　①セキュリティ対策 埋め込み阻止  出力するところ（＄view .=の後）の項目を、h()でくくる。
// 他のページとかでも使えるように、セキュリティのコード関数を「funcs.php」にコピペ。
// ここでは、funcs.phpから呼び出して使う

// require_once('funcs.php');
// $pdo = db_conn();

// // 本番環境DB
$prod_db = "sasakikoronosuke_php_kadai02";
// // 本番環境ホスト
$prod_host = "mysql648.db.sakura.ne.jp";
// // 本番環境ID
$prod_id = "sasakikoronosuke";
// // 本番環境PW
$prod_pw="koronosuke_111";

//2. DB接続します
// // ここでXAMPPから、接続する
try {
//   //ID:'root', Password: xamppは 空白 ''
$pdo = new PDO('mysql:dbname='. $prod_db .';charset=utf8;host='. $prod_host, $prod_id, $prod_pw);
} catch (PDOException $e) {
 exit('DBConnectError:'.$e->getMessage());
}
//2. DB接続します
// ここでXAMPPから、接続する

// try {
//   $db_name = 'gs_db_kadai'; //データベース名
//   $db_id   = 'root'; //アカウント名
//   $db_pw   = ''; //パスワード：MAMPは'root'
//   $db_host = 'localhost'; //DBホスト
//   $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
// } catch (PDOException $e) {
//   exit('DB Connection Error:' . $e->getMessage());
// }



//２．データ取得SQL作成 SQLをここでかく！
$stmt = $pdo->prepare("SELECT * FROM gs_kadai_bookmark");
$status = $stmt->execute();

//３．データ表示
$view="";
if ($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる　Fetch＝とってくる、という意味 自動ループ：１ばんの人から始まって、最後の人まできたら終了する。
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  // .= で”."がついている点に注意！ドットを加えると「追記」になる。書かないと上書きされちゃうので、＜/ｐ＞だけが残っちゃう

  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= "<p>";
    
    $view .= '<a href="detail.php?id='.$result['id'].' ">';
    $view .= $result['id'] . ' : ' . $result['indate'] . ' : ' . $result['name'];
    $view .= '</a>';

    $view .= '<a href="delete.php?id='.$result['id'].' ">';
    $view .= '[ 削除 ]';
    $view .= '</a>';

    
    $view .= "</p>";
  }

}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>フリーアンケート表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">データ登録</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron">
    <a href="detail.php"></a>  
    <?= $view ?></div>
</div>
<!-- Main[End] -->

</body>
</html>
