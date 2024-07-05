<?php
// require_once('funcs.php');
// $pdo= db_conn();

$id = $_GET['id'];


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
//   } catch (PDOException $e) {
//     exit('DB Connection Error:' . $e->getMessage());
//   }

// try {
//     //ID:'root', Password: xamppは 空白 ''
//     $pdo = new PDO('mysql:dbname='. $prod_db .';charset=utf8;host='. $prod_host, $prod_id, $prod_pw);
//   } catch (PDOException $e) {
//     exit('DBConnectError:'.$e->getMessage());
//   }


//  try {
//     $db_name = 'gs_db_class3';    //データベース名
//     $db_id   = 'root';      //アカウント名
//     $db_pw   = '';      //パスワード：MAMPは'root'
//     $db_host = 'localhost'; //DBホスト
//     $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
// } catch (PDOException $e) {
//     exit('DB Connection Error:' . $e->getMessage());
// }

//２．データ詳細表示SQL作成
$stmt = $pdo->prepare('SELECT * FROM gs_kadai_bookmark WHERE id = :id ;');
$stmt -> bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//３．データ表示
$view = '';
if ($status === false) {
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    $result = $stmt->fetch();

}

// var_dump($result);

?>
<!--
２．HTML
以下にindex.phpのHTMLをまるっと貼り付ける！
(入力項目は「登録/更新」はほぼ同じになるから)
※form要素 input type="hidden" name="id" を１項目追加（非表示項目）
※form要素 action="update.php"に変更
※input要素 value="ここに変数埋め込み"
-->

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>★書籍BookMark★</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>

<body>

    <!-- Head[Start] -->
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
            </div>
        </nav>
    </header>
    <!-- Head[End] -->

    <!-- Main[Start] -->
    <form method="POST" action="update.php">
        <div class="jumbotron">
            <fieldset>
                <legend>あなたのおすすめの書籍を教えてください♪</legend>
                <label>本の名前：<input type="text" name="name" value="<?= $result['name'] ?>"></label><br>
                <label>書籍のURL（Amazonサイトなど）：<input type="url" name="bookurl" value="<?= $result['bookurl'] ?>"></label><br>
                <label>書籍を読んでの感想：<input type="text" name="comment" value="<?= $result['comment'] ?>"></label><br>
               
                <input type="hidden" name="id" value="<?= $result['id'] ?>">

                <input type="submit" value="送信">
            </fieldset>
        </div>
    </form>
    <!-- Main[End] -->


</body>

</html>
