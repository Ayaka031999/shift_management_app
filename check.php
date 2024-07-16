<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録内容確認画面</title>
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


    .yesbtn {
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
    }

    .yesbtn:hover {
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
    }



    .nobtn {
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

    }

    .nobtn:hover {
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

    }

    label {
        display: inline-block;
        text-align: right;
        width: 200px;
    }

    input{
        border: none;
        outline: none;
        font-size: 17px;
    }

    p{
        font-size: 17px;
    }

    .page-right{
        display: inline-block;
        height: 27px;
        font-size: 15px;
        padding-top: 10px;
        padding-left: 10px;
        padding-bottom: 0px;
        margin: 0px;
        width:100%;
        background-color: antiquewhite;
        border:none;

    }


</style>
<header>
    <h1>シフト管理</h1>
    <div class="page-right"><a href="login.php">ログイン画面</a>-><a href="entry.php">新規登録画面</a>-><a>登録内容確認画面</a><div>
</header>

<body>
    <?php

    $userID = (int)$_POST["userID"]; //型変換が必要 ここにsettypeじゃない
    $name = $_POST["name"];
    $birthday = $_POST["birthday"];
    $email = $_POST["email"];
    $tel = $_POST["tel"];
    $password = $_POST["password"];


    $userID = htmlspecialchars($userID, ENT_QUOTES, 'UTF-8'); //文字列に変換（セキュリティ対策）
    $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $birthday = htmlspecialchars($birthday, ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
    $tel = htmlspecialchars($tel, ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');

    $passlen = strlen($password);
    ?>


    <div class=entry align=center>
        <h1 align=center>下記の内容で登録してよろしいですか？</h1>
        <form method="post" action="end_entry.php" accept-charset="UTF-8" class="center">
            <p>
                <label for="userID">ユーザーID:</label>
                <!-- <?= $userID ?> -->
                <input type="number" name="userID" id="userID" value="<?= $userID ?>" readonly/>
            </p>

            <p>
                <label for="name">名前:   </label>
                <!-- <?= $name ?> -->
                <input type="text" name="name" id="name" value="<?= $name ?>" readonly/>
            </p>

            <p >
                <label for="birthday" >生年月日:   </label>
                <!-- <?= $birthday ?> -->
                <input style="width:214px;" type="date" name="birthday" id="birthday" value="<?= $birthday ?>" readonly/>
            </p>

            <p>
                <label for="emai">メールアドレス:   </label>
                <!-- <?= $email ?> -->
                <input type="email" name="email" id="email" value="<?= $email ?>" readonly/>
            </p>
            
            <p>
                <label for="tel">電話番号:   </label>
                <!-- <?= $tel ?> -->
                <input type="tel" name="tel" id="tel" value="<?= $tel ?>" readonly/>
            </p>

            <p>
                <label for="password">パスワード:   </label>
                <!-- <?php for ($i = 0; $i < $passlen; $i++) echo '*'; ?> -->
                <input type="password" name="password" id="password" value="<?= $password ?>" readonly/>
            </p>


            <input type="submit" class="yesbtn" value="登録する">
            <input type="button" onclick="history.back()" class="nobtn" value="キャンセル">

        </form>
    </div>

</body>

</html>