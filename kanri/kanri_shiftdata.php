<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="CSS/shift_data.css">
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.3/jspdf.umd.min.js"></script> -->
    <title>Document</title>
</head>

<?php
//セッションを使うことを宣言
session_start();

// //ログインされていない場合は強制的にログインページにリダイレクト
// if (!isset($_SESSION["login_name"])) {
//     header("Location: ../login.php");
//     exit();
// }

if ($_SESSION['login_name'] != "admin" || $_SESSION['login_ID'] != "123456" || isset($_POST['logout'])) {
    $_SEESSION = array();
    session_destroy();

    header("Location: ../login.php");
    exit();
}


//ログインされている場合は表示用メッセージを編集
$message = $_SESSION['login_name'];
$num = $_SESSION['login_ID'];



// echo $num;
// echo "{$message}さん";  

//DBよびだし
$db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");



$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


//現在の年取得
$current_year = date("Y");
//現在の月取得
$current_month = date("n");

//先月ボタン押した時の動作
if (isset($_POST['last_mon'])) {
    $current_year = $_POST['year']; //yearの値を一年間保持
    if (isset($_POST['cnt'])) {
        $current_month = $_POST['cnt'] - 1;
        if ($current_month < 1) {
            $current_month = 12;
            $current_year  = $_POST['year'] - 1; //一年が終わると去年に値を変更
        }
    }
}

//来月ボタン押した時の動作
if (isset($_POST['next_mon'])) {
    $current_year = $_POST['year']; //yearの値を一年間保持
    if (isset($_POST['cnt'])) {
        $current_month = $_POST['cnt'] + 1;
        if ($current_month > 12) {
            $current_month = 1;
            $current_year = $_POST['year'] + 1; //一年が終わると去年に値を変更
        }
    }
}

if (isset($_POST['pagechange'])) {
    $current_year = $_POST['yearname'];
    $current_month = $_POST['monthname'];
}



?>
<style>
    input {
        font-family: "游ゴシック", "Yu Gothic";
        -webkit-font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;
    }


    .month_title {
        padding-bottom: 20px;
    }

    .month {
        font-family: "游ゴシック", "Yu Gothic";
        -webkit-font-family: "游ゴシック", "Yu Gothic";

        font-size: 17px;
        color: rgba(0, 0, 0, 0.705);
        padding-left: 1em;
        padding-right: 1em;
        padding-top: 5px;
        padding-bottom: 5px;
        background-color: #99d8fd;
        border-radius: 10px;
        border-style: none;
        border-radius: 30px;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        cursor: pointer;
    }

    .focus_btn {
        font-family: "游ゴシック", "Yu Gothic";
        -webkit-font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;
        font-size: 17px;
        border-radius: 20px;
        background-color: #fffacd;
        color: black;
        border: solid 0.5px;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        cursor: pointer;
    }

    .focus_btn:hover {
        font-family: "游ゴシック", "Yu Gothic";
        -webkit-font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;
        font-size: 17px;
        border-radius: 20px;
        background-color: #fff;
        color: black;
        border: solid 0.5px;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        cursor: pointer;

    }

    .pagechange{
        width:150px;
        font-family: "游ゴシック", "Yu Gothic";
        -webkit-font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;
        font-size: 13px;
        border-radius: 10px;
        background-color: #fffacd;
        color: black;
        border: solid 0.5px;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        cursor: pointer;
    }

    .date_btn {
        font-family: "游ゴシック", "Yu Gothic";
        -webkit-font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;
        font-size: 12px;
        border-radius: 15px;
        background-color: #ffc7c7;
        color: black;
        border: solid 0.5px;
        margin-top: 10px;
        margin-bottom: 10px;

        padding: 2px 17px;
        /*上右下左*/
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        cursor: pointer;

    }

    /* ボタンのスタイル */
    .round-button {
        background-color: #ffdddd;
        /* 薄い赤の背景色 */
        border: solid 0.5px;
        /* ボーダーなし */
        color: #333;
        /* ボタン内の文字色 */
        text-align: center;
        /* 文字を中央に配置 */
        text-decoration: none;
        /* テキストの下線なし */
        display: block;
        /* ボタンをブロック要素に変更 */
        font-size: 10px;
        /* ボタン内の文字のサイズ */
        cursor: pointer;
        border-radius: 50%;
        /* 丸い形状 */
        width: 20px;
        /* ボタンの幅 */
        height: 20px;
        /* ボタンの高さ */
        line-height: 20px;
        /* テキストの高さを中央揃えに */
        position: relative;
        /* 相対位置指定 */
        float: right;
        /* 右寄せ */
        bottom: -15px;
        /* 下端に配置 */
        right: -2px;
        /* 右端に配置 */
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        margin-bottom: 10px;
        cursor: pointer;
    }

    .edit-button {
        background-color: #99ccff;
        border: solid 0.5px;
        /* ボーダーなし */
        color: #333;
        /* ボタン内の文字色 */
        text-align: center;
        /* 文字を中央に配置 */
        text-decoration: none;
        /* テキストの下線なし */
        display: block;
        /* ボタンをブロック要素に変更 */
        font-size: 10px;
        /* ボタン内の文字のサイズ */
        cursor: pointer;
        border-radius: 50%;
        /* 丸い形状 */
        width: 20px;
        /* ボタンの幅 */
        height: 20px;
        /* ボタンの高さ */
        line-height: 20px;
        /* テキストの高さを中央揃えに */
        position: relative;
        /* 相対位置指定 */
        float: right;
        /* 右寄せ */
        bottom: -6px;
        /* 下端に配置 */
        right: 1px;
        /* 右端に配置 */
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        margin-bottom: 10px;
        cursor: pointer;
    }

    .del-button {
        background-color: #ffdddd;
        border: solid 0.5px;
        /* ボーダーなし */
        color: #333;
        /* ボタン内の文字色 */
        text-align: center;
        /* 文字を中央に配置 */
        text-decoration: none;
        /* テキストの下線なし */
        display: block;
        /* ボタンをブロック要素に変更 */
        font-size: 10px;
        /* ボタン内の文字のサイズ */
        cursor: pointer;
        border-radius: 50%;
        /* 丸い形状 */
        width: 20px;
        /* ボタンの幅 */
        height: 20px;
        /* ボタンの高さ */
        line-height: 20px;
        /* テキストの高さを中央揃えに */
        position: relative;
        /* 相対位置指定 */
        float: right;
        /* 右寄せ */
        bottom: -6px;
        /* 下端に配置 */
        right: 50px;
        /* 右端に配置 */
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        margin-bottom: 10px;
        cursor: pointer;
    }


    .close-button {
        position: absolute;
        top: -10px;
        right: -5px;
        background-color: #dcdcdc;
        font-size: 15px;
        cursor: pointer;
        border: 0.2px solid #333;
        border-radius: 50%;
        width: 20px;
        /* ボタンの幅 */
        height: 20px;
        /* ボタンの高さ */
        line-height: 20px;
        /* テキストの高さを中央揃えに */
        text-align: center;
        /* 文字を中央に配置 */
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        cursor: pointer;
    }

    .intime {
        margin-top: 0px;
        border: solid 0.5px;
        border-radius: 5px;
        background-color: lavenderblush;
    }

    .outtime {
        margin-top: 0px;
        margin-bottom: 10px;
        border: solid 0.5px;
        border-radius: 5px;
        background-color: aliceblue;
    }


    .tutorial_div label {
        top: 200px;
        position: fixed;
        right: 20px;
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

        right: 40px;
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

    #wrapper {
        text-align: center;
        max-width: 1200px;
        max-height: 370px;
        overflow: scroll;
        margin-left: 30px;
        margin-right: 30px;
        margin-bottom: 50px;
        /* overflow: scroll; */
    }

    table {
        border-collapse: collapse;
        width: 100%;
        border: 2px solid black;
    }

    table th {
        height: 50px;
    }


    table th,
    /*        max-height: 2rem;*/
    table td {
        max-width: 6rem;
        min-width: 6rem;
        padding: 0.5rem;
        min-height: 2rem;
        font-size: 0.85rem;
        line-height: 1rem;
        text-align: center;
        border-color: #333;
        border-width: 1px;

    }

    table thead th {
        background-color: lavenderblush;
    }

    .idname {
        height: 50px;
    }

    table tbody tr td:nth-child(1),
    table tbody tr td:nth-child(2) {
        background-color: aliceblue;
    }

    table thead tr th:nth-child(1),
    table tbody tr th:nth-child(1),
    table thead tr td:nth-child(1),
    table tbody tr td:nth-child(1),
    table thead tr th:nth-child(2),
    table tbody tr th:nth-child(2),
    table thead tr td:nth-child(2),
    table tbody tr td:nth-child(2) {
        position: sticky;
        z-index: 1;
    }

    table thead tr th:nth-child(1),
    table tbody tr th:nth-child(1),
    table thead tr td:nth-child(1),
    table tbody tr td:nth-child(1) {
        left: 0;
    }

    table thead tr th:nth-child(2),
    table tbody tr th:nth-child(2),
    table thead tr td:nth-child(2),
    table tbody tr td:nth-child(2) {
        left: 6rem;
    }

    table thead tr:nth-child(1) th,
    table thead tr:nth-child(2) th {
        position: sticky;
        z-index: 2;
    }

    table thead tr:nth-child(1) th {
        top: 0;
    }

    table thead tr:nth-child(2) th {
        top: 3rem;
        /*9.481rem*/
    }

    table thead tr th:nth-child(1),
    table thead tr th:nth-child(2) {
        z-index: 3;
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




<body>


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
    </script>
    <div class="tutorial_div">
        <label>チュートリアル</label>
        <button title="シフトカレンダーチュートリアル" onclick="openSubWindow()" class="tutorial">？</button>
    </div>




    <!-- <?php
            // echo '<table border=2 id="print-table">';
            //     echo '<thead>';
            //             echo '<tr>';
            //                  for($i=0;$i<2;$i++){ 
            //                     echo '<th>aaaaa</th>';
            //                  }
            //             echo '</tr>';
            //     echo '</thead>';
            //     echo '<tbody>';
            //      echo '   <tr>';
            //             echo '<td>AAAAA</td>';
            //             echo '<td>BBBBB</td>';
            //     echo '</tr>';
            //     echo '</tbody>    ';
            // echo '</table>';
            ?> -->

    <!-- <button onclick="convertToPDF()">PDFに変換</button> -->




    <?php

    // うるう年計算メソッド
    function urus_method($year)
    {
        //4でわりきれるか4で割り切れるかつ100で割り切れなくて400でわりきれる
        if ($year % 4 == 0 && $year % 100 != 0) {
            return 29;
        } else if ($year % 4 == 0 && $year % 100 == 0 && $year % 400 == 0) {
            return 29;
        } else {
            return 28;
        }
    }

    // 日付からタイムスタンプを取得
    $timestamp = mktime(0, 0, 0, $current_month, 1, $current_year);

    //1,3,5,7,8,10,12 ----> 31まで
    $month_array = [31, urus_method(date("Y", $timestamp)), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

    // 1日の曜日の値を取得
    $week = date("w", $timestamp); //日月火。。。012

    $youbi_array = ["日", "月", "火", "水", "木", "金", "土"];
    ?>

    <!-- //セル検索 -->
    <form action="kanri_shiftdata.php" method="post" accept-charset="UTF-8">
        <input type="number" name="yearname"   min="2000" max="2060">年
        <input type="number" name="monthname"  min="1"    max="31">月
        <input type="submit" name="pagechange" class="pagechange" value="ページ移動">
    </form>


    <h1 style="margin-top:5px; margin-bottom:0px;">
        <div align=center>
            <form action="kanri_shiftdata.php" method="post" accept-charset="UTF-8" class="month_title" style="padding-bottom:0px;">
                <input type="submit" class="month" name="last_mon" value="◀先月">
                <?= $current_year ?>年
                <?= $current_month ?>月
                <input type="hidden" name="year" value="<?= $current_year ?>">
                <input type="hidden" name="cnt" value="<?= $current_month ?>">
                <input type="submit" class="month" name="next_mon" value="来月▶">
                <div align=left style="font-size:17px; ">
                </div>

            </form>
        </div>

    </h1>


    <label for="kensakuID">ユーザーID:</label>
    <input type="text" id="kensakuID">



    <label for="number">日付:</label>
    <input type="number" id="number" min="1" max="31">
    <button class="focus_btn" onclick="focusCell()">フォーカスする</button>





    <?php
    echo '<div id="wrapper" style="margin-top:0px;">';
    echo '<table align = center  border="2" class=table id="print-table">'; //最大テーブル表
    ?>

    <?php
    echo '<thead>';
    echo '<tr>';
    echo '<th colspan="2" style="padding:0px;">時間帯＼不足人数</th>';
    echo '<th style="display:none" style="padding:0px;"></th>';

    $timePeriods = ["朝", "昼", "夜"];


    $data = array();

    //1日ずつループ
    for ($i = 1, $k = $week; $i < $month_array[$current_month - 1] + 1; $k++, $i++) {
        if ($k == 7) $k = 0;
        $dayOfWeek = $youbi_array[$k];

        // もし、曜日がまだ $data 配列に存在しない場合は、新しいエントリを作成する
        if (!isset($data[$dayOfWeek])) {
            $data[$dayOfWeek] = array();
        }

        $just = $current_year . '-' . $current_month . '-' . $i; //2024-01-01の表記 


        echo '<th style="padding:0px;">';


        //朝、昼、夜
        foreach ($timePeriods as $timename) {
            // SELECT 必要人数 FROM １日当たり必要人数 WHERE 曜日='日' AND 時間='朝' AND ポジション名='合計'
            $stmt = $db->prepare("SELECT 時間帯_始, 時間帯_終, 必要人数 FROM １日当たり必要人数 WHERE 曜日=:youbi AND 時間=:timename AND ポジション名='合計'");
            $stmt->bindParam(':youbi', $dayOfWeek);
            $stmt->bindParam(':timename', $timename);
            $stmt->execute();
            $resister = $stmt->fetch(PDO::FETCH_ASSOC);

            // 時間帯ごとのデータを $data 配列に追加する
            $data[$dayOfWeek][$timename] = $resister;
            $must_shift = $data[$dayOfWeek][$timename]['必要人数'];

            $start_time = $data[$dayOfWeek][$timename]['時間帯_始'];
            $end_time = $data[$dayOfWeek][$timename]['時間帯_終'];

            // echo '<br>'.$start_time . '～' . $end_time . '<br>';

            $lessStart = array();
            $lessEnd = array();
            $lessNum = array();

            // echo $must_shift;

            //1時間ごと
            for ($time = strtotime($start_time); $time < strtotime($end_time); $time += 900) {
                $after = $time + 900;
                $start_hour = date('H', $time); //開始時間
                $end_hour = date('H', $after); //終了時間

                $allsql = $db->query("SELECT count(userID) as countuser FROM request_shift WHERE date = '$just' AND in_time <= '" . date('H:i:s', $time) . "' AND out_time >= '" . date('H:i:s', $after) . "'");
                $all_res = $allsql->fetch(PDO::FETCH_ASSOC);

                if ($must_shift > $all_res['countuser']) {
                    $lessStart[] = date('H:i', $time);
                    $lessEnd[] = date('H:i', $after);
                    $lessNum[] = $must_shift - $all_res['countuser'];
                    // echo date('H',$time).'~'.date('H',$after).'は'.$nai.'人たりない';
                }
            } //1時間ごとループ終わり

            if (!empty($lessStart)) {
                echo '<div style="color: red; font-size:10px; margin:0px;">' . min($lessStart) . '~' . max($lessEnd) . '/' . min($lessNum) . '人</div>';
                // echo '<p style="color: red; font-size:10px; margin:0px;">' . min($lessStart) . '~' . max($lessEnd) . '/' . min($lessNum) . '人</p>';

            }

            unset($lessStart);
            unset($lessEnd);
            unset($lessNum);
        }
        echo '</th>';
    }


    echo '</tr>';

    echo '<tr >';
    echo '<th class="idname" style="padding:0px; ">ID</th>';
    echo '<th class="idname" width="80%" style="padding:0px;">名前</th>';

    for ($i = 1, $k = $week; $i < $month_array[$current_month - 1] + 1; $k++, $i++) {
        echo '<th class="fixed02" style="padding:0px; ">'; //日付ボタン
        echo '<form method=post action="kanri_day.php" target=_blank>';
        echo     '<input type=hidden name="dayname" value=' . $current_year . '-' . $current_month . '-' . $i . '>';
        echo     '<input  class="date_btn" type=submit id="myButton" value=' . $i . '>';
        echo '</form>';
        if ($k == 7) $k = 0;
        echo '(' . $youbi_array[$k] . ')';
        echo "</th>";
    }

    echo '</tr>';
    echo '</thead>';
    ?>


    <?php
    try {
        $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");



        $sql = $db->query("SELECT userID,name FROM member");

        $resister = $sql->fetchAll();
        $count = 0;


        if ($current_month < 10) $current_month = '0' . $current_month;

        foreach ($resister as $result) :
            $count++;
            echo '<tbody>';
            echo '<tr>';
            echo '<td class="fixed03" align="center" width="100" height="60" style="padding:5px">';

            echo $result['userID'];

            echo '</td>';

            // ユーザー名前
            echo '<td class="fixed04" align="center" width="100" height="60" style="padding:5px">' . $result['name'] . '</td>';

            $num = $result['userID'];
            $name = $result['name'];

            for ($i = 1; $i < $month_array[$current_month - 1] + 1; $i++) {
                echo '<td class="cellID" style="padding:5px">';
                $formID = $num . '-' . $i; // ユーザーごと、日ごとに一意のIDを生成

                if ($i < 10) $i = '0' . $i;
                $date = $current_year . '-' . $current_month . '-' . $i;

                // 取得したユーザーIDと、毎日日付をずらして検索し、シフトがあれば表示
                $shift_sql = $db->query("SELECT in_time, out_time, date FROM request_shift WHERE userID ='$num' AND DATE_FORMAT(date,'%Y-%m-%d') = '$date' ORDER BY date");
                $shift_resister = $shift_sql->fetchAll();

                if (!empty($shift_resister)) {
                    // シフトデータ編集
                    foreach ($shift_resister as $result) :
                        $in_time = date('H:i', strtotime($result['in_time']));
                        $out_time =  date('H:i', strtotime($result['out_time']));
                        $shift_date =  $result['date'];
                        //$formID = 'form_' . uniqid(); // 一意のIDを生成
                        echo $formID;
                        echo '<div  id="' . $formID . '">';
                        echo "<form method='post' accept-charset='UTF-8' >";
                        echo '<input type="hidden" name="formID" value=' . $formID . '>';
                        echo '<input type="hidden" name="userID" value=' . $num . '>';
                        echo '<input type="hidden" name="name" value=' . $name . '>';
                        echo "<input type='hidden' name='date' value=$shift_date>";
                        echo "<input type='time' name='in_time' class='intime' oninput='' value=$in_time>";
                        echo "<input type='time' name='out_time' class='outtime' oninput='' value=$out_time>";
                        echo '<input type="hidden" name="code" value="update">';
                        echo '<input type="submit" class="del-button" name="delete" value="❌" onclick="return confirmDelete(\'' . $formID . '\')"></button>'; //onclick="deleteForm(\''.$formID.'\')"
                        echo '<input type="submit"  class="edit-button" name="edit" value="📝" onclick="return confirmEdit(\'' . $formID . '\')"></button>'; //onclick="showForm(\''.$formID.'\')"
                        echo "</form>";
                        echo '</div>';
                    endforeach;

                    echo '<script>
                            function confirmDelete(formID) {
                                return confirm("本当に削除してもいいですか？");
                            }

                            function confirmEdit(formID) {
                                return confirm("変更してもよろしいですか？");
                            }
                            </script>';
                } else {
                    echo $formID;
                    echo '<input class="round-button" onclick="showForm(\'' . $formID . '\', this)" value="+"></button>';
                    echo '<div class="form-container" id="' . $formID . '">';
                    echo '<form method="post" accept-charset="UTF-8">';
                    echo '<button class="close-button" onclick="closeForm(\'' . $formID . '\')">×</button>';
                    echo '<input type="hidden" name="userID"   value=' . $num . '>';
                    echo '<input type="hidden" name="name"     value=' . $name . '>';
                    echo '<input type="hidden" name="date"     value=' . $date . '>';
                    echo '<input type="time"   name="in_time" class="intime" value="" oninput="">';
                    echo '<input type="time"   name="out_time" class="outtime" value="" oninput="">';
                    echo '<input type="hidden" name="code"     value="insert">';
                    echo '<input type="submit" name="kanri_in" value="シフト追加">';
                    echo '</form>';
                    echo '</div>';
                }
                echo '</td>';
            }
            echo '<tr>';
        // 最後にforeachを終わらせる。
        endforeach;
        echo '</tbody>';
        echo '</table>';
        echo '</div>';


        require_once '../in_shift.php'; // ShiftProcessor.php のファイル名やパスに応じて変更してください

        // データベース接続
        $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");


        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // ShiftProcessor インスタンス生成
        $shiftProcessor = new ShiftProcessor($db);

        // フォームが送信されたときの処理
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kanri_in'])) {
            // フォームから送信された値を取得
            $userID = $_POST['userID'];
            $name = $_POST['name'];
            $date = $_POST['date'];
            $start_time = $_POST['in_time'];
            $end_time = $_POST['out_time'];
            $code = $_POST['code'];

            // ShiftProcessor のメソッドを呼び出し
            $shiftProcessor->calculateShiftData($start_time, $end_time, $date, $userID, $name, $code);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
            // フォームから送信された値を取得
            $userID = $_POST['userID'];
            $name = $_POST['name'];
            $date = $_POST['date'];
            $start_time = $_POST['in_time'];
            $end_time = $_POST['out_time'];
            $code = $_POST['code'];

            // ShiftProcessor のメソッドを呼び出し
            $shiftProcessor->calculateShiftData($start_time, $end_time, $date, $userID, $name, $code);
        }


        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
            // フォームから送信された値を取得
            $userID = $_POST['userID'];
            $date = $_POST['date'];

            // ShiftProcessor のメソッドを呼び出し
            $shiftProcessor->deleteShiftData($userID, $date);
        }
    } catch (PDOException $e) {
        echo "<div>" + $e->getMessage() + "</div>";
    }

    ?>

    <script>
        // フォーム表示関数
        function showForm(formID, button) {
            // ボタンの座標を取得
            var rect = button.getBoundingClientRect();
            //  alert('Top: ' + rect.top + ', Left: ' + rect.left + ', Width: ' + rect.width + ', Height: ' + rect.height);

            var form = document.getElementById(formID);
            form.style.display = "block"; // フォームを表示

            // フォームをボタンの近くに配置
            form.style.top = rect.top + window.scrollY + 'px';
            form.style.left = rect.left + window.scrollX + 'px';
        }



        function closeForm(formID) {
            var form = document.getElementById(formID);
            form.style.display = "none"; // フォームを表示
        }

        function deleteForm(formID) {
            var form = document.getElementById(formID);
            var result = window.confirm("削除してよろしいですか？");
            return result;
        }


        function validateAndFixTime(input) {
            // 入力された時間を取得
            var enteredTime = input.value;

            // 分の部分を取得
            var minutes = parseInt(enteredTime.split(":")[1]);

            // 分が00以外の場合、00に設定する
            if (minutes !== 0) {
                // 時間の部分を取得
                var hours = enteredTime.split(":")[0];
                // 入力欄に00を設定
                input.value = hours + ":00";
            }
        }


        function focusCell() {
            var kensakuIDInput = document.getElementById('kensakuID').value;
            var numberInput = document.getElementById('number').value;

            if (kensakuIDInput && numberInput) {
                let cells = document.getElementsByClassName('cellID'); //step1

                // 一旦すべてのセルのハイライトを解除
                for (var i = 0; i < cells.length; i++) {
                    cells[i].classList.remove('highlight');
                }

                // alert(cells.length);//buttonの中身を確認。

                for (var i = 0; i < cells.length; i++) {
                    let cellContent = cells[i].innerText //cells[i].textContent || 

                    if (cellContent === kensakuIDInput + '-' + numberInput) { //完全一致

                        cells[i].classList.add('highlight'); // フォーカス時にセルを強調表示するためのスタイリング
                        cells[i].scrollIntoView({
                            behavior: 'smooth',
                            block: 'center',
                            inline: 'center',
                        }); // セルが画面の中央に表示されるようにスクロール
                        return;
                    }
                }

                alert('該当するセルが見つかりませんでした。');
            } else {
                alert('ユーザーIDと数字を入力してください。');
            }
        }

        // function convertToPDF() {
        //     // テーブルの内容を取得
        //     var tableContent = document.getElementById('print-table').outerHTML;

        //     // PHPにテーブルの内容を送信
        //     var xhr = new XMLHttpRequest();
        //     xhr.open('POST', 'hyou.php');
        //     xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        //     xhr.onload = function() {
        //         if (xhr.status === 200) {
        //             // PHPからのレスポンスをダウンロードさせる
        //             var blob = new Blob([xhr.response], { type: 'application/pdf' });
        //             var link = document.createElement('a');
        //             link.href = window.URL.createObjectURL(blob);
        //             link.download = 'table.pdf';
        //             link.click();
        //         }
        //     };
        //     xhr.send('table=' + encodeURIComponent(tableContent));
        // }
    </script>
</body>

</html>