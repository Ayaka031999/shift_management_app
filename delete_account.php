<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>退会完了</title>
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
        top: 0;
        left: 0;
        /* background-color: rgb(255, 161, 127);  */
        background-color: #99d8fd;
        /* ヘッダーの背景色  #99d8fd*/
        /* padding: 15px; */
        text-align: left;
        box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);

    }

    header h1 {
        color: rgba(0, 0, 0, 0.705);
        /* メニューのテキスト色 */
        margin-left: 20px;
    }

    body{
        padding-top: 120px;
    }

    #delete {
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;

        font-size: 20px;
        color: white;
        background-color: red;
        border-radius: 10px;
        padding: 10px 30px;
        margin: 5px;
        border: solid 0.5px;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);

    }

    #delete:hover{
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;

        font-size: 20px;
        color: black;
        background-color: white;
        border-radius: 10px;
        padding: 10px 30px;
        margin: 5px;
        border: solid 0.5px;
    }

    #cancel {
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;

        font-size: 20px;
        color:white;
        background-color: skyblue;
        border-radius: 10px;
        padding: 10px 30px;
        margin: 5px;
        border: solid 0.5px;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);

    }

    #cancel:hover {
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;

        font-size: 20px;
        color: black;
        background-color: white;
        border-radius: 10px;
        padding: 10px 30px;
        margin: 5px;
        border: solid 0.5px;
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
    <div class="page-right"><a href="member.php">トップページ</a>-><a href="delete_pre.php">パスワード認証</a>-><a>退会確認画面</a><div>
</header>

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
    $user_name = $_SESSION['login_name'];
    $user_id = $_SESSION['login_ID'];

    echo $user_id.' '.$user_name;

    //$current_date = ;
    $thirty_days_ago = strtotime('+30 days',  strtotime(date('Y-m-d')));

?>

    <!-- <p>認証成功</p> -->

    <div align=center>
    <p><?=$user_id?> <?=$user_name?>さん</p>
    <h1>本当に退会しますか？</h1>
    <h2>アカウントから退会しても、30日間はあなたのアカウントの情報は保存されていて、復活が可能です。</h2>
    <p style="color:red; font-size:17px;">アカウント復活の有効期限：<?=date('Y-m-d',$thirty_days_ago)?></p>
    <form  method='post' accept-charset="UTF-8">
        <input type=submit name="delete" id=delete value="退会">
        <input type=submit name="cancel" id=cancel value="キャンセル">
    </form>
    </div>

<?php

    $delete = filter_input(INPUT_POST, "delete");
    $cancel = filter_input(INPUT_POST, "cancel");

    if (isset($delete)) {

        try {

       $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");


        //おされた人のデータとってくる
        $sql = $db -> query("SELECT userID,name,birthday,email,tel,pass FROM member WHERE userID = '$user_id'");
        $resister = $sql->fetch();

        // echo $resister['tel'];
        // echo $resister['pass'];



        $stmt = $db->prepare("INSERT INTO アカウント削除メンバー (userID, name, birthday, email, tel, password,削除日) VALUES (:userID, :name,:birthday, :email,:tel,:pass,:delete_day)");

        // パラメータに値をバインドする
        $stmt->bindParam(':userID', $resister['userID']);
        $stmt->bindParam(':name', $resister['name']);
        $stmt->bindParam(':birthday', $resister['birthday']);
        $stmt->bindParam(':email', $resister['email']);
        $stmt->bindValue(':tel', $resister['tel']);
        $stmt->bindValue(':pass', $resister['pass']);
        $stmt->bindValue(':delete_day', date('Y-m-d'));

        echo "おされた";
        


        // クエリを実行する
        $count = $stmt->execute();



        if ($count) { //登録できたら   
            $con = $db->exec("DELETE FROM member WHERE userID='$user_id'");
            if($con){
                echo '<script> alert("退会完了");</script>';
                // echo '<script>window.location.href = "delete_comp.php?data=' . urlencode($user_id).'";</script>';

                header("Location: delete_comp.php?data=" . urlencode($user_id));
                exit();
                // echo "<h2>退会完了</h2>";
                // echo "<a href='login.php'>ログインはこちら</a>";
            }
        } else {
            echo "<h2>登録できませんでした。</h2>";
        }

    } catch (Exception $e) {
        echo "<div>" .$e->getMessage() . "</div>";
    }
    
    


    }

    if (isset($cancel)) {
        header("Location: member.php");
        return;

        // print '<form>';
        // print '<input type="button" onclick="history.back()" value="戻る">';
        // print '</form>';
    }



    ?>
</body>

</html>