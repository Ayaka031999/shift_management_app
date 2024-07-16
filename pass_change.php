<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style_setting.css">
    <title>Document</title>
</head>
<style>
    html {
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;

    }


    header {
        position: fixed;
        width: 100%;
        height: 90px;
        padding-bottom: 0px;
        top: 0;
        left: 0;
        /* background-color: rgb(255, 161, 127);  */
        background-color: #99d8fd;
        /* ヘッダーの背景色  #99d8fd*/
        /* padding: 15px; */
        text-align: left;
        border: none;
        box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);

    }

    header h1 {
        color: rgba(0, 0, 0, 0.705);
        /* メニューのテキスト色 */
        margin-top: 10px;
        margin-left: 20px;
        margin-bottom: 0px;
        padding-bottom: 0px;
    }

    body {
        padding-top: 100px;
        font-size: 15px;
    }


    .page-right {
        display: inline-block;
        height: 35px;
        font-size: 15px;
        padding-top: 10px;
        padding-left: 10px;
        padding-bottom: 0px;
        margin: 0px;
        width: 100%;
        background-color: antiquewhite;
        border: none;

    }


    .pass{
  padding-top: 10%;
}

.pass #now_pass{
  border-style:solid;
  border-radius: 20px;
  padding: 10px 40px;
  margin-top: 20px;
}

.pass #check{
  font-family: "游ゴシック", "Yu Gothic";
  font-weight: bold;
  font-size: 20px;
  border-style:solid;
  border-width: 0.5px; 
  background-color: #99d8fd;
  border-radius: 20px;
  padding: 5px 30px;
  margin-top: 20px;
  box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);;
}

.pass #check:hover{
  font-family: "游ゴシック", "Yu Gothic";
  font-weight: bold;
  font-size: 20px;
  border-style:solid;
  border-width: 0.5px; 
  background-color: #fff;
  border-radius: 20px;
  padding: 5px 30px;
  margin-top: 20px;
}

</style>


<header>
    <h1>シフト管理</h1>
    <div class="page-right"><a href="member.php">トップページ</a>-><a>パスワード認証</a>
        <div>
</header>

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



    <div class="pass" align=center>
        <h1>現在のパスワードを入力してください</h1>
        <form method=post accept-charset='UTF-8'>
            <input type='password' name='now_pass' id='now_pass' required><br>
            <input type='submit' value='認証' id='check'>
        </form>
    </div>

    <?php
    try {
       $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");


        $now_pass = filter_input(INPUT_POST, "now_pass");

        if (!$now_pass) {
            // echo "<p>パスワードが入力されていません</p>";
        }

        if ($now_pass) {
            $sql = $db->query("SELECT pass FROM member WHERE userID = '$num'");

            $resister = $sql->fetch();

            //認証処理
            if (password_verify($now_pass, $resister['pass'])) {

                header('Location: menu_account.php');
                return;
            } else {
                $alert = "<script type='text/javascript'>alert('認証できません。正しいパスワードを入力してください。');</script>";
                echo $alert;
            }
        }
    } catch (PDOException $e) {
        echo "<div>" + $e->getMessage() + "</div>";
    }

    ?>
</body>

</html>