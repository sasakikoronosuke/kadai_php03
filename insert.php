<?php

/**
 * 1. index.phpのフォームの部分がおかしいので、ここを書き換えて、
 * insert.phpにPOSTでデータが飛ぶようにしてください。
 * 2. insert.phpで値を受け取ってください。
 * 3. 受け取ったデータをバインド変数に与えてください。
 * 4. index.phpフォームに書き込み、送信を行ってみて、実際にPhpMyAdminを確認してみてください！
 */

//1. POSTデータ取得


$name = $_POST['name'];
$bookurl = $_POST['bookurl'];
$comment = $_POST['comment'];


// try {
//     $db_name = 'gs_db_kadai'; //データベース名
//     $db_id   = 'root'; //アカウント名
//     $db_pw   = ''; //パスワード：MAMPは'root'
//     $db_host = 'localhost'; //DBホスト
//     $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
// } catch (PDOException $e) {
//     exit('DB Connection Error:' . $e->getMessage());
// }


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

//３．データ登録SQL作成（接続したDBに対して何をしたいかをSQLで書く）SQL文を用意
$stmt = $pdo->prepare(
  'INSERT INTO
                gs_kadai_bookmark( id, name, bookurl, comment, date )
                VALUES( NULL, :name, :bookurl, :comment, now() ) ');


//  2. バインド変数を用意　↑で書いたSQLの実行
// Integer 数値の場合 PDO::PARAM_INT
// String文字列の場合 PDO::PARAM_STR

$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':bookurl', $bookurl, PDO::PARAM_STR);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);

//  3. 実行
$status = $stmt->execute();

//４．データ登録処理後
if($status === false) {
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit('ErrorMessage:'.$error[2]);
} else {
    //５．index.phpへリダイレクト

    header('Location: index.php');

}
?>
