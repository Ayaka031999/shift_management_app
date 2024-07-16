<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>パスワード再設定完了</title>
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


    h1 {
        color: rgba(0, 0, 0, 0.705);
        /* メニューのテキスト色 */
    }

    label {
        text-align: right;
    }

    body {
        padding-top: 150px;
        text-align: center;
    }


    .topbtn {
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;
        font-size: 17px;
        color: rgba(0, 0, 0, 0.76);
        border: solid 0.5px;
        border-radius: 30px;
        background-color: #fffacd;
        padding: 20px 40px;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        margin-top: 30px;
    }

    .topbtn:hover {
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;
        font-size: 17px;
        color: rgba(0, 0, 0, 0.76);
        border: solid 0.5px;
        border-radius: 30px;
        background-color: #fff;
        padding: 20px 40px;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        margin-top: 30px;
    }


    .form-control {

        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;
        padding: 10px 50px;
        margin: 10px;
        border: solid 0.5px;
        border-radius: 30px;
    }

    .center {
        width: fit-content;
        margin: auto;
    }

    /* ここから追記部分 */
    label {
        /* position: absolute;
        top: 50%; */
        display: inline-block;
        width: 200px;
        padding-top: 15px;
        vertical-align: top;
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

</style>

<header> 
    <h1>シフト管理</h1>
    <div class="page-right"><a href="member.php">トップページ</a>-><a href="pass_change.php">パスワード認証</a>-><a href="menu_account.php">アカウント情報変更・パスワード変更選択画面</a>-><a>パスワード変更画面</a><div>

</header>


<body>


    <?php
   $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");


    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['token'])) {

        // 再設定トークンの取得
        $reset_token = $_GET['token']; //トークンゲット

        // データベースからユーザーを取得し、再設定トークンと比較する
        $sql = $db->prepare("SELECT userID FROM member WHERE reset_token = :reset_token AND token_expiration > NOW()");
        $sql->execute(array(':reset_token' => $reset_token));
        $result = $sql->fetch(PDO::FETCH_ASSOC);

        $userID = $result['userID']; //ユーザーIDを保存

    } else {

        //セッションを使うことを宣言
        session_start();

        //ログインされていない場合は強制的にログインページにリダイレクト
        if (!isset($_SESSION['login_ID'])) {
            header("Location: login.php");
            exit();
        }

        //ログインされている場合は表示用メッセージを編集
        $userID = $_SESSION['login_ID'];
    }


    // 再設定トークンが一致し、かつ有効期限内であるかを確認する
    if (!empty($userID)) {
        // トークンが一致し、有効期限内の処理
    ?>

        <form method=post accept-charset="UTF-8" id="resetpass" class="center">
        <h1>新しいパスワードを設定してください。</h1>

            <div class="form-group">
                <label>新しいパスワード</label>
                <input type="password"  class="form-control" name="password" id="password" required/>
            </div>
            <br>
            <div class="form-group">
                <label>新しいパスワード (再確認)</label>
                <input type="password" class="form-control" name="confirm" oninput="CheckPassword(this)" required/>
            </div>
            <input type=submit name="passChange" value="パスワードを変更" class="topbtn">
        </form>

        <script>
            function CheckPassword(confirm) {
                // 入力値取得
                var input1 = password.value;
                var input2 = confirm.value;
                // パスワード比較
                if (input1 != input2) {
                    confirm.setCustomValidity("入力値が一致しません。");
                    button.disabled = false;
                    return
                } else {
                    confirm.setCustomValidity('')
                    button.disabled = true;
                }
            }
        </script>


        <?php
        if (isset($_POST['passChange'])) {

            //フォームを見えなくする
            echo '<script>document.getElementById("resetpass").style.display = "none";</script>';

            $hash_pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

              $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");




            $count = $db->exec("UPDATE member SET pass='$hash_pass' WHERE userID = $userID");

            if ($count) { //登録できたら                    
                echo "<h1>登録完了</h1>";
                echo '<p style="font-size:17px;">パスワードの変更が完了しました。<br>下のボタンからログインページに移動してログインしてください。</p>';
                echo '<a href="login.php"><button class="topbtn">ログインはこちら</button></a>';
                // トークンと有効期限を無効な値で更新するなどの処理
                $update_sql = $db->prepare("UPDATE member SET reset_token = NULL, token_expiration = NULL WHERE userID = :user_id");
                $update_sql->execute(array(':user_id' => $userID));
                //echo "トークンと有効期限を無効にしました。";
            } else {
                echo "<h2>登録できませんでした。</h2>";
            }
        }

        ?>


    <?php
    } else {
        // トークンが一致しないか、有効期限外の処理
        echo "無効な再設定トークンです。";
    }
    ?>




</body>

</html>