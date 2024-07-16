<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        height: 100px;
        top: 0;
        left: 0;
        /* background-color: rgb(255, 161, 127);  */
        background-color: #99d8fd;
        /* ヘッダーの背景色  #99d8fd*/
        /* padding: 15px; */
        text-align: left;
        box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);

    }

    h1 {
        color: rgba(0, 0, 0, 0.705);
        /* メニューのテキスト色 */
        margin-left: 20px;
    }

    body {
        padding-top: 150px;
    }

    .topbtn {
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;
        color: rgba(0, 0, 0, 0.76);
        border: solid 0.5px;
        border-radius: 30px;
        background-color: #fffacd;
        padding: 10px 30px;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
    }

    .emailbox {
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;
        padding: 10px 50px;
        margin: 10px;
        border: solid 0.5px;
        border-radius: 30px;
    }
</style>

<header> <!-- onclick="openSubWindow()" -->
    <h1>シフト管理</h1>
</header>

<body>

    <div align=center>
        <h1>登録済みのメールアドレスを入力してください。</h1>
        <form method="post" action="passResetMail.php">
            <input type="email" name="email" class="emailbox" required /><br>
            <input type="submit" class="topbtn">
        </form>
    </div>
</body>

</html>