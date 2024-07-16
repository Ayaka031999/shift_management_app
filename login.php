<?php  session_start();?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>シフト管理ツール</title>
    <link rel="stylesheet" href="CSS/style_login.css">
</head>
<style>
    #login {
        font-size: 25px;
        text-align: center;
        color: rgba(0, 0, 0, 0.705);

    }

    #login_btn {
   font-family: "游ゴシック", "Yu Gothic";
   font-weight: bold;

   font-size: 20px;
   padding-left: 4em;
   padding-right: 4em;
   padding-top: 1em;
   padding-bottom: 1em;
   margin-bottom: 10px;
   color: white;
   background-color: deepskyblue;
   border-radius: 10px;
   border-style: none;
   border-radius: 100em;
   box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);

 }

 #login_btn:hover{
  font-family: "游ゴシック", "Yu Gothic";
  font-weight: bold;

  font-size: 20px;
  padding-left: 4em;
  padding-right: 4em;
  padding-top: 1em;
  padding-bottom: 1em;
  margin-bottom: 10px;
  color: deepskyblue;
  background-color: white;
  border-radius: 10px;
  border: solid 0.5px ;
  border-radius: 100em;
  box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);

}




 #entry_btn {
  font-family: "游ゴシック", "Yu Gothic";
  font-weight: bold;

   font-size: 20px;
   padding-left: 4em;
   padding-right: 4em;
   padding-top: 1em;
   padding-bottom: 1em;
   margin-top:10px;
   color: white;
   background-color: darkseagreen;
   border-radius: 100em;
   border-style: none;
   box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);

 }


 #entry_btn:hover {
  font-family: "游ゴシック", "Yu Gothic";
  font-weight: bold;

   font-size: 20px;
   padding-left: 4em;
   padding-right: 4em;
   padding-top: 1em;
   padding-bottom: 1em;
   margin-top:10px;
   color: darkseagreen;
   background-color: white;
   border-radius: 100em;
   border: solid 0.5px ;
   box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);

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

    header h1 {
        color: rgba(0, 0, 0, 0.705);
        /* メニューのテキスト色 */
        margin-left: 20px;
    }

    h1{
        color: rgba(0, 0, 0, 0.705);
    }

    body {
        padding-top: 100px;
        text-align: center;
        margin: 0px;
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

    .yesbtn:hover{
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;
        font-size: 17px;
        color: rgba(0, 0, 0, 0.76);
        border: solid 0.5px;
        border-radius: 30px;
        background-color: white;
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

    .nobtn:hover{
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

</style>
<header>
    <h1>シフト管理</h1>
</header>


<body>
    <?php

    //ログイン状態の場合ログイン後のページにリダイレクト
    // if(isset($_SESSION["login"])) {
    //     session_regenerate_id(TRUE);
    //     header("Location: member.php");
    //     exit();
    // }

    // if (session_status() == PHP_SESSION_NONE) {
    //     session_start();
    // }

    // //セッションに保存されているIDを出力
    // if (isset($_SESSION["login_name"])) {
    //     // $_SESSION = array();

    //     // session_destroy();

    //     echo "ログインされているユーザーIDは: " . $_SESSION["login_name"];
    // } else {
    //     echo "ログインされていません。";
    // }


    ?>




    <div align=center id="login">
        <form method="post" accept-charset="UTF-8">
            <h2 align=center>ログイン画面</h2>
            <label>ユーザーID</label>
            <input id="userID" type="text" name="userID" required /><br><br>

            <label>パスワード</label>
            <input id=password type="password" name="password" required /><br><br>
            <input type="submit" name="login" id=login_btn method="post" value="ログイン"><br>
            <a style="font-size:17px; padding-top:15px; padding-bottom:15px;" href=passloss.php>パスワードをお忘れの方はこちら</a>
            <br>
            <button type="submit" id=entry_btn onclick="location.href='./entry.php'">新規登録</button>

        </form>
    </div>

    <?php

    $login = filter_input(INPUT_POST, "login");

    if (isset($login)) {

        try {
              $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");




            $userID = (int)filter_input(INPUT_POST, "userID");
            $password = filter_input(INPUT_POST, "password");

            //ユーザー名、パスワードが入力されていなかったら
            if (!$userID) {
                $alert = "<script type='text/javascript'>alert('ユーザーIDとパスワードを入力してください。');</script>";
                echo $alert;
            }

            if (!$password) {
                $alert = "<script type='text/javascript'>alert('ユーザーIDとパスワードを入力してください。');</script>";
                echo $alert;
            }

            //入力されているから、memberテーブルにいるか検索
            if ($userID && $password) {
                $sql = $db->query("SELECT pass,name,admin_check FROM member WHERE userID = '$userID'");
                $resister = $sql->fetch();


                if (!empty($resister)) {
                    // echo $resister['pass'];

                    $in_pass = $resister['pass'];
                    $check_delete =  false;
                } else {
                    $delete_sql = $db->query("SELECT * FROM アカウント削除メンバー WHERE userID = '$userID'");
                    $delete_resister = $delete_sql->fetch();

                    $delete_date = strtotime($delete_resister['削除日']);
                    $current_date = strtotime(date('Y-m-d'));
                    $thirty_days_ago = strtotime('+30 days', $delete_date);

                    if ($thirty_days_ago < $current_date ) {
                        $delete_sql = "DELETE FROM アカウント削除メンバー WHERE userID = '$userID'";
                        $con = $db->exec($delete_sql);

                        if ($con) {
                            $alert = "<script type='text/javascript'>alert('このアカウントは既に削除してから３０日以上経過しています。新規登録しなおしてください。');</script>";
                            echo $alert;
                            return;
                        }
                    } else {
                        // echo date('Y-m-d',$delete_date) . '~';
                        // echo date('Y-m-d', $thirty_days_ago);
                    }


                    $in_pass = $delete_resister['password'];

                    $check_delete =  true;
                    // echo '削除';
                    // if(password_verify($password, $aa_pass)){
                    //    
                    // }else{
                    //     $alert = "<script type='text/javascript'>alert('認証できません。正しいユーザーIDとパスワードを入力してください。');</script>";
                    //     echo $alert;
                    // } 
                }

                // echo $password;
                // echo $in_pass;

                // if (password_verify($password, $in_pass)) {
                //     echo '認証成功';
                // }



                //パスワード認証処理
                if (!empty($in_pass) &&  password_verify($password, $in_pass)) {
                    // echo '<p>認証成功</p>';


                    if ($check_delete) {
                        $name = $delete_resister['name'];
                        //フォームを見えなくする
                        echo '<script>document.getElementById("login").style.display = "none";</script>';

                        // アカウントが削除されている場合の処理 //
                        // ここでアカウントを復活させるかユーザーに確認する処理を行う
                        echo '<div align=center>
                                <form method="post" action="end_entry.php" >
                                    <h2>'.$delete_resister['userID'].' '.$delete_resister['name'].'さん</h2>
                                    <h1>アカウントが削除されています。復活しますか？</h1>
                                    <p>アカウントを'.date('Y-m-d',$delete_date).'に削除しました。間違って削除した場合、<br>
                                    '.date('Y-m-d', $thirty_days_ago).'以降はアカウントを復活させることができなくなります。<br>
                                    「復活させる」をクリックすると、アカウント削除プロセスが停止されて、アカウントを復活できます。
                                    </p>
                                    <input type="hidden" name="userID" value="' . htmlspecialchars($delete_resister['userID']) . '">
                                    <input type="hidden" name="name" value="' . htmlspecialchars($delete_resister['name']) . '">
                                    <input type="hidden" name="birthday" value="' . htmlspecialchars($delete_resister['birthday']) . '">
                                    <input type="hidden" name="email" value="' . htmlspecialchars($delete_resister['email']) . '">
                                    <input type="hidden" name="tel" value="' . htmlspecialchars($delete_resister['tel']) . '">
                                    <input type="hidden" name="password" value="' . htmlspecialchars($delete_resister['password']) . '">
                                    <input type="submit" class="yesbtn" name="yes" value="復活させる">
                                    <button class="nobtn" onclick="window.location.href=\'login.php\'">キャンセル</button>

                                </form>';

                              echo'</div>';


                    // if(isset($_POST["yes"])){
                    //     $alert = "<script type='text/javascript'>alert('おされた');</script>";
                    //     echo $alert;

                    // }

                /*        if (isset($_POST['yes'])) {

                            $alert = "<script type='text/javascript'>alert('おされた');</script>";
                            echo $alert;
        
                            $stmt = $db->prepare("INSERT INTO member(userID, name, birthday, email, tel, pass) VALUES (:userID, :name, :birthday, :email, :tel, :pass)");

                            $stmt->bindParam(':userID', $_POST['userID']);
                            $stmt->bindParam(':name', $_POST['name']);
                            $stmt->bindParam(':birthday', $_POST['birthday']);
                            $stmt->bindParam(':email', $_POST['email']);
                            $stmt->bindValue(':tel', $_POST['tel']);
                            $stmt->bindValue(':pass', $_POST['password']);

                            // クエリを実行する
                            $count = $stmt->execute();


                            if ($count) { //通常のメンバー表に登録できたら 

                                //アカウント削除メンバー表からは削除
                                $sql = "DELETE FROM `アカウント削除メンバー` WHERE userID='$userID'";
                                $decon = $db->query($sql);

                                if ($decon) { //アカウント削除メンバーからも削除できたら
                                    session_regenerate_id(TRUE); //セッションidを再発行
                                    $_SESSION["login_name"] = $name; //セッションにログイン情報を登録
                                    $_SESSION["login_ID"] = $userID; //セッションにログイン情報を登録

                                    header('Location:member.php');
                                    return;
                                }
                            }
                        }*/
                    } else {
                        // アカウントが削除されていない場合の処理
                        // ここで通常のログイン処理を行うなどの処理を行う
                        echo "ログイン成功";
                        $name =  $resister['name'];

                        $admin_check = $resister['admin_check'];


                        if (strcmp($admin_check, "admin") == 0) {
                            echo "<p>$name</p>";
                            print '<form method="post" action="member.php" accept-charset="UTF-8">';
                            print '<input type="hidden" name="name" method="post" action="member.php" value="' . $name . '">';
                            print '</form>';

                            session_regenerate_id(TRUE); //セッションidを再発行
                            $_SESSION["login_name"] = $name; //セッションにログイン情報を登録
                            $_SESSION["login_ID"] = $userID; //セッションにログイン情報を登録

                            echo '<script>window.location.href = "./kanri/kanri_top.php";</script>';


                            // header('Location: .\kanri\kanri_top.php'); //..\kanri\kanri_check.php
                            // return;
                            // //break;
                        }



                        // echo "<p>$name</p>";
                        // print '<form method="post" action="member.php" accept-charset="UTF-8">';
                        // print '<input type="hidden" name="name" method="post" action="member.php" value="' . $name . '">';
                        // print '</form>';

                        
                        session_regenerate_id(TRUE); //セッションidを再発行
                        $_SESSION["login_name"] = $name; //セッションにログイン情報を登録
                        $_SESSION["login_ID"] = $userID; //セッションにログイン情報を登録

                        echo '<script>window.location.href = "member.php";</script>';

                        // header('Location:member.php');
                        // return;
                    }
                } else {
                    $alert = "<script type='text/javascript'>alert('認証できません。正しいユーザーIDとパスワードを入力してください。');</script>";
                    echo $alert;
                    // echo '認証不可';
                }
            }
        } catch (PDOException $e) {
            echo "<div>" .$e->getMessage() . "</div>";
        }
    }


    ?>

    <!-- 
    <p class="test">テスト</p>
    <picture>
        <source media="(max-width: 480px)" srcset="sp.jpg"> 
        <source media="(max-width: 768px)" srcset="ipad.jpeg">
        <img src="test.png" alt=""> 
    </picture> -->
</body>

</html>