<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style_setting.css">
    <title>メニュー</title>
</head>
<body>
  <?php
//セッションを使うことを宣言
session_start();


//ログインされていない場合は強制的にログインページにリダイレクト
if (!isset($_SESSION["login_name"])) {
header("Location: login.php");
exit();
}

//ログインされている場合は表示用メッセージを編集
$message = $_SESSION['login_name'];
$num = $_SESSION['login_ID'];
  ?>
<div class="sidebar">
  <ul>
    <!-- <li><a href="account_setting.php" target="_top">アカウント設定</a> -->
    <!-- <li><a href="workplace.php" target="_top">アルバイト先設定</a> -->
    <li><a href="pass_change.php" target="_top">アカウント設定とパスワード変更</a>
    <li><a href="delete_pre.php" target="_top">退会手続き</a>
  </ul>
</div>
</body>
</html>