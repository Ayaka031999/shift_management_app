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

    // echo '<p>認証成功</p>';

    
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="css/style_setting.css"> -->
    <title>アカウント情報修正かパスワード変更</title>
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




    .acon_check {
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;
        font-size: 17px;
        color: rgba(0, 0, 0, 0.76);
        border: solid 0.5px;
        border-radius: 30px;
        background-color: #fff0f5;
        padding: 20px 40px;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        margin-right: 10px;

        display: inline-block;
        text-decoration: none;
        cursor: pointer;

    }

    .acon_check:hover {
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;
        font-size: 17px;
        color: rgba(0, 0, 0, 0.76);
        border: solid 0.5px;
        border-radius: 30px;
        background-color: #fff;
        padding: 20px 40px;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        margin-right: 10px;

        display: inline-block;
        text-decoration: none;
        cursor: pointer;

    }



    .pass_chan {
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;
        font-size: 17px;
        color: rgba(0, 0, 0, 0.76);
        border: solid 0.5px;
        border-radius: 30px;
        background-color: #e0ffff;
        padding: 20px 40px;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        margin-left: 10px;

        display: inline-block;
        text-decoration: none;
        cursor: pointer;


    }

    .pass_chan:hover {
        

        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;
        font-size: 17px;
        color: rgba(0, 0, 0, 0.76);

        

        border: solid 0.5px;
        border-radius: 30px;
        background-color: #ffff;
        padding: 20px 40px;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        margin-left: 10px;

        display: inline-block;
        text-decoration: none;
        cursor: pointer;


    }

    .container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 80vh;
  }

  .separator {
    height: 100%;
    border-left: 2px solid #ccc;
    margin: 0 20px;
  }

  .content {
    width: 50%;
    padding: 0 20px;
    text-align: center;
  }

  .content p {
    font-size: 18px;
    line-height: 1.6;
    margin-top: 20px;
  }

  img{
    margin-top:0px;
  }

  </style>


<header>
    <h1>シフト管理</h1>
    <div class="page-right"><a href="member.php">トップページ</a>-><a href="pass_change.php">パスワード認証</a>-><a>アカウント情報変更・パスワード変更選択画面</a><div>
</header>

<body>



<div class="container">
  <div class="content">
    <img src="画像/profile.png">
    <p>アカウントに登録されている情報を変更したい方はこちら</p>
    <a href="account_setting.php" target="_top"><button class="acon_check">アカウント設定</button></a>
  </div>
  <div class="separator"></div>
  <div class="content">
    <img src="画像/key.png">
    <p>パスワードを変更したい方はこちら</p>
    <a href="pass_check.php" target="_top"><button class="pass_chan">パスワード変更</button></a>
  </div>
</div>




</body>

</html>