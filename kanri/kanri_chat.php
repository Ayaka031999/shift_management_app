<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/chat.css">
    <title>Document</title>
</head>
<body>
<?php
        //セッションを使うことを宣言
        session_start();

        //ログインされていない場合は強制的にログインページにリダイレクト
        if (!isset($_SESSION["login_name"])){
            header("Location: login.php");
            exit();
        }
                
        //ログインされている場合は表示用メッセージを編集
        $myname = $_SESSION['login_name'];
        $num = $_SESSION['login_ID'];

        // if($message != "admin" || $num != "123456"){
        //     header("Location: ../login.php");
        //     exit();
        // }
        
                
        echo $num;
        echo "{$myname}さん";   
        
        $currentID=1;

        date_default_timezone_set('Asia/Tokyo');
?>

<div class="line-bc">
    <div class="mycomment">
        
   
<?php

    $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4","root","");
    $db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql='SELECT * from chat_tb ORDER BY date ASC';
    $stmt = $db->query($sql);
    $resister = $stmt->fetchAll();

    foreach($resister as $result):
        //echo $result['userID'].'<br>';
        echo '<br><p>';
        //echo '送信者:'.$result['name'].'  ';
        // echo $result['date'].'<br>';
        echo $result['message'].'<br>';
       // echo $result['currentID'].'<br>';
       echo ' </p><br>';
    endforeach; 
?>
       
    </div>
</div>

<div id="bms_send">
<form method=post>
    送信者：<?= $myname;?><br>
    メッセージ：<input  type=text id="bms_send_message"  name=message>
    <input type=hidden   name=currentID value=<?=$currentID?>>
<input type=submit id="bms_send_btn" name=commit  value="送信">
</form>

</div>

<?php
    $commit = filter_input(INPUT_POST, "commit");
    if(isset($commit)){

        $date = date("Y/m/d H:i:s"); 

        $message = filter_input(INPUT_POST, "message");
        // $date = filter_input(INPUT_POST, "date");
        $currentID = filter_input(INPUT_POST, "currentID");


        // $sql= 'SELECT * from chat_tb';

        // if()

        //ON DUPLICATE KEY UPDATE
        //   param1 = '0'
        //   , param2 = '0'
        //   , param3 = '0'

        $sql = 'INSERT INTO chat_tb(userID, name ,message, date,currentID) VALUES (:userID,:name,:message,:date,:currentID)';
                

        $stmt = $db->prepare($sql);

        //プリペアドステートメントにバインド
        $stmt->bindParam(':userID', $num);
        $stmt->bindParam(':name', $myname);
        $stmt->bindParam(':message', $message );
        $stmt->bindParam(':date',  $date );
        $stmt->bindParam(':currentID',$currentID );

        //ステートメントを実行
        $con = $stmt->execute();

        if($con){

            $alert = "<script type='text/javascript'>alert('登録完了');</script>";
            echo $alert;

            header("Location: kanri_chat.php");
            exit();

        }else{
            $alert = "<script type='text/javascript'>alert('登録できませんでした');</script>";
            echo $alert;
        }
    }
?>
</body>
</html>