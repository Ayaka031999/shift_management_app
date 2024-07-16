
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

    header h1 {
        color: rgba(0, 0, 0, 0.705);
        /* メニューのテキスト色 */
        margin-left: 20px;
    }

    h1{
        color: rgba(0, 0, 0, 0.705);
    }

    body {
        padding-top: 150px;
        text-align: center;
    }

    .yesbtn {
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;
        color: rgba(0, 0, 0, 0.76);
        border: solid 0.5px;
        border-radius: 30px;
        background-color: #fff0f5;
        padding: 10px 30px;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        margin-right: 10px;
    }

    .nobtn{
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;
        color: rgba(0, 0, 0, 0.76);
        border: solid 0.5px;
        border-radius: 30px;
        background-color: #e0ffff;
        padding: 10px 30px;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        margin-left: 10px;

    }


</style>
<header> <!-- onclick="openSubWindow()" -->
    <h1>シフト管理</h1>
</header>




<body>
    

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

date_default_timezone_set("Asia/Tokyo");

// ユーザーが入力したメールアドレス
$user_email = $_POST['email'];




$db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// プレースホルダーを使用してSQLクエリを実行する
$sql = $db->prepare("SELECT name FROM member WHERE email = :email");
$sql->execute(array(':email' => $user_email));
$user = $sql->fetch(PDO::FETCH_ASSOC);

$del_sql = $db->prepare("SELECT * FROM アカウント削除メンバー WHERE email = :email");
$del_sql->execute(array(':email' => $user_email));
$del_user = $del_sql->fetch(PDO::FETCH_ASSOC);


//メールに登録があれば
if (!empty($user)) {

    try {

    $user_name = $user['name'];



    // トークンの生成 意外と桁あった
    $token = bin2hex(random_bytes(16)); // 16バイトのランダムなバイト列を16進数文字列に変換してトークンを生成

    // 有効期限の設定（30分後）
    $expiration_time =  date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) + 1800); // 現在のUnixタイムスタンプに1時間を加える
    echo date("Y-m-d H:i:s");

    // トークンと有効期限をデータベースに保存
    $update_token_sql = $db->prepare("UPDATE member SET reset_token = :token, token_expiration = :expiration WHERE email = :email");
    $update_token_sql->execute(array(':token' => $token, ':expiration' => $expiration_time, ':email' => $user_email));

    // PHPMailerのインスタンスを作成します。
    $mail = new PHPMailer(true); // trueを渡すことで例外を有効にします。

    
        // SMTPサーバーの設定
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host = 'smtp.gmail.com'; // GmailのSMTPサーバー
        $mail->SMTPAuth = true;
        $mail->Username = 'aprico908@gmail.com'; // Gmailのメールアドレス
        $mail->Password = 'pvgk wvvh bpma rcem'; // アプリパスワード
        $mail->SMTPSecure = 'tls'; // SSLまたはTLSを使用します。sslまたはtlsを設定します。
        $mail->Port = 587; // GmailのSMTPポート番号

        // 送信元と送信先の設定
        $mail->setFrom('aprico908@gmail.com', 'シフト管理'); // 送信元のメールアドレスと名前
        $mail->addAddress($user_email); // 送信先のメールアドレスと名前, '長久 綾花'


        // メールの内容
        $mail->isHTML(true); // HTML形式のメールを送信する場合はtrueに設定します。
        $mail->Subject = 'シフト管理 パスワード再設定メール';
        $mail->Body    = '<h1>パスワード再設定のお知らせ</h1>
                        <h2>シフト管理 ' . $user_name . '様</h2>
                        パスワード再設定のお申込みをいただきました。<br>
                        以下のリンクから再設定を行ってください。<br>
                        有効期限：'.$expiration_time.'<br>
                        ※リンクの有効期限は３０分以内です。有効期限を過ぎていましたら、お手数ですがもう一度再設定メールを送信してください。<br>
                        ☞<a href="192.168.46.10/pass_check.php?token=' . $token . '">パスワード再設定はこちら</a>
                        <br><br>
                        <p>
                        ＜お問い合わせはこちら＞<br>
                        シフト管理者メール:aprico908@gmail.com
                        </p>
                      ';
        // メールを送信する
        $mail->send();
    ?>

        <h1 >メールをご確認ください。</h1>
        <p >パスワード再設定メールを、<?= $user_email?>にお送りしました。<br>
        お送りしたメールの内容にそってパスワード再設定をお願いします。<br>
        なお、お送りしたパスワードの再設定有効期限はただいまから<span style="font-size: larger; color: red;">30分以内</span>ですので、ご注意ください。<br><br>

        有効期限：<?=$expiration_time?><br>

        </p>
        <a href="login.php" style="display: block; text-align: center;">戻る</a>


 

        <?php
    } catch (Exception $e) {
        echo "<div>" .$e->getMessage() . "</div>";
      //  echo "メールの送信中にエラーが発生しました: {$mail->ErrorInfo}";
    }
    
    ?>




<?php


} elseif($del_user){ //アカウント復活させたいけどパスワード忘れた

    $user_name = $del_user['name'];
    $user_id = $del_user['userID'];

?>

    <form method="post" id="restartform">
    <h1>アカウントが削除されています。復活しますか？</h1>
        <input type="hidden" name="userID" value="<?=htmlspecialchars($del_user['userID'])?>">
        <input type="hidden" name="name" value="<?=htmlspecialchars($del_user['name'])?>">
        <input type="hidden" name="birthday" value="<?=htmlspecialchars($del_user['birthday'])?>">
        <input type="hidden" name="email" value="<?=htmlspecialchars($del_user['email'])?>">
        <input type="hidden" name="tel" value="<?=htmlspecialchars($del_user['tel'])?>">
        <input type="hidden" name="password" value="<?=htmlspecialchars($del_user['password'])?>">
        <input type="submit" name="restart" value="はい" class="yesbtn">
        <button class="nobtn" onclick="window.location.href='login.php'">いいえ</button>
    </form>

<?php
    if (isset($_POST['restart'])) {
    echo '<script>document.getElementById("restartform").style.display = "none"</script>';

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
            $sql = "DELETE FROM `アカウント削除メンバー` WHERE userID='$user_id'";
            $decon = $db->query($sql);

            if ($decon) { //アカウント削除メンバーからも削除できたら

                // トークンの生成
                $token = bin2hex(random_bytes(16)); // 16バイトのランダムなバイト列を16進数文字列に変換してトークンを生成

                // 有効期限の設定（30分後）
                $expiration_time =  date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) + 1800); // 現在のUnixタイムスタンプに1時間を加える

                // トークンと有効期限をデータベースに保存
                $update_token_sql = $db->prepare("UPDATE member SET reset_token = :token, token_expiration = :expiration WHERE email = :email");
                $update_token_sql->execute(array(':token' => $token, ':expiration' => $expiration_time, ':email' => $user_email));


                // PHPMailerのインスタンスを作成します。
                $mail = new PHPMailer(true); // trueを渡すことで例外を有効にします。

                try {
                    // SMTPサーバーの設定
                    $mail->isSMTP();
                    $mail->CharSet = 'UTF-8';
                    $mail->Host = 'smtp.gmail.com'; // GmailのSMTPサーバー
                    $mail->SMTPAuth = true;
                    $mail->Username = 'aprico908@gmail.com'; // Gmailのメールアドレス
                    $mail->Password = 'pvgk wvvh bpma rcem'; // アプリパスワード
                    $mail->SMTPSecure = 'tls'; // SSLまたはTLSを使用します。sslまたはtlsを設定します。
                    $mail->Port = 587; // GmailのSMTPポート番号

                    // 送信元と送信先の設定
                    $mail->setFrom('aprico908@gmail.com', 'シフト管理'); // 送信元のメールアドレスと名前
                    $mail->addAddress($user_email); // 送信先のメールアドレスと名前, '長久 綾花'

                    // メールの内容
                    $mail->isHTML(true); // HTML形式のメールを送信する場合はtrueに設定します。
                    $mail->Subject = 'シフト管理 アカウント復活、パスワード再設定メール';
                    $mail->Body    = '<h1>アカウント復活、パスワード再設定のお知らせ</h1>
                                <h2>シフト管理 ' . $user_name . '様</h2>
                                アカウントを復活し、パスワード再設定のお申込みをいただきました。<br>
                                以下のリンクから再設定を行ってください。<br>
                                有効期限：'.$expiration_time.'<br>
                                ※リンクの有効期限は３０分以内です。有効期限を過ぎていましたら、お手数ですがもう一度再設定メールを送信してください。<br>
                                ☞<a href="192.168.46.10/pass_check.php?token=' . $token . '">パスワード再設定はこちら</a>
                                <br><br>
                                <p>
                                ＜お問い合わせはこちら＞<br>
                                シフト管理者メール:aprico908@gmail.com
                                </p>
                                ';
                    // メールを送信する
                    $mail->send();
                    echo '<h1 align=center>メールをご確認ください。</h1>
                    <p align=center>パスワード再設定メールを、' . $user_email . 'にお送りしました。<br>
                    お送りしたメールの内容にそってパスワード再設定をお願いします。<br>
                    なお、お送りしたパスワードの再設定有効期限はただいまから<span style="font-size: larger; color: red;">30分以内</span>ですので、ご注意ください。
                    有効期限：'.$expiration_time.'<br>
                    </p>
                    <a href="login.php"><button class="topbtn">戻る</button></a>
                    <style>
                    .topbtn {
                        font-family: "游ゴシック", "Yu Gothic";
                        font-weight: bold;
                        font-size: 15px;
                        color: rgba(0, 0, 0, 0.76);
                        border: solid 0.5px;
                        border-radius: 30px;
                        background-color: #fffacd;
                        padding: 10px 30px;
                        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
                        margin-top: 30px;
                    }
                    </style>
                    ';
                } catch (Exception $e) {
                    echo "メールの送信中にエラーが発生しました: {$mail->ErrorInfo}";
                }
            } else {
                echo 'データが二重登録されています';
            }
        }
    }
} else {
    echo 'このメールアドレスは登録されていません。詳しくは管理者に問い合わせてください。<br>';
    echo 'お問い合わせはこちら';
}
?>

</body>
</html>

