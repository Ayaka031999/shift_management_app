<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .back-btn-label {
            position: fixed;
            bottom: 60px;
            /* ボタンをビューポートの下端からの距離を指定 */
            left: 30px;
            /* ボタンをビューポートの右端からの距離を指定 */
            z-index: 999;
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
            bottom: 10px;
            /* ボタンをビューポートの下端からの距離を指定 */
            left: 20px;
            /* ボタンをビューポートの右端からの距離を指定 */
            z-index: 999;
            /* ボタンが他の要素の上に表示されるように設定 */
        }
    </style>



    <?php
    //セッションを使うことを宣言
    session_start();


    //ログインされていない場合は強制的にログインページにリダイレクト
    if (!isset($_SESSION["login_name"])) {
        header("Location: login.php");
        exit();
    }

    //ログインされている場合は表示用メッセージを編集
    $name = $_SESSION['login_name'];
    $userID =  $_SESSION['login_ID'];

    echo $userID;
    echo "{$name}さん";

    $currentID = 1;

    echo '<label class="back-btn-label">戻る</label>';
    if ($userID === 123456 && strcmp($name, 'admin') === 0) {
        echo     '<a href="../kanri/kanri_top.php" title="トップへ戻る"><img src="../画像/return.png" class="back-btn"></a>';
    } else {
        echo     '<a href="../member.php" title="トップへ戻る"><img src="../画像/return.png" class="back-btn"></a>';
    }

    // echo shell_exec('export LANG=ja_JP.UTF-8;cd');

    // echo getcwd() . "\n";

    // echo exec('php server.php');

    // サーバーを起動するディレクトリに移動
    // chdir(__DIR__);

    // PHPのビルトインウェブサーバーを起動するコマンドを生成
    // $command = sprintf('php server.php');

    // コマンドを実行してサーバーを起動
    // shell_exec('php server.php');


    // D:\xampp\htdocs\事例研究\realtime_chat\server.php
 

    ?>





    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realtime Chat</title>
    <style>
        body {
            font-family: "游ゴシック", "Yu Gothic";
            font-weight: bold;
        }

        #chat-messages {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            max-height: 450px;
            overflow-y: scroll;
            overflow: scroll;
            background-color: aliceblue;

            /* margin: 0 auto 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 0 auto 15px;
            display: flex;
            flex-direction: column;*/
            /* 縦に並べる */
            /* align-items: flex-start; */
            /* 左寄せにする */
            /* overflow-y: scroll; */
            /* overflow: scroll;  */
            /* overflow-y: auto; */
        }

        /* #comp-messages {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            max-height: 300px;
            overflow-y: auto;
        } */

        .message {
            margin-top: 30px;
            margin-bottom: 30px;
            padding: 5px 10px;

            max-width: 60%;
            border-radius: 10px;
            /* background: #0096e5; */
            position: relative;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        .sent {
            margin-top: 30px;
            background-color: #DCF8C6;
            align-self: flex-end;
            margin-left: auto;
            margin-right: 100px;
            /* 右側に寄せる */
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .received {
            margin-bottom: 30px;
            background-color: #E5E7E9;
            align-self: flex-start;
            margin-right: auto;
            margin-left: 100px;
            /* 左側に寄せる */
            word-wrap: break-word;
            overflow-wrap: break-word;

        }


        .sent::after {
            content: "";
            border: 10px solid transparent;
            border-left: 20px solid #DCF8C6;
            position: absolute;
            right: -30px;
            top: 50%;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
        }

        .received::before {
            /*左からふきだし*/
            /* top: 50%;
            left: -10px;
            border-color: transparent transparent transparent #E5E7E9; */

            content: "";
            border: 10px solid transparent;
            border-right: 20px solid #E5E7E9;
            position: absolute;
            left: -30px;
            /* margin-left: 30px; */
            top: 50%;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);

        }

        .rounded-image {
            border-radius: 50%;
            /* 丸みを持たせる */
            overflow: hidden;
            /* はみ出た部分を隠す */
            width: 50px;
            /* 画像のサイズを調整 */
            height: 50px;
            /* align-self: flex-end; */
            /* margin-left: auto;
            margin-right: 30px; */
        }

        .sent-icon-Div {
            float: right;
        }

        .received-icon-Div {
            float: left;
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

        .message_send{
            font-family: "游ゴシック", "Yu Gothic";
            font-weight: bold;
            font-size: 17px;
            border: solid 0.5px;
            border-radius: 30px;
            padding: 5px 10px;
            width:1000px;
        }

        .send_btn{
            background-color: #fff;
            border: none;
            outline: none;
        }

        
    </style>
</head>

<body>

    <div id="chat-messages"></div><!--メッセージ表示領域-->
    <div align=right>
        <input type="hidden" id="message-userID" value="<?php echo $userID . ':' . $name; ?>" readonly>
        <input type="text" id="message-input" class="message_send" name=message placeholder="Enter your message..." required />
        <button type="button" id="send" onclick="sendMessage()" value="送信" class="send_btn"><img src="../画像/send.png" style="width: 31px; height:31px;"></button>
        <input type="hidden" id="userID" value="<?= $userID ?>">
    </div>
    <!-- </form> -->

    <p align=right id="realtime"></p><!--現在時間表示-->


    <script>
        //8080番ポートに接続要求
        const socket = new WebSocket('ws://192.168.46.10:8080');
        let messageIdCounter = 1;

        socket.addEventListener('open', function(event) {
            console.log('WebSocket 接続が確立されました。');
            // fetch('/iconData')
            // .then(response => response.json())
            // .then(data => {
            //     // 取得した画像データをWebSocketを介してサーバーに送信
            //     socket.send(JSON.stringify({ type: 'iconData', data: data }));
            // })
            // .catch(error => console.error('Error fetching icon data:', error));
        });

        socket.addEventListener('close', function(event) {
            console.log('WebSocket 接続が閉じられました。');
        });

        socket.addEventListener('error', function(event) {
            console.error('WebSocket 接続中にエラーが発生しました。');
        });


        // const imgData = <?php //echo json_encode($img_data); 
                            ?>;
        // userIDを取得
        const userID = document.getElementById('userID').value;


        //アイコン画像生成
        // function CreateIcon(userID) {
        //     let icon = document.createElement('img');
        //     icon.width = '50px';
        //     icon.height = '50px';
        //     icon.alt = 'User Icon';
        //     icon.classList.add('rounded-image');

        //     // userIDに基づいて画像を取得
        //     const imageData = imgData[userID];

        //     if (imageData) {
        //         // 画像が存在する場合
        //         icon.src = 'data:image/jpeg;base64,' + imageData;
        //     } else {
        //         // 画像が存在しない場合はデフォルトの画像を設定
        //         icon.src = '画像\icon.png';
        //     }

        //     return icon;
        // }

        //メッセージ受信
        socket.addEventListener('message', function(event) {
            const data = JSON.parse(event.data);

            const imageData = data.icon;


            console.log(imageData);
            const messages = data.messages; // メッセージの配列

            const messageDiv = document.createElement('div');

            messages.forEach(function(message) {
                // 新しいメッセージ要素を作成
                const messageDiv = document.createElement('div');
                messageDiv.textContent = message.userID + ':' + message.name + '(' + message.date + ')\n' + message.message;


                const messageWidth = messageDiv.textContent.length * 10;

                messageDiv.style.width = messageWidth + 'px';

                const icon = document.createElement('img');
                icon.width = '50px';
                icon.height = '50px';
                icon.alt = 'User Icon';
                icon.classList.add('rounded-image');

                icon.src = 'data:image/jpeg;base64,' + imageData;

                const iconDiv = document.createElement('div');

                iconDiv.appendChild(icon);



                if (message.userID == userID) {
                    messageDiv.classList.add('message', 'sent');
                    iconDiv.classList.add('sent-icon-Div');
                } else {
                    messageDiv.classList.add('message', 'received');
                    iconDiv.classList.add('received-icon-Div');
                }

                document.getElementById('chat-messages').appendChild(iconDiv);
                document.getElementById('chat-messages').appendChild(messageDiv);
                scrollToBottom(); // メッセージを受信したら最下部にスクロール
            });

            // messageDiv.textContent = data.messages.userID + ':' + data.messages.name + '(' + data.messages.date + ')\n' + data.messages.message;



            // let chatArea = document.getElementById('chat-messages');
            // chatArea.scrollTo(0, chatArea.scrollHeight);
        });

        //画面最下部までスクロールメソッド
        function scrollToBottom() {
            let chatArea = document.getElementById('chat-messages');
            chatArea.scrollTop = chatArea.scrollHeight;
        }

        // function messageAjust(){
        //             // メッセージを表示する要素を取得
        // const messageContainer = document.getElementsByClassName('message');
        // // メッセージの長さに基づいて要素の幅を設定
        // // メッセージの長さに応じて幅が自動的に調整されます
        // messageContainer.textContent = message;

        // }


        //メッセージ送信メソッド
        function sendMessage() {
            const message = document.getElementById('message-input').value;

            function getCurrentTime() {
                let nowTime = new Date();
                let year = nowTime.getFullYear();
                let mon = nowTime.getMonth() + 1;
                let day = nowTime.getDate();
                let nowHour = nowTime.getHours();
                let nowMin = nowTime.getMinutes();
                let nowSec = nowTime.getSeconds();

                return year + "-" + numChan(mon) + "-" + numChan(day) + " " + numChan(nowHour) + ":" + numChan(nowMin) + ":" + numChan(nowSec);
            }

            const currentTime = getCurrentTime();

            const subInfo = document.getElementById('message-userID').value;

            var messageData = {
                userID: '<?= $userID ?>',
                name: '<?= $name ?>',
                message: message,
                date: currentTime,
                currentID: 1
            };

            var jsonData = JSON.stringify(messageData);

            const messageDiv = document.createElement('div');
            messageDiv.textContent = subInfo + "(" + currentTime + ")\n" + message;
            const messageWidth = messageDiv.textContent.length * 10;

            messageDiv.style.width = messageWidth + 'px';


            // CreateIcon関数を呼び出してアイコンを作成
            // const icon = CreateIcon(userID);

            // const iconDiv = document.createElement('div');

            // iconDiv.classList.add('sent-icon-Div');

            // iconDiv.appendChild(icon);

            messageDiv.classList.add('message', 'sent');
            // document.getElementById('chat-messages').appendChild(iconDiv);
            document.getElementById('chat-messages').appendChild(messageDiv);
            socket.send(jsonData);
            scrollToBottom();
            messageIdCounter++;
            messageInput.value = '';
        }

        //時計表示メソッド
        function showClock() {
            let nowTime = new Date();
            let year = nowTime.getFullYear();
            let mon = nowTime.getMonth() + 1;
            let day = nowTime.getDate();
            let nowHour = nowTime.getHours();
            let nowMin = nowTime.getMinutes();
            let nowSec = nowTime.getSeconds();

            let msg = "今日は" + year + "年" + numChan(mon) + "月" + numChan(day) + "日 " + "現在時刻：" + numChan(nowHour) + ":" + numChan(nowMin) + ":" + numChan(nowSec);
            document.getElementById("realtime").innerHTML = msg;
        }
        setInterval('showClock()', 1000);


        function numChan(num) {
            num = (num < 10 ? '0' : '') + num;
            return num;
        }




        const form = document.getElementById("message-input")
        const button = document.getElementById("send")
        button.disabled = true;

        form.addEventListener("input", update)
        form.addEventListener("change", update)

        //文字を入力されたら送信ボタン有効メソッド
        function update() {
            const isRequired = form.checkValidity()

            if (isRequired) {
                button.disabled = false;
                return
            } else {
                button.disabled = true;
            }
        }
    </script>


</body>

</html>