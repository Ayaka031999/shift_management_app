<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アカウント削除完了</title>
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
    <div class="page-right"><a href="member.php">トップページ</a>-><a href="delete_pre.php">パスワード認証</a>-><a href="delete_account.pfp">退会確認画面</a>-><a>退会手続き完了画面</a><div>
</header>


<body>
        <?php



        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        require 'vendor/autoload.php';

        $user_id = $_GET['data'];
        //echo $user_id; 

       $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");


        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    

        $sql = $db->query("SELECT name,email FROM アカウント削除メンバー WHERE userID ='$user_id' ");
        $user_resister = $sql->fetch();

        $user_name = $user_resister['name'];
        $user_email = $user_resister['email'];
        $thirty_days_ago = strtotime('+30 days',  strtotime(date('Y-m-d')));


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
            $mail->Subject = 'シフト管理 退会手続き完了メール';
            $mail->Body    = '<h1>退会手続き完了のお知らせ</h1>
                          <h2>シフト管理 ' . $user_name . '様</h2>
                            退会手続きが完了いたしました。<br>
                            アカウントから退会しても、30日間は' . $user_name . '様のアカウントの情報は保存されていて、復活が可能です。<br>
                            復活する際はログインページから再びログインをお願いいたします。<br><br>
                            アカウント復活の有効期限：'.date('Y-m-d',$thirty_days_ago).'<br><br>

                            シフト管理をご利用いただき、誠にありがとうございました！<br>
                            またのご利用をお待ちしております！<br>
                          <p>
                           ＜お問い合わせはこちら＞<br>
                           シフト管理者メール:aprico908@gmail.com
                          </p>
                          ';
            // メールを送信する
            $mail->send();
        ?>
            <div align=center>

            <h1>退会手続きが完了しました！</h1>
            <p style="font-size:17px;">退会手続きが完了いたしました。<br>
                <!-- ご登録いただいていたメールアドレス[<?= $user_email ?>]宛てに<br>
                退会手続き完了のメールをお送りしましたのでご確認くださいませ。<br> -->
                退会後、30日間はアカウントの情報は保存されていて、復活が可能です。<br>
                復活する際はログインページから再びログインをお願いいたします。<br><br>
                アカウント復活の有効期限：<?=date('Y-m-d',$thirty_days_ago)?><br><br>
                シフト管理をご利用いただき、誠にありがとうございました！<br>
                またのご利用をお待ちしております！</p>
                <a href="login.php"><button class="topbtn">トップへ戻る</button></a>
            </div>

        <?php
        } catch (Exception $e) {
            echo "メールの送信中にエラーが発生しました: {$mail->ErrorInfo}";
        }
        ?>
</body>

</html>