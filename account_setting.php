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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="CSS/style_account.css">
    <title>アカウント設定を変更</title>
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

    #update_btn {
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;

        font-size: 20px;
        padding-left: 4em;
        padding-right: 4em;
        padding-top: 1em;
        padding-bottom: 1em;
        color: white;
        background-color: deepskyblue;
        /* border-radius: 10px;  */
        border-style: none;
        border-radius: 100em;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        ;

    }


    #update_btn:hover {
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;

        font-size: 20px;
        padding-left: 4em;
        padding-right: 4em;
        padding-top: 1em;
        padding-bottom: 1em;
        color: deepskyblue;
        background-color: white;
        /* border-radius: 10px;  */
        border-color: deepskyblue;
        border: solid 0.5px;
        border-radius: 100em;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        ;

    }


    input {
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;

        margin-top: 5px;
        margin-bottom: 10px;
        text-align: center;
        border-radius: 10px;
        padding-top: 10px;
        padding-bottom: 10px;
        padding-left: 10px;
        padding-right: 40px;
        border-color: rgba(0, 0, 0, 0.705);
        border-style: solid;

    }


    .center {
        width: fit-content;
        margin: auto;
        padding-bottom: 20px;
    }

    label {
        /* position: absolute;
        top: 50%; */
        display: inline-block;
        width: 200px;
        padding-top: 15px;
        vertical-align: top;
        text-align: right;
        margin-right: 20px;
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



    .back-btn {
        border-style: solid;
        border-width: 0.5px;
        border-radius: 50%;
        /* 丸みを持たせる */
        overflow: hidden;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        ;
        width: 50px;
        /* 画像のサイズを調整 */
        height: 50px;
        /* 画像のサイズを調整 */
        position: fixed;
        /* 固定位置に配置 */
        bottom: 20px;
        /* ボタンをビューポートの下端からの距離を指定 */
        left: 20px;
        /* ボタンをビューポートの右端からの距離を指定 */
        z-index: 999;
        /* ボタンが他の要素の上に表示されるように設定 */
    }


    .back-btn-label {
        width: 50px;
        position: fixed;
        bottom: 70px;
        /* ボタンをビューポートの下端からの距離を指定 */
        left: 10px;
        /* ボタンをビューポートの右端からの距離を指定 */
        z-index: 999;
    }


    .comp_input{
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;
        border: none;
        outline: none;
        font-size: 17px;
    }
</style>

<header>
    <h1>シフト管理</h1>
    <div class="page-right"><a href="member.php">トップページ</a>-><a href="pass_change.php">パスワード認証</a>-><a href="menu_account.php">アカウント情報変更・パスワード変更選択画面</a>-><a>アカウント情報変更画面</a>
        <div>
</header>


<body>
    <h1>アカウント情報変更</h1>
    <label class="back-btn-label">戻る</label>
    <a href="member.php" title="トップへ戻る"><img src="画像/return.png" class="back-btn"></a>
    <!-- <form action="member.php" accept-charset="UTF-8">
    <input type="submit" name=back value="トップへ戻る">
    </form> -->

    <?php



    // echo gettype($num);
    // echo "{$message}さん";
    try {

       $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");



        $sql = $db->query("SELECT name,email,pass,birthday,tel FROM member WHERE userID = '$num'");

        $resister = $sql->fetch();

        $name = $resister['name'];
        $email = $resister['email'];
        // $pass = $resister['pass'];
        $birthday = $resister['birthday'];
        $tel = $resister['tel'];


        // echo '<script>document.getElementById("comp").style.display = "none"</script>';


        echo '<form class="update" method="post" accept-charset="UTF-8" class="center" id="center">';
        echo '<label>名前 : </label><input type="text" name="name" value=' . $name . ' required /><br>';
        echo '<label>メールアドレス : </label><input type = "email" name="email" value=' . $email . ' required /><br>';
        echo '<label>生年月日 : </label><input  style="width:162px;" type = "date" name="birthday" value=' . $birthday . ' required /><br>';
        echo '<label>電話番号 : </label><input type = "tel" name="tel" value=' . $tel . ' required /><br>';
        echo '<input id="update_btn" type ="submit" name="update" value="変更"><br>';
        echo '</form>';





        //変更ボタンが押されたら
        if (isset($_POST['update'])) {
            $name2 = $_POST["name"];
            $birthday2 = $_POST["birthday"];
            $email2 = $_POST["email"];
            $tel2 = $_POST["tel"];
            // $pass2 = $_POST["pass");
            //$hash_pass2 = password_hash($pass2, PASSWORD_DEFAULT);

            // echo $name2,$birthday2,$email2,$tel2,$pass2;

    

            $count = $db->exec("UPDATE member SET name='$name2',email='$email2',birthday='$birthday2',tel='$tel2' WHERE userID = '$num'");

            if ($count) { //登録できたら                    
                // echo "<h2>登録完了</h2>";
                echo '<script>document.getElementById("center").style.display = "none"</script>';
                // echo '<script>document.getElementById("comp").style.display = "block"</script>';


                $alert = "<script type='text/javascript'>alert('登録が完了しました。');</script>";
                echo $alert;

                echo '<div align=center id="comp">';
                echo '<h2>以下の内容で変更が完了しました。</h2>';

                echo '<form  accept-charset="UTF-8" class="center" >';
                echo '<label>名前 : </label><input type="text" name="name"  class="comp_input" value=' . $name2 . ' readonly /><br>';
                echo '<label>メールアドレス : </label><input type = "email" name="email" class="comp_input" value=' . $email2 . ' readonly /><br>';
                echo '<label>生年月日 : </label><input  style="width:210px;" type = "date" name="birthday" class="comp_input" value=' . $birthday2 . ' readonly  /><br>';
                echo '<label>電話番号 : </label><input type = "tel" name="tel" class="comp_input" value=' . $tel2 . ' readonly  /><br>';
                echo '</form>';
    
                echo '<p style="font-size:17px;">変更が完了しました。左下の戻るボタンでトップページへ戻ってください。</p>';
                echo '</div>';
            } else {
                $alert = "<script type='text/javascript'>alert('登録できませんでした。');</script>";
                echo $alert;
            }
        }
    } catch (PDOException $e) {
        echo "<div>" + $e->getMessage() + "</div>";
    }

    function change_method($name, $email, $birthday, $tel)
    {


        // echo "パスワード変更<br>";
        // echo 'パスワード : <input type="pass" name="pass" value=1234 ><br>';


    }



    ?>
</body>

</html>