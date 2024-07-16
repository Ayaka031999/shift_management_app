<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録完了</title>

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


    .topbtn {
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;
        color: rgba(0, 0, 0, 0.76);
        border: solid 0.5px;
        border-radius: 30px;
        background-color: #fffacd;
        padding: 10px 30px;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        margin-right: 10px;
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
    <header>
    <h1>シフト管理</h1>
    <div class="page-right"><a href="login.php">ログイン画面</a>-><a href="entry.php">新規登録</a>-><a href="check.php">登録内容確認</a>-><a>登録完了</a><div>
</header>

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
    $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); //文字列に変換（セキュリティ対策）
    $birthday = htmlspecialchars($birthday, ENT_QUOTES, 'UTF-8'); //文字列に変換（セキュリティ対策）
    $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); //文字列に変換（セキュリティ対策）
    $tel = htmlspecialchars($tel, ENT_QUOTES, 'UTF-8'); //文字列に変換（セキュリティ対策）
    $password = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');

    try {
       $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");


        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $delcheck = false; //アカウント削除済みメンバーか確認

        $sql = "SELECT * FROM `アカウント削除メンバー` WHERE userID='$userID'";
        $stmt = $db->query($sql);
        $resister = $stmt->fetch();

        if (!empty($resister)) {
            $sql = "DELETE FROM `アカウント削除メンバー` WHERE userID='$userID'";
            $decon = $db->query($sql);
            if ($decon) {
                // echo '削除めんばーかららデータ削除完了';
                $hash_pass = $password;
                $delcheck = true;
            } else {
                // echo '削除めんばーかららデータ削除できませんでした。';
                return;
            }
        } else {
            $delcheck = false;

            // パスワードを暗号化
            $hash_pass = password_hash($password, PASSWORD_DEFAULT);
        }

        $count = $db->exec("INSERT INTO member(userID,name,admin_check,birthday,email,tel,pass) VALUES ('$userID','$name',NULL,'$birthday','$email','$tel','$hash_pass')");


        if ($count) { //登録できたら 
            if ($delcheck) { //削除済みメンバーならもうメンバー表に遷移させる
                //セッションをスタート
                session_start();
                session_regenerate_id(TRUE); //セッションidを再発行
                $_SESSION["login_name"] = $name; //セッションにログイン情報を登録
                $_SESSION["login_ID"] = $userID; //セッションにログイン情報を登録

                header('Location:member.php');
                exit();
            }
            $alert = "<script type='text/javascript'>alert('登録しました。');</script>";
            echo $alert;
            echo "<h1 align=center>登録完了</h1>";
            echo '<p align=center>登録が完了いたしましたので、下のボタンからログインページに移動して、ログインしてください。</p>';
            echo '<p align=center><a href="login.php"><button class="topbtn">ログインはこちら</button></a></p>';
            // $alert = "<script type='text/javascript'>alert('登録が完了しました。');</script>";
            // echo $alert;
        } else {
            $alert = "<script type='text/javascript'>alert('登録できません。');</script>";
            echo $alert;
            echo "<h2 align=center>登録できません。もう一度初めからお願いします。</h2>";
            echo "<p align=center><a href='entry.php'>初めから</a></p>";
        }
    } catch (PDOException $e) {
        $alert = "<script type='text/javascript'>alert('登録できません。');</script>";
        echo $alert;
        echo "<h2 align=center>登録できません。もう一度初めからお願いします。</h2>";
        echo "<p align=center><a href='entry.php'>初めから</a></p>";
        echo "<div>" . $e->getMessage() . "</div>";
    }

    ?>



</body>

</html>