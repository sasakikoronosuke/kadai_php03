<?php

$name = $_POST['name'];
$bookurl = $_POST['bookurl'];
$comment = $_POST['comment'];
$id = $_POST['id']; 


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

// try {
//     $db_name = 'gs_db_kadai'; //データベース名
//     $db_id   = 'root'; //アカウント名
//     $db_pw   = ''; //パスワード：MAMPは'root'
//     $db_host = 'localhost'; //DBホスト
//     $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
// } catch (PDOException $e) {
//     exit('DB Connection Error:' . $e->getMessage());
// }


//３．データ登録SQL作成
$stmt = $pdo->prepare('UPDATE gs_kadai_bookmark SET   
    name = :name, 
    bookurl= :bookurl,
    comment= :comment,
    indate = now()
    WHERE id = :id;
    ');

// 数値の場合 PDO::PARAM_INT
// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':bookurl', $bookurl, PDO::PARAM_STR);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR); 
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status === false) {
    //*** function化する！******\
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    //*** function化する！*****************
    header('Location: select.php');
    exit();
}
