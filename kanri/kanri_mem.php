<?php
//セッションを使うことを宣言
session_start();

//ログインされていない場合は強制的にログインページにリダイレクト
if (!isset($_SESSION['login_name'])) {
    header("Location: ../login.php");
    exit();
}

//ログインされている場合は表示用メッセージを編集
$message = $_SESSION['login_name'];
$num = $_SESSION['login_ID'];


if (strcmp($_SESSION['login_name'], "admin") != 0 || $_SESSION['login_ID'] != "123456") {
    header("Location: ../login.php");
    exit();
}

// echo $num;
// echo "{$message}さん"; 
$db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");



$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="CSS/mem.css">
    <title>Document</title>
</head>
<style>
    html {
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;
        margin: 0px;
    }


    header {
        /* position: fixed;  */
        width: 100%;
        top: 0;
        left: 0;
        background-color: #99d8fd;
        /* ヘッダーの背景色 */
        margin-top: 0;
        padding: 0 10px;
        text-align: left;
        display: -webkit-flex;
        display: flex;
        -webkit-justify-content: space-between;
        justify-content: space-between;
        -webkit-align-items: center;
        align-items: center;
        -webkit-box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);
        box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);
        /* -webkit-border-radius: 0 0 35px 35px;
        border-radius: 0 0 35px 35px; */
    }

    .main_title {
        color: rgba(0, 0, 0, 0.705);
        /* メニューのテキスト色 */
        margin: 0;
    }

    ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        /* background-color: chocolate; */
        /* background-color: #99d8fd; */
        display: flex;
        justify-content: center;
    }

    li {
        float: left;
        border-left: 1px solid #333;
    }


    li a {
        display: block;
        color: rgba(0, 0, 0, 0.705);
        text-align: center;
        margin: 0;
        padding: 30px 10px;
        text-decoration: none;
        bottom: 0;
    }

    li a:hover {
        background-color: rgb(250, 251, 254);
    }



    body {
        -webkit-font-family: "游ゴシック", "Yu Gothic";
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;
        margin: 0px;
    }

    h1 {
        color: rgba(0, 0, 0, 0.705);
        /* メニューのテキスト色 */
        margin: 0;
    }


    h2 {
        color: rgba(0, 0, 0, 0.705);
        /* メニューのテキスト色 */
        margin: 0;
    }



    .totalhyou {
        border-collapse: collapse;
        border-width: 0.5px;
        width: 80%;
        text-align: center;
    }

    .totalhyou td,
    th {
        padding: 7px 15px;
    }



    .table-continer {
        padding-top: 30px;

    }

    #myIframe {
        border-radius: 30px;
    }

    #myButton {
        -webkit-font-family: "游ゴシック", "Yu Gothic";
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;
        font-size: 17px;
        border: solid 0.5px;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        border-radius: 30px;
        cursor: pointer;
        border-color: white;
        padding: 7px 25px;

    }

    .tutorial_div label {
        top: 200px;
        position: fixed;
        right: 5px;
        z-index: 999;
    }

    .tutorial {
        font-family: "游ゴシック", "Yu Gothic";
        -webkit-font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;
        width: 75px;
        height: 75px;
        color: white;


        font-size: 50px;
        border-radius: 50%;
        border: solid 1px;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        background-color: #ffc0cb;

        position: fixed;

        top: 120px;

        right: 25px;
        z-index: 999;
    }

    .tutorial img {
        border-style: solid;
        border-width: 0.5px;
        border-radius: 50%;
        /* 丸みを持たせる */
        overflow: hidden;
        width: 50px;
        /* 画像のサイズを調整 */
        height: 50px;
    }
</style>
<header>
    <h1 class=main_title><a href="kanri_top.php" target="_top">シフト管理</a></h1><?php echo '👤' . $num . ' ' . $message . 'さん'; ?>
    <ul class="menu">
        <li class="menu-item"><a href="kanri_shiftdata.php" class="menu-link" target="_top"><img src='..\画像\calender.png' height=20px weight=20px><br>全体シフト</a>
        <li class="menu-item"><a href="kanri_mem.php" class="menu-link" target="_top"><img src='..\画像\member.png' height=20px weight=20px><br>メンバー・ポジション設定</a>
        <li class="menu-item"><a href="..\realtime_chat\index.php" class="menu-link" target="_top"><img src='..\画像\chat.png' height=20px weight=20px><br>店長チャット</a>
        <li class="menu-item"><a href="simekiri.php" class="menu-link" target="_top"><img src='..\画像\simekiri.png' height=20px weight=20px><br>シフトしめきり設定</a>
        <li class="menu-item"><a href="kyuyo.php" class="menu-link" target="_top"><img src='..\画像\money.png' height=20px weight=20px><br>給与設定</a>
        <li class="menu-item">
            <p align=center><img src='..\画像\exit.png' height=20px weight=20px>
                <?php
                print '<form method="post" accept-charset="UTF-8">';
                print '<input type="submit" name=logout value="ログアウト">';
                print '</form>';

                // $i = filter_input(INPUT_POST, "logout");

                // if (isset($i)) {
                //     $_SEESSION = array();
                //     session_destroy();
                //     header("Location: ../login.php");
                //     exit();
                // }

                ?>
            </p>
    </ul>
</header>


<body id="body">

    <script>
        function openSubWindow() {
            // 新しいサブウィンドウを開く
            // var subWindow = window.open('チュートリアル/clender_CHU.html', '_blank', 'width=500,height=400');

            // サブ画面のURL
            var subWindowURL = '../チュートリアル/kan_data_CHU.html'; // サブ画面のURLに適切なものを指定してください

            // ウィンドウのサイズを指定してサブ画面を開く
            var windowFeatures = 'width=600,height=400'; // 幅:600px, 高さ:400px
            window.open(subWindowURL, 'subwindow', windowFeatures);
        }

        // function scrollToBottom() {
        //     let chatArea = document.getElementById('chat-messages');
        //     chatArea.scrollTop = chatArea.scrollHeight;
        // }
    </script>
    <!-- <div class="tutorial_div">
        <label>チュートリアル</label>
        <button title="シフトカレンダーチュートリアル" onclick="openSubWindow()" class="tutorial">？</button>
    </div> -->


    <?php

    //session_start();

    $daysOfWeek = ['月', '火', '水', '木', '金', '土', '日'];
    $timePeriods = ["朝", "昼", "夜"];

    $timeIcon = ["朝" => '🌤', "昼" => '🌞', "夜" => '🌙'];

    $timeColor = ["朝" => '#FFEEFF', "昼" => '#FFFFEE', "夜" => '#EEFFFF'];


    $youbi_color = ['月' => '#87cefa', '火' => '#ffe4c4', '水' => '#e0ffff', '木' => '#fffacd', '金' => '#98fb98', '土' => '#e6e6fa', '日' => '#fff0f5',];


    $data = array();


    foreach ($daysOfWeek as $youbi) {
        foreach ($timePeriods as $timename) {
            // SELECT 必要人数 FROM １日当たり必要人数 WHERE 曜日='日' AND 時間='朝' AND ポジション名='合計'
            $stmt = $db->prepare("SELECT 必要人数 FROM １日当たり必要人数 WHERE 曜日=:youbi AND 時間=:timename AND ポジション名='合計'");
            $stmt->bindParam(':youbi', $youbi);
            $stmt->bindParam(':timename', $timename);
            // $stmt->bindParam(':goukei','合計');
            $stmt->execute();
            $resister = $stmt->fetch(PDO::FETCH_ASSOC);
            $data[$youbi][$timename] = $resister;
        }
    }



    $Totaldata = array();

    foreach ($daysOfWeek as $youbi) {
        $totalstmt = $db->prepare("SELECT 必要人数 FROM １日当たり必要人数 WHERE 曜日=:youbi AND 時間='総合計'");
        $totalstmt->bindParam(':youbi', $youbi);
        $totalstmt->execute();
        $totalresister = $totalstmt->fetch(PDO::FETCH_ASSOC);
        $Totaldata[$youbi] = $totalresister;
    }
    // echo '<pre>';
    // print_r($Totaldata);
    // echo '</pre>';

    ?>

    <?php
    if (isset($_POST['youbiname'])) {
        $_SESSION['youbiname'] = $_POST['youbiname'];
    ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var iframe = document.getElementById("myIframe");
                if (iframe) {
                    iframe.src = "test3.php"; //test3.phpのデータ取得してinlineフレームへ
                    scrollToBottom();
                } else {
                    console.error("Error: Unable to find iframe element.");
                }
            });
        </script>
    <?php
    }
    ?>
    <!--１週間必要人数表-->
    <div align=center class="table-continer">
        <table border=2 class="totalhyou">
            <caption style="font-size:20px;">1週間の必要人数</caption>
            <thead>
                <th>曜日</th>
                <?php foreach ($daysOfWeek as $youbi) : ?>
                    <th>
                        <form method=post><!--曜日ボタン-->
                            <input style="background-color:<?= $youbi_color[$youbi] ?>" type="submit" id="myButton" name="youbiname"  value="<?= $youbi ?>"><!-- loadIframe('<?= $youbi ?>')  onclick="scrollToBottom()"-->
                        </form>
                    </th>
                <?php endforeach; ?>
            </thead>
            <tbody>

                <?php foreach ($timePeriods as $timename) : ?><!--朝昼夜ループ-->
                    <tr style="background-color:<?= $timeColor[$timename] ?>;">
                        <td><?= $timename ?> <?= $timeIcon[$timename] ?></td>
                        <?php foreach ($daysOfWeek as $youbi) : ?>
                            <td>
                                <?php
                                if(isset($data[$youbi])){
                                    echo $data[$youbi][$timename]['必要人数'];
                                }else{
                                    echo 0;
                                }
                                ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>

                <?php endforeach; ?>
                <tr>
                    <td>総合計</td>

                    <?php foreach ($daysOfWeek as $youbi) : ?>
                        <td>
                            <?php
                            if(isset($Totaldata[$youbi])){
                                echo $Totaldata[$youbi]['必要人数'];
                            }else{
                                echo 0;
                            }
                            ?>
                        </td>
                    <?php endforeach; ?>
                </tr>

            </tbody>
        </table>
    </div>

    <!--曜日ごと表示領域-->
    <div align=center>
        <h2>必要人数設定表</h2>
        <iframe name="QueryResult" id="myIframe" width="80%" height="400"></iframe>
    </div>

    <script>
        function scrollToBottom() {
            var element = document.documentElement;
            var bottom = element.scrollHeight - element.clientHeight;
            window.scroll(0, bottom);
        }
    </script>


</body>

</html>