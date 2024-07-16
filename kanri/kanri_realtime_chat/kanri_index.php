<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    //セッションを使うことを宣言
    session_start();

    //ログインされていない場合は強制的にログインページにリダイレクト
    if (!isset($_SESSION['login_name'])) {
        header("Location: ../login.php");
        exit();
    }

    //ログインされている場合は表示用メッセージを編集
    $name = $_SESSION['login_name'];
    $userID = $_SESSION['login_ID'];


    if (strcmp($_SESSION['login_name'], "admin") != 0 || $_SESSION['login_ID'] != "123456") {
        header("Location: ../login.php");
        exit();
    }


    echo $userID;
    echo "{$name}さん";

    $currentID = 1;

   $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realtime Chat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        #chat-messages {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            max-height: 300px;
            overflow-y: auto;


            /* padding: 20px 10px;
            max-width: 700px;
            margin: 15px auto;
            text-align: right;
            font-size: 14px;
            background:rgb(170, 225, 235);
            scrollbar-width: none; */


        }

        .message {
            margin-bottom: 5px; 
            padding: 5px 10px;
            border-radius: 5px;
        }

        
        /* .sent::after { */
            /* content: "";
            position: absolute;
            top: 3px; 
            right: -19px;
            border: 8px solid transparent;
            border-left: 18px solid white;
            -webkit-transform: rotate(-35deg);
            transform: rotate(-35deg); */
        /* } */


        /* .sent { */
            /* background-color: #DCF8C6;
            align-self: flex-end; */


            /* display: inline-block;
            position: relative; 
            margin: 0 10px 0 0;
            padding: 8px;
            max-width: 250px;
            border-radius: 12px;
            background: white;
            font-size: 15px;
 */
        /* } */

        .sent{
            position:relative;
            width:250px;
            height:40px;
            background-color: #DCF8C6;
            padding:20px;
            text-align:left;
            color:#333333;
            border-radius:15px;
            -webkit-border-radius:15px;
            -moz-border-radius:15px;
        }
        .sent:after{
            border: solid transparent;
            content:'';
            height:0;
            width:0;
            pointer-events:none;
            position:absolute;
            border-color: rgba(230, 230, 230, 0);
            border-top-width:10px;
            border-bottom-width:10px;
            border-left-width:30px;
            border-right-width:30px;
            margin-top: -10px;
            border-left-color:#DCF8C6;
            left:100%;
            top:50%;
        }


        

        .received {
            background-color: #E5E7E9;
        }

        .reply-btn {
            margin-left: 10px;
            background-color: #3498DB;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <?php
        $sql='SELECT * from chat_tb ORDER BY date ASC';
        $stmt = $db->query($sql);
        $resister = $stmt->fetchAll();
    ?>

    <div id="chat-messages">
        <?php 
            foreach($resister as $result):
                if($result['userID']==$userID){
                    echo '<div class="message sent">'.$result['userID'].':'.$result['name'].'('.$result['date'].')'.$result['message'].'</div>';
                }else{
                    echo '<div class="message received">'.$result['userID'].':'.$result['name'].'('.$result['date'].')'.$result['message'].'</div>';
                }
            endforeach; 
        ?>
    </div><!--メッセージ表示領域-->

    <input type="text" id="message-userID" value="<?php echo $userID . ':' . $name; ?>" readonly>
    <input type="text" id="message-input" name=message placeholder="Enter your message...">
    <input type="submit" id="send"  onclick="sendMessage()" value="送信">
    <!-- </form> -->

    <p id="realtime"></p><!--現在時間表示-->


    <script>
        const socket = new WebSocket('ws://localhost:8080');
        let messageIdCounter = 1;

        socket.addEventListener('message', function(event) {
            const messageData = JSON.parse(event.data);
            const messageDiv = document.createElement('div');
            messageDiv.textContent = messageData.content;
            messageDiv.classList.add('message', 'received');
            messageDiv.dataset.messageId = messageData.id;
            // const replyBtn = document.createElement('button');
            // replyBtn.textContent = 'Reply';
            // replyBtn.classList.add('reply-btn');
            // replyBtn.addEventListener('click', function() {
            //     const messageId = messageDiv.dataset.messageId;
            //     const replyMessage = `Reply to message ${messageId}`;
            //     socket.send(JSON.stringify({ content: replyMessage, replyTo: messageId }));
            // });
            // messageDiv.appendChild(replyBtn);
            document.getElementById('chat-messages').appendChild(messageDiv);
            let chatArea = document.getElementById('chat-messages');
            chatArea.scrollTo(0, el.scrollHeight);

        });

        //メッセージを送ります
        function sendMessage(){
            const message = document.getElementById('message-input').value;

            function getCurrentTime() {
                // return new Date().toISOString().slice(0, 19).replace('T', ' ');
                let nowTime = new Date();
                let year = nowTime.getFullYear();
                let mon = nowTime.getMonth() + 1;
                let day = nowTime.getDate();
                let nowHour = nowTime.getHours();
                let nowMin = nowTime.getMinutes();
                let nowSec = nowTime.getSeconds();

                return year+"-"+mon+"-"+day+" "+nowHour+":"+nowMin+":"+nowSec;
            }

            const currentTime = getCurrentTime();; // 現在の時間

            const subInfo = document.getElementById('message-userID').value;

            // XMLHttpRequestを作成
            const xhr = new XMLHttpRequest();

            // POSTリクエストを準備
            xhr.open("POST", "index.php", true);

            // リクエストヘッダーを設定
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            // リクエストを送信
            xhr.send("message=" + encodeURIComponent(message) + "&time=" + encodeURIComponent(currentTime));

            let allmessage = subInfo + "(" + currentTime + ")\n" + message;

            const messageDiv = document.createElement('div');
            messageDiv.textContent = allmessage; //subinfo+"("+currentTime+")\n"+
            messageDiv.classList.add('message', 'sent');
            messageDiv.dataset.messageId = messageIdCounter;
            document.getElementById('chat-messages').appendChild(messageDiv); //表示領域に表示
            socket.send(JSON.stringify({
                content: allmessage,
                id: messageIdCounter
            })); //ソケットにおくる
            messageIdCounter++;
            messageInput.value = '';
        }

        function showClock() {
            let nowTime = new Date();
            let year = nowTime.getFullYear();
            let mon = nowTime.getMonth() + 1;
            let day = nowTime.getDate();
            let nowHour = nowTime.getHours();
            let nowMin = nowTime.getMinutes();
            let nowSec = nowTime.getSeconds();

            let msg = "今日は"+year+"年"+mon+"月"+day+"日 "+  "現在時刻："+ nowHour + ":" + nowMin + ":" + nowSec;
            document.getElementById("realtime").innerHTML = msg;
        }
        setInterval('showClock()', 1000);

        const el = document.getElementById('chat-messages');
        el.scrollTo(0, el.scrollHeight);

        //送信ボタンが押されたら最下部へスクロール
        let send = document.getElementById('send');
        send.addEventListener('click', function() {
            let chatArea = document.getElementById('chat-messages');
            chatArea.scrollTo(0, el.scrollHeight);
            // chatAreaHeight = chatArea.scrollHeight;
            // chatArea.scrollTop = chatAreaHeight;
        })

    </script>


    <?php

    if (isset($_POST['message'])) {
        // メッセージを受け取る
        $message = $_POST['message'];
        $date = $_POST['time'];

        $sql = 'INSERT INTO chat_tb(userID, name ,message, date,currentID) VALUES (:userID,:name,:message,:date,:currentID)';
        $stmt = $db->prepare($sql);

        //プリペアドステートメントにバインド
        $stmt->bindParam(':userID', $userID);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':date',  $date);
        $stmt->bindParam(':currentID', $currentID);

        //ステートメントを実行
        $con = $stmt->execute();

        if ($con) {
            echo "New record created successfully";
        } else {
            echo "Error";
        }
    } else {
        // メッセージが送信されていない場合のエラー処理を行う
        echo "メッセージが送信されていません";
    }


    ?>

</body>

</html>