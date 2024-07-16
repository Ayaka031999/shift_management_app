<?php
//セッションを使うことを宣言
session_start();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style_member.css">
    <title>個人画面</title>
    <script>
        function openSubWindow() {
            // 新しいサブウィンドウを開く
            var subWindow = window.open('upimage.php', '_blank', 'width=500,height=400');
        }
    </script>
</head>

<body>

    <style>
        html {
            font-family: "游ゴシック", "Yu Gothic";
            font-weight: bold;

        }

        .rounded-image {
            border-radius: 50%;
            /* 丸みを持たせる */
            overflow: hidden;
            width: 50px;
            /* 画像のサイズを調整 */
            height: 50px;
            /* 画像のサイズを調整 */
        }

        #exit_btn {
            border-style: solid 1px;
            border-radius: 30px;
        }

        .menu-item:hover ul {
            display: block;
        }

        ul ul {
            margin: 0px;
            /* ★サブメニュー外側の余白(ゼロ) */
            padding: 0px;
            /* ★サブメニュー内側の余白(ゼロ) */
            display: none;
            /* ★標準では非表示にする */
            position: absolute;
            /* ★絶対配置にする */
        }

        ul ul li {
            width: 200px;
            /* サブメニュー1項目の横幅(135px) */
            border: 1px solid;
            /* 項目上側の枠線(ピンク色で1pxの実線) */
        }

        ul ul li a {
            font-family: "游ゴシック", "Yu Gothic";
            font-weight: bold;

            background-color: rgb(250, 251, 254);
            /* サブメニュー項目にマウスが載ったときの背景色(淡い黄色) */
            line-height: 35px;
            /* サブメニュー1項目の高さ(35px) */
            text-align: left;
            /* 文字列の配置(左寄せ) */
            padding-left: 5px;
            /* 文字列前方の余白(5px) */
        }

        ul ul li a:hover {
            background-color: #99d8fd;
            /* サブメニュー項目にマウスが載ったときの背景色(淡い黄色) */
            color: rgba(0, 0, 0, 0.705);
            /* サブメニュー項目にマウスが載ったときの文字色(濃い緑色) */
        }

        .shift_table {
            border-collapse: collapse;
            /* border-collapse: collapse; */
            width: 100%;
            /* border: 1px solid #333; */
            padding: 10px;
            background: #fff;
        }

        .shift_table th,
        td {
            border: 1px solid black;

            /* border: 1px solid black; */
            /* padding: 8px; */
            text-align: center;
        }

        .shift_table th {
            /* border: 1px solid black; */

            background-color: rgb(179, 219, 255);
        }


        .shift-cell {
            background-color: #dcdcdc;
            /* シフトがあるセルの背景色 */
        }

        .my-cell {
            background-color: lightgreen;
            /* シフトがあるセルの背景色 */
        }

        .kyuukei {
            background-color: #ffe4e1;
        }


        .container {
            display: flex;
        }



        .table-container {
            flex: 1;
            margin-right: 10px;
            /* テーブル間のスペースを設定 */
        }

        .table-container table {
            font-size: 12px;
            height: 230px;
            width: 100%;
            border-collapse: collapse;
            /* セルの間の余分なスペースを削除 */
        }

        .table-container table,
        th,
        td {
            border: 1px solid black;
            /* 枠線を表示 */
        }

        .table-container .defoTable {
            font-size: 12px;
        }

        .table-container .defoTable th,
        td {
            padding: 0px;
            width: 30px;
        }

        .in_shift_btn {
            font-family: "游ゴシック", "Yu Gothic";
            font-weight: bold;
            font-size: 17px;
            color: rgba(0, 0, 0, 0.76);
            border: solid 0.5px;
            border-radius: 30px;
            background-color: #ffffcc;
            text-align: center;
            height: 40px;
            width: 260px;
            padding: 0px;
            box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);

            display: inline-block;
            text-decoration: none;
            cursor: pointer;
        }

        .in_shift_btn:hover {
            font-family: "游ゴシック", "Yu Gothic";
            font-weight: bold;
            font-size: 17px;
            color: rgba(0, 0, 0, 0.76);
            border: solid 0.5px;
            border-radius: 30px;
            background-color: #fff;
            text-align: center;
            height: 40px;
            width: 260px;
            padding: 0px;
            box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);

            display: inline-block;
            text-decoration: none;
            cursor: pointer;
        }

        .time_table {
            width: 100%;
            max-height: 240px;
            overflow: scroll;
            margin-bottom: 30px;
        }

        .time_table table {
            border-collapse: collapse;
        }

        .time_table table th,
        .time_table table td {
            max-width: 3rem;
            min-width: 3rem;
            padding: 0.5rem;
            max-height: 2rem;
            min-height: 2rem;
            font-size: 0.85rem;
            line-height: 1rem;
            text-align: center;
        }

        .time_table table thead th {
            background-color: rgb(179, 219, 255);
        }

        .time_table table tbody tr td:nth-child(1) {
            background-color: white;
        }

        .time_table table thead tr th:nth-child(1),
        .time_table table tbody tr th:nth-child(1),
        .time_table table thead tr td:nth-child(1),
        .time_table table tbody tr td:nth-child(1) {
            max-width: 6rem;
            min-width: 6rem;
            position: sticky;
            position: -webkit-sticky;
            z-index: 1;
        }


        .time_table table thead tr th:nth-child(1),
        .time_table table tbody tr th:nth-child(1),
        .time_table table thead tr td:nth-child(1),
        .time_table table tbody tr td:nth-child(1) {
            left: 0;
        }

        .time_table table thead tr:nth-child(1) th,
        .time_table table thead tr:nth-child(2) th {
            position: sticky;
            position: -webkit-sticky;
            z-index: 2;
        }

        .time_table table thead tr:nth-child(1) th {
            top: 0;
        }

        .time_table table thead tr:nth-child(2) th {
            top: 2rem;
        }

        .time_table table thead tr th:nth-child(1) {
            z-index: 3;
        }

        header {
            z-index: 100;
        }
    </style>



    <?php

    //ログインされていない場合は強制的にログインページにリダイレクト
    if (!isset($_SESSION["login_name"])) {
        // ログインページにリダイレクト
        echo '<script>window.location.href="login.php";</script>'; //JSでログイン画面へ

        // header("Location: login.php");
        // exit();
    }

    if (isset($_POST["logout"])) {
        $_SESSION = array(); //セッション情報を破棄
        session_destroy();
        echo '<script>window.location.href="login.php";</script>'; //JSでログイン画面へ
    }


    //ログインされている場合は表示用メッセージを編集
    $message = $_SESSION['login_name'];
    $num = $_SESSION['login_ID'];

    $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");


    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT image_data FROM images WHERE imageID=$num";
    $stmt = $db->query($sql);
    $images = $stmt->fetch(PDO::FETCH_ASSOC);

    if (isset($images['image_data'])) {
        $img_data = base64_encode($images['image_data']);
    } else {
        $img_data = base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/画像/icon.png'));
    }

    ?>


    <header> <!-- onclick="openSubWindow()" -->
        <h1>シフト管理</h1><a onclick="openSubWindow()" title="アイコンアイコンの画像を設定できます"><?php echo '<img class="rounded-image" src="data:image/jpeg;base64,' . $img_data . '" width="50px" height="50px">'; ?></a><?php echo $num . ' ' . $message . 'さん'; ?>
        <ul>
            <li class="menu-item"><a href="member.php" class="menu-link" target="_top" title="トップページです。本日のシフトを確認できます。"><img src='画像\today.png' height=20px weight=20px><br>本日シフト</a>
            <li class="menu-item"><a href="calender.php" class="menu-link" target="_top" title="シフトカレンダーです。ここからシフトを追加できます。"><img src='画像\calender.png' height=20px weight=20px><br>シフトカレンダー</a>
            <li class="menu-item"><a href="money.php" class="menu-link" target="_top" title="お給料を確認します。"><img src='画像\money.png' height=20px weight=20px><br>お給料</a>
            <li class="menu-item"><a href="realtime_chat\" class="menu-link" target="_top" title="バイトメンバーのグループチャットです。"><img src='画像\chat.png' height=20px weight=20px><br>チャット</a>
            <li class="menu-item"><a class="menu-link"><img src='画像\setting.png' height=20px weight=20px><br>設定</a><!--href='setting_menue.php'-->
                <ul>
                    <li><a href="pass_change.php">アカウント設定と<br>パスワード変更</a></li>
                    <li><a href="delete_pre.php">退会の手続き</a></li>
                </ul>
            <li class="menu-item"><a><img src='画像\exit.png' height=20px weight=20px><br>
                    <?php
                    print '<form method="post" accept-charset="UTF-8">';
                    print '<input id="exit_btn" type="submit" name=logout value="ログアウト" title="ログアウトします">';
                    print '</form>';

                    ?>
                </a>
        </ul>
    </header>
    <div class="separator"></div>

    <?php
    // $output = shell_exec('php /var/www/html/realtime_chat/server.php');

    // if ($output === null) {
    //     echo "コマンドの実行中にエラーが発生しました。";
    // } else {
    //     echo "コマンドの実行結果: \n";
    //     echo $output;
    // }


    ?>



    <div class=overflow-y2 align=center>
        <?php
        try {
            $dayOfWeek = ["日", "月", "火", "水", "木", "金", "土"];

            $youbi = date('w');
            $today = date('Y-m-d');
            //タイトル
            echo '<h1 class=month_title>' . date('Y-m-d') . '(' . $dayOfWeek[$youbi] . ')' . '</h1>';

            $timePeriods = ["朝", "昼", "夜"];

            $data = array(); //時間帯ごとのデータを格納する

            $time_table = array(); //タイムテーブル全体のデータ格納

            $member = array(); //この日の全体のメンバーを格納

            $posiData = array(); //時間ごとのポジション名、必要人数を格納

            $posiAll = array(); //ポジションを時間後と、人ごとに格納

            //当日メンバー配列
            $sql = $db->query("SELECT name,rest_time,in_time,out_time FROM request_shift WHERE date = '$today' ORDER BY in_time ASC");
            $member = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach ($member as $mem) {
                $out_time = strtotime($mem['out_time']); //出勤時間
                $in_time = strtotime($mem['in_time']); //退勤時間
                $resti = $mem['rest_time']; //休憩時間

                //休憩時間があったら
                if ($resti > 0) {
                    // echo date("H:i:s",$in_time);
                    // echo date("H:i:s", strtotime($mem['in_time'].'+'.$resti.'minutes'));
                    // $time  = ($out_time - $in_time)/2-$resti+$intime;
                    // echo date("H:i:s",$time).'<br>';

                    //$pre_rest_Out

                    //休憩の入り時間を決める
                    $restIn = (($out_time - $in_time) / 2) - ($resti / 2 * 60) + $in_time;

                    //echo '<br>'.date("H:i",$restIn).'（仮の休憩入り）<br>';

                    if (isset($pre_rest_Out) && $pre_rest_Out >= date("H:i", $restIn)) {
                        // echo '<br>' . $pre_rest_Out . '(まえのひと)<br>';
                        // if(){
                        $restIn = $pre_rest_Out;
                        // }  echo '<br>まえとかぶり<br>';

                    } else {
                        $absoluteArray = array();

                        for ($minu = 0; $minu <= 60; $minu += 15) {
                            $absoluteArray[$minu] = abs(date("i", $restIn) - $minu); //入りの時間が中途半端だった場合、0,15,30分のどれかにさせる。abs関数は絶対値の関数
                        }

                        $minValue = min($absoluteArray);
                        $minKeys = array_keys($absoluteArray, $minValue);

                        //echo implode(',', $minKeys); 
                        $hour = date("H", $restIn); //元の時間の時部分を取得

                        if (reset($minKeys) == 60) $hour++; //60に近ければもう次の時間で休憩取らせる

                        if (reset($minKeys) == 0) {
                            $minute = reset($minKeys) . '0';
                        } else {
                            $minute = reset($minKeys); //最小値を持つ添字から時間部分を取得
                        }

                        $restIn = $hour . ':' . $minute; //時間を連結


                    }

                    // $restOut = $restIn+($resti * 60);
                    // echo date("H:i:s",$restIn).'～'.date("H:i:s",$restOut).'<br>';
                    // echo date("H:i:s", $time).'～'.date("H:i:s", $time+($resti * 60)).'<br>';

                    // echo $restIn;

                    $restOut = date("H:i", strtotime($restIn . '+' . $resti . 'minutes'));
                    unset($absoluteArray);
                    $rest_array[] = ['名前' => $mem['name'], '休憩' => $mem['rest_time'], '休憩入り' => $restIn, '休憩出' => $restOut];

                    //$mem['name']

                    // if($key>0){
                    //     if($rest_array[]['休憩入り']==$rest_array[]['休憩入り']){
                    //         echo '同じだ';
                    //     }
                    // }

                    // $pre_rest_In = $restIn;
                    $pre_rest_Out = $restOut;
                }
            }


            //朝、昼、夜
            foreach ($timePeriods as $timename) {
                // SELECT 必要人数 FROM １日当たり必要人数 WHERE 曜日='日' AND 時間='朝' AND ポジション名='合計'
                $stmt = $db->prepare("SELECT 時間帯_始, 時間帯_終, 必要人数 FROM １日当たり必要人数 WHERE 曜日=:youbi AND 時間=:timename AND ポジション名='合計'");
                $stmt->bindParam(':youbi', $dayOfWeek[$youbi]);
                $stmt->bindParam(':timename', $timename);
                $stmt->execute();
                $resister = $stmt->fetch(PDO::FETCH_ASSOC);

                // 時間帯ごとのデータを $data 配列に追加する
                $data[$timename] = $resister;
                $must_shift = $data[$timename]['必要人数']; //必要人数の合計

                //echo  $must_shift;

                $start_time = $data[$timename]['時間帯_始'];
                $end_time = $data[$timename]['時間帯_終'];

                // echo '<br>'.$start_time . '～' . $end_time . '<br>';

                $lessStart = array();
                $lessEnd = array();
                $lessNum = array();

                //15分ごと        
                for ($time = strtotime($start_time); $time < strtotime($end_time); $time += 900) {
                    $after = $time + 900;
                    $start_hour = date('H:i', $time); //開始時間
                    $end_hour = date('H:i', $after); //終了時間

                    //15分ごとに必要なポジションと人数
                    $posistmt = $db->prepare("SELECT ポジション名, 必要人数 FROM １日当たり必要人数 WHERE 曜日=:youbi  AND ポジション名 != '合計' AND ポジション名 != '総合計人数' AND 時間帯_始 <= '" . date('H:i:s', $time) . "' AND 時間帯_終 >= '" . date('H:i:s', $after) . "'");
                    $posistmt->bindParam(':youbi', $dayOfWeek[$youbi]);
                    $posistmt->execute();
                    $posiresister = $posistmt->fetchAll(PDO::FETCH_ASSOC);


                    foreach ($posiresister as $posi) {
                        //echo $posi['ポジション名'];
                        $posiData[$start_hour . '-' . $end_hour][] = [
                            'ポジション名' => $posi['ポジション名'],
                            '必要人数' => $posi['必要人数']
                        ];
                    }

                    //その時間に必要なポジション数
                    $posicount = count($posiData[$start_hour . '-' . $end_hour]);

                    //その15分ごとに入ってる人の名前
                    $allsql = $db->query("SELECT name FROM request_shift WHERE date = '$today' AND in_time <= '" . date('H:i:s', $time) . "' AND out_time >= '" . date('H:i:s', $after) . "'");
                    $all_res = $allsql->fetchAll(PDO::FETCH_ASSOC);

                    //休憩配列のキー名があるものは、その15分から除外
                    //休憩配列からひとりずつ取り出す
                    if (isset($rest_array)) {
                        foreach ($rest_array as $res_user) {
                            //echo strtotime($res_user['休憩入り']);
                            //echo $time;
                            //この15分間で休憩入ってるか
                            if (strtotime($res_user['休憩入り']) <= $time && strtotime($res_user['休憩出']) >= $after) {
                                //入ってたら
                                foreach ($all_res as $key => $value) {
                                    if ($value['name'] == $res_user['名前']) {
                                        unset($all_res[$key]); //休憩の人を削除
                                        $posiAll[$start_hour . '-' . $end_hour][$res_user['名前']] = '休憩';
                                        //echo $start_hour.'~'.$end_hour.'    '.count($all_res).'<br>';
                                    }
                                }
                            }
                        }
                    }

                    $user = []; //この1時間に入っている人の名前格納

                    $k = 0;

                    $row_data = [];
                    foreach ($all_res as $row) {
                        // echo $row['name'];
                        $row_data[$row['name']] = $row['name']; // ユーザーIDを行名として追加
                        $user[$k] = $row['name'];
                        $k++;
                    }

                    // 時間帯を列名としてタイムテーブルに追加
                    $time_table[$start_hour . '-' . $end_hour] = $row_data;


                    //足りないとき
                    if ($must_shift > count($all_res)) {
                        $lessStart[] = date('H:i', $time);
                        $lessEnd[] = date('H:i', $after);
                        $lessNum[] = $must_shift - count($all_res);
                        // echo date('H',$time).'~'.date('H',$after).'は'.$nai.'人たりない';

                    }
                    $i = 0;
                    for ($i = 0; $i < $posicount; $i++) {
                        $numdata[$i] = $posiData[$start_hour . '-' . $end_hour][$i]['必要人数'];
                    }
                    //echo count($user).'人<br>';
                    for ($z = 0, $i = 0; $z < count($user); $i++, $z++) {
                        if ($i == $posicount) { //1巡目がおわる
                            $i = 0; // $iがポジション数に達した場合、0にリセット

                        }


                        if ($numdata[$i] == 0) {

                            $i++;
                            if ($i == $posicount) { //1巡目がおわる
                                $i = 0; // $iがポジション数に達した場合、0にリセット
                                continue;
                            }
                        }
                        //echo 'ポジション名' . $i . '<br>';        
                        //echo $posiData[$start_hour . '-' . $end_hour][$i]['ポジション名'];

                        // 各従業員にポジションを1つずつ割り当てる
                        $posiAll[$start_hour . '-' . $end_hour][$user[$z]] = $posiData[$start_hour . '-' . $end_hour][$i]['ポジション名'];
                        $numdata[$i]--;
                        // echo $numdata[$i];

                        $allZero = true;
                        for ($p = 0; $p < $posicount; $p++) { //全て0か判断ループ
                            if ($numdata[$p] != 0) {
                                $allZero = false;
                                break;
                            }
                        }

                        if ($allZero) {
                            // echo "全て0";
                            for ($p = 0; $p < $posicount; $p++) { //全て0ならもう一度値入れ直してループさせる
                                $numdata[$p] = $posiData[$start_hour . '-' . $end_hour][$p]['必要人数'];
                            }
                            $i = -1;
                        }
                    }
                } //15分ごとループ終わり
                unset($lessStart);
                unset($lessEnd);
                unset($lessNum);
            } //朝昼夜ループ終わり

            //クラス読み込み
            require_once 'in_shift.php'; // ShiftProcessor.php のファイル名やパスに応じて変更してください

            // ShiftProcessor インスタンスの作成
            $shiftProcessor = new ShiftProcessor($db);

            //シフト変更POST
            // フォームが送信されたときの処理
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
                // フォームから送信された値を取得
                $start_time =date("H:i",strtotime($_POST['in_time']));
                $end_time = date("H:i",strtotime($_POST['out_time']));
                $code = $_POST['code'];

                if (strtotime($start_time) < strtotime(date('H:i'))) {
                    $start_time = date('H:i');
                }


                if(strtotime($start_time)<strtotime(date('H:i'))){
                    if(45 < date('i') ){
                        $start_time = (date('H')+1).':00';
                    }elseif(30 < date('i') && 45 >= date('i')){
                        $start_time = date('H').':45';
                    }elseif(15 < date('i') && 30 >= date('i')){
                        $start_time = date('H').':30';
                    }elseif(00 < date('i') && 15 >= date('i')){
                        $start_time = date('H').':15';
                    }else{
                        $start_time = date('H').':00';
                    }
                    // $start_time = date('H:i');
                }
    
    

                // $today = $_POST['date']; // 仮に今日の日付を使う例
                // ShiftProcessor のメソッドを呼び出し
                $shiftProcessor->calculateShiftData($start_time, $end_time, $today, $num, $message, $code);
            }


            // echo '<pre>';
            // print_r($posiAll);
            // echo '</pre>';

            // echo '<pre>';
            // print_r($time_table);
            // echo '</pre>';

            //タイムテーブルポジションcolspan
            $prestr = null; // 前の内容を格納する変数
            $colspan = 1;

            $po = 0;
            foreach ($member as $mem) {
                // echo 'キー'.$mem['name'];
                foreach ($posiAll as $hour_range => $value) {
                    // echo '<br>'.$hour_range.'<br>';
                    if (isset($posiAll[$hour_range][$mem['name']])) {
                        if ($posiAll[$hour_range][$mem['name']] == $prestr) {
                            $timeArray = explode("-", $hour_range, 2);

                            $timeEnd = $timeArray[1];
                            $colspan++;
                            $po++;
                            // echo $prestr.'<br>';

                        } else {
                            if ($po != 0) {
                                $colspaArray[$mem['name']][$timeStart . '-' . $timeEnd] = $colspan;
                            }

                            // unset($timeArray);

                            $timeArray = explode("-", $hour_range, 2);
                            // echo $timeArray[0].'~';
                            // echo $timeArray[1];
                            $timeStart = $timeArray[0];
                            $timeEnd = $timeArray[1];

                            $colspan = 1;
                            $prestr = null;
                            $prestr = $posiAll[$timeStart . '-' . $timeEnd][$mem['name']];

                            // $colspaArray[$timeStart.'-'.$timeEnd]['志尊淳'] = $colspan;
                            // echo $colspan.'<br>';
                        }
                    }
                }
                $colspaArray[$mem['name']][$timeStart . '-' . $timeEnd] = $colspan;
                $po = 0;
                $prestr=null;
                unset($timeArray);
            }
            // echo '<pre>';
            // echo print_r($colspaArray);
            // echo '</pre>';

            // echo '<pre>';
            // print_r($time_table);
            // echo '</pre>';
            // $prestr = null;
            $tableCount = 0;

            // タイムテーブルの表示
            echo '<h3 align=center style="margin:0px;padding:0px;">本日のタイムテーブル</h3>';
            echo '<div class=time_table>';
            echo '<table class=shift_table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th rowspan="2">時間帯</th>';

            //foreach ($time_table as $hour_range => $row_data) {
            $keys = array_keys($time_table);
            $Harray = array();
            $Hcount = 1;

            for ($i = 0; $i < count($keys); $i++) {
                $tabletime = array();
                $tabletime = explode("-", $keys[$i], 2); //-区切りでスタート時間とエンド時間だす

                //スタート
                $tableStart = $tabletime[0]; //スタート時間
                $startHM = explode(":", $tableStart, 2); //:区切りで取り出す
                $startHour = $startHM[0]; //何時

                if ($i == 0) {
                    $preH = $startHour;
                    continue;
                }


                if ($preH == $startHour) {
                    $Hcount++;
                    if ($i == (count($keys) - 1)) {
                        $Harray[$preH] = $Hcount;
                        // echo 'これ';
                        break;
                    }
                } else {
                    $Harray[$preH] = $Hcount;
                    $preH = $startHour;
                    $Hcount = 1;
                    if ($i == (count($keys) - 1)) {
                        $Harray[$startHour] = 1;
                        // echo 'あれ';
                        break;
                    }
                }
            }

            // echo '<pre>';
            // echo print_r($Harray);
            // echo '</pre>';

            $HarrayKey = array_keys($Harray);

            // echo '<pre>';
            // echo print_r($HarrayKey);
            // echo '</pre>';


            for ($i = 0; $i < count($Harray); $i++) {
                echo '<th colspan="' . $Harray[$HarrayKey[$i]] . '">' . $HarrayKey[$i] . '時</th>';
            }

            echo '</tr><tr>';
            echo '<th style="display:none" style="padding:0px;"></th>';

            for ($i = 0; $i < count($keys); $i++) {

                $tabletime = array();
                $tabletime = explode("-", $keys[$i], 2); //-区切りでスタート時間とエンド時間だす

                //スタート
                $tableStart = $tabletime[0]; //スタート時間
                $startHM = explode(":", $tableStart, 2); //:区切りで取り出す
                $startHour = $startHM[0]; //何時
                $startMinute = $startHM[1]; //何分

                //エンド
                $tableEnd = $tabletime[1]; //エンド時間
                $endHM = explode(":", $tableEnd, 2); //:区切りで取り出す
                $endHour = $endHM[0]; //何時
                $endMinute = $endHM[1]; //何分

                echo '<th>' . $startMinute . '-' . $endMinute . '</th>';
            }


            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            //1名ずつシフト表示
            foreach ($member as $mem) {
                $colmem = array();

                // echo $mem['name'].'<br>';
                foreach ($colspaArray[$mem['name']] as $colTime => $colValue) {
                    $colmem[$colTime] = $colValue;
                }

                // echo 'これは$colmemの結果<br>';
                // echo '<pre>';
                // echo print_r($colmem);
                // echo '</pre>';

                $colTimeArray = array_keys($colmem);

                // echo 'これは$colTimeArrayの結果<br>';
                // echo '<pre>';
                // echo print_r($colTimeArray);
                // echo '</pre>';

                echo '<tr>';
                echo '<td>' . $mem['name'] . '</td>'; // ユーザーIDを行名として表示

                $min15_range = array_keys($time_table);

                // echo '<pre>';
                // echo print_r($min15_range);
                // echo '</pre>';

                // for($i=0;$i<count($colTimeArray);$i++){
                //     $memTime = explode("-",$colTimeArray[$i],2);
                //     $memTimeStart = $memTime[0];//開始
                //     $memTimeEnd = $memTime[1];//終了
                // }

                // $colspan=1;
                $superI = 0;
                for ($timeI = 0; $timeI < count($min15_range);) {
                    //echo '今のtimeI  '.$timeI.'は'.$min15_range[$timeI].'<br>';

                    $curTime = explode("-", $min15_range[$timeI], 2);
                    $curTimeStart = $curTime[0]; //開始
                    $curTimeEnd = $curTime[1]; //終了

                    // シフトがある場合はクラス名を追加して背景色を設定
                    if (isset($posiAll[$min15_range[$timeI]][$mem['name']])) {

                        //echo '時飛ばしのじこく'.$colTimeArray[$superI].'<br>';
                        $memTime = explode("-", $colTimeArray[$superI], 2);
                        $memTimeStart = $memTime[0]; //開始
                        $memTimeEnd = $memTime[1]; //終了

                        
                       

                        //if(strtotime($memTimeStart) >= strtotime($curTimeStart)){
                        $superColspan = $colmem[$colTimeArray[$superI]];
                        // echo $superColspan.'<br><br>';
                        //}


                        if (strcmp($posiAll[$min15_range[$timeI]][$mem['name']], "休憩") == 0) {
                            echo '<td class="kyuukei" colspan="' . $superColspan . '">' . $posiAll[$min15_range[$timeI]][$mem['name']]; // colspan='.$superColspan.'
                        } else {
                            if ($mem['name'] == $message) {
                                echo '<td class="my-cell" colspan="' . $superColspan . '">' . $posiAll[$min15_range[$timeI]][$mem['name']]; //colspan="'.$colspan[$hour_range][$mem['name']].'"　colspan='.$superColspan.'
                            } else {
                                echo '<td class="shift-cell" colspan="' . $superColspan . '">' . $posiAll[$min15_range[$timeI]][$mem['name']]; //colspan="'.$colspan[$hour_range][$mem['name']].'"　colspan='.$superColspan.'
                            }
                        }
                        $superI++;
                        $timeI += $superColspan;
                    } else {
                        echo '<td>';
                        $timeI++;
                    }

                    echo '</td>';
                }
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
            echo '</div>';

            //今日の曜日に必要な人数やポジションを計算       
            $maxPositions = array(); // 各時間帯ごとの最大ポジション数を格納する配列

            foreach ($timePeriods as $onetime) {
                // SQLクエリの実行
                $timestmt = $db->prepare("SELECT MAX(ポジション) FROM １日当たり必要人数 WHERE 曜日='$dayOfWeek[$youbi]' AND 時間='$onetime'");
                $timestmt->execute();
                $timeresister = $timestmt->fetch(PDO::FETCH_ASSOC);

                // 最大ポジション数を配列に格納
                $maxPositions[$onetime] = $timeresister['MAX(ポジション)'];

                // デバッグ用に最大ポジション数を出力
                //echo $onetime . ':' . $maxPositions[$onetime] . '<br>';
            }


            // SQLクエリの実行
            $allstmt = $db->query("SELECT * FROM １日当たり必要人数 WHERE 曜日='$dayOfWeek[$youbi]'");
            $allresister = $allstmt->fetchAll(PDO::FETCH_ASSOC);

            //大枠div開始
            echo '<div class="container">';
            //必要人数目安
            echo '<div class="table-container">';
            // SQLクエリの実行
            $allstmt = $db->query("SELECT * FROM １日当たり必要人数 WHERE 曜日='$dayOfWeek[$youbi]'");
            $allresister = $allstmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($allresister)) {
                // データを連想配列として変換
                $mustData = array();
                foreach ($allresister as $allrow) {
                    $mustData[$allrow['時間']]['時間帯']['始'] = $allrow['時間帯_始'];
                    $mustData[$allrow['時間']]['時間帯']['終'] = $allrow['時間帯_終'];
                    $mustData[$allrow['時間']]['ポジション'][$allrow['ポジション']]['名前'] = $allrow['ポジション名'];
                    $mustData[$allrow['時間']]['ポジション'][$allrow['ポジション']]['必要人数'] = $allrow['必要人数'];
                }
                echo '<table border="2" class="defoTable">
                            <caption>' . $dayOfWeek[$youbi] . '曜日の必要人数</caption>
                            <thead>
                                <th>時間</th>
                                <th>時間帯</th>
                                <th>ポジション</th>
                                <th>必要人数</th>
                            </thead>
                            <tbody>';
                foreach ($timePeriods as $time) {
                    updateTableRow($mustData, $time, $maxPositions[$time]);
                }
                echo   '<tr>
                        <td>総合計時間</td>
                        <td >' . date('H:i', strtotime($mustData['総合計']['時間帯']['始'])) . '~' . date('H:i', strtotime($mustData['総合計']['時間帯']['終'])) . '</td>
                        <td>総合計人数</td>
                        <td>' . $mustData['総合計']['ポジション'][1]['必要人数'] = $allrow['必要人数'] . '</td>
                        </tr>
                        </tbody>
                    </table>';
            }

            echo '</div>'; //必要人数目安表終わり




            $check = false;
            //不足シフト表
            echo '<div class="table-container">';
            echo '<table border=2 >';
            echo '<caption>不足シフト募集</caption>';
            echo '<thead>
                        <th>募集時間帯</th>
                        <th>募集人数</th>
                        <th>入れそうだったらここのボタンを押してね！👇</th>
                    </thead>
                    <tbody>';


            $sql = $db->query("SELECT name FROM request_shift WHERE date = '$today' ORDER BY in_time ASC");
            $member = $sql->fetchAll(PDO::FETCH_ASSOC);

            //朝、昼、夜
            foreach ($timePeriods as $timename) {
                // SELECT 必要人数 FROM １日当たり必要人数 WHERE 曜日='日' AND 時間='朝' AND ポジション名='合計'
                $stmt = $db->prepare("SELECT 時間帯_始, 時間帯_終, 必要人数 FROM １日当たり必要人数 WHERE 曜日=:youbi AND 時間=:timename AND ポジション名='合計'");
                $stmt->bindParam(':youbi', $dayOfWeek[$youbi]);
                $stmt->bindParam(':timename', $timename);
                $stmt->execute();
                $resister = $stmt->fetch(PDO::FETCH_ASSOC);

                // 時間帯ごとのデータを $data 配列に追加する
                $data[$timename] = $resister;
                $must_shift = $data[$timename]['必要人数']; //必要人数の合計

                $start_time = $data[$timename]['時間帯_始'];
                $end_time = $data[$timename]['時間帯_終'];

                $lessStart = array();
                $lessEnd = array();
                $lessNum = array();

                //15分ごと        
                for ($time = strtotime($start_time); $time < strtotime($end_time); $time += 900) {
                    $after = $time + 900;
                    $start_hour = date('H:i', $time); //開始時間
                    $end_hour = date('H:i', $after); //終了時間

                    //15分ごとに必要なポジションと人数
                    $posistmt = $db->prepare("SELECT ポジション名, 必要人数 FROM １日当たり必要人数 WHERE 曜日=:youbi  AND ポジション名 != '合計' AND ポジション名 != '総合計人数' AND 時間帯_始 <= '" . date('H:i:s', $time) . "' AND 時間帯_終 >= '" . date('H:i:s', $after) . "'");
                    $posistmt->bindParam(':youbi', $dayOfWeek[$youbi]);
                    $posistmt->execute();
                    $posiresister = $posistmt->fetchAll(PDO::FETCH_ASSOC);

                    //その15分ごとに入ってる人の名前
                    $allsql = $db->query("SELECT name FROM request_shift WHERE date = '$today' AND in_time <= '" . date('H:i:s', $time) . "' AND out_time >= '" . date('H:i:s', $after) . "'");
                    $all_res = $allsql->fetchAll(PDO::FETCH_ASSOC);

                    if (isset($rest_array)) {
                        foreach ($rest_array as $res_user) { //休憩配列のキー名があるものは、その15分から除外
                            //echo strtotime($res_user['休憩入り']);
                            //echo $time;
                            if (strtotime($res_user['休憩入り']) <= $time && strtotime($res_user['休憩出']) >= $after) {
                                $name_to_remove = $res_user['名前'];
                                foreach ($all_res as $key => $value) {
                                    if ($value['name'] == $name_to_remove) {
                                        unset($all_res[$key]);
                                        $posiAll[$start_hour . '-' . $end_hour][$name_to_remove] = '休憩';
                                        //echo $start_hour.'~'.$end_hour.'    '.count($all_res).'<br>';
                                    }
                                }
                                //echo date('H:i', $time).'~'.date('H:i', $after).' '.$res_user['名前'].'<br>';
                            } else {
                                //echo $start_hour.'~'.$end_hour.'    '.count($all_res).'<br>';
                            }
                        }
                    }

                    foreach ($posiresister as $posi) {
                        //echo $posi['ポジション名'];
                        $posiData[$start_hour . '-' . $end_hour][] = [
                            'ポジション名' => $posi['ポジション名'],
                            '必要人数' => $posi['必要人数']
                        ];
                    }

                    // 配列の要素数を取得
                    $posicount = count($posiData[$start_hour . '-' . $end_hour]);

                    $user = []; //この1時間に入っている人の名前格納

                    $k = 0;

                    $row_data = [];
                    foreach ($all_res as $row) {
                        // echo $row['name'];
                        $row_data[$row['name']] = $row['name']; // ユーザーIDを行名として追加
                        $user[$k] = $row['name'];
                        $k++;
                    }

                    // 時間帯を列名としてタイムテーブルに追加
                    $time_table[$start_hour . '-' . $end_hour] = $row_data;


                    //足りないとき
                    if ($must_shift > count($all_res)) {
                        $lessStart[] = date('H:i', $time);
                        $lessEnd[] = date('H:i', $after);
                        $lessNum[] = $must_shift - count($all_res);
                        // echo date('H',$time).'~'.date('H',$after).'は'.$nai.'人たりない';

                    }
                    $i = 0;
                    for ($i = 0; $i < $posicount; $i++) {
                        $numdata[$i] = $posiData[$start_hour . '-' . $end_hour][$i]['必要人数'];
                    }
                    //echo count($user).'人<br>';
                    for ($z = 0, $i = 0; $z < count($user); $i++, $z++) {
                        if ($i == $posicount) { //1巡目がおわる
                            $i = 0; // $iがポジション数に達した場合、0にリセット

                        }


                        if ($numdata[$i] == 0) {
                            $i++;
                            if ($i == $posicount) { //1巡目がおわる
                                $i = 0; // $iがポジション数に達した場合、0にリセット
                                continue;
                            }
                        }
                        //echo 'ポジション名' . $i . '<br>';        
                        //echo $posiData[$start_hour . '-' . $end_hour][$i]['ポジション名'];

                        // 各従業員にポジションを1つずつ割り当てる
                        $posiAll[$start_hour . '-' . $end_hour][$user[$z]] = $posiData[$start_hour . '-' . $end_hour][$i]['ポジション名'];
                        $numdata[$i]--;
                        // echo $numdata[$i];

                        $allZero = true;
                        for ($p = 0; $p < $posicount; $p++) { //全て0か判断ループ
                            if ($numdata[$p] != 0) {
                                $allZero = false;
                                break;
                            }
                        }

                        if ($allZero) {
                            // echo "全て0";
                            for ($p = 0; $p < $posicount; $p++) { //全て0ならもう一度値入れ直してループさせる
                                $numdata[$p] = $posiData[$start_hour . '-' . $end_hour][$p]['必要人数'];
                            }
                            $i = -1;
                        }
                    }
                } //15分ごとループ終わり

                //不足人数表示
                if (!empty($lessStart)) {
                    // echo '<p style="color: red;">' . min($lessStart) . '~' . max($lessEnd) . '時 ' . min($lessNum) . '人不足しています</p>';

                    $check = true;
                    echo           '<tr>';
                    echo           '<td>' . min($lessStart) . '~' . max($lessEnd) . '時 </td>
                                        <td>' . min($lessNum) . '人</td>
                                        <td>
                                            <form method="post" accept-charset="UTF-8">
                                            <input  id = shift type ="hidden" name="in_time" value="' . min($lessStart) . ':00"><input  id = shift type ="hidden" name="out_time" value="' . max($lessEnd) . ':00">
                                            <input type="hidden" name="date" value="' . $today . '">
                                            <input type="hidden" name="code" value="insert">';

                    //$resister =  get_shiftdata($today); //シフトがあるかどうか

                    $min = min($lessStart);
                    $max = max($lessEnd); // . ':00';


                    //指定された時間にはいっているか
                    $pre_sql = $db->query("SELECT name FROM request_shift WHERE userID = $num AND date = '$today' AND in_time <= '$min' AND out_time >= '$max'");
                    $pre_res = $pre_sql->fetch(PDO::FETCH_ASSOC);

                    //一回入ったらだめになる！
                    //その日に自分がいるかor  提出日以内か
                    //その時間に自分がいるかに変更
                    //if (strtotime($today) < strtotime(date('Y-m-d'))) { //|| checkShiftSubmission($today, $db)entry_control($num, $resister) || 
                    if ((strtotime($today) == strtotime(date('Y-m-d')) && (strtotime($max) < strtotime(date('H:i'))))) {

                        // print '<input type="submit" value="ここに入る" disabled>'; //送信ボタン無効
                        echo 'シフトの時間帯を超過しています。';
                    } elseif (!empty($pre_res)) {
                        echo 'あなたはもう既にこの時間にシフトに入っているため入れません。';
                    } else {

                        $re_sql = $db->query("SELECT in_time,out_time FROM request_shift WHERE userID = $num AND date = '$today' ");
                        $re_res = $re_sql->fetch(PDO::FETCH_ASSOC);


                        //そもそもこの日シフトはいってる？
                        if (!empty($re_res)) {

                            // $re_sql = $db->query("SELECT in_time,out_time FROM request_shift WHERE userID = $num AND date = '$today' ");
                            // $re_res = $re_sql->fetch(PDO::FETCH_ASSOC);

                            // $min =  $min;
                            // $max =  $max; // . ':00';

                            if ($max == date("H:i", strtotime($re_res['in_time'])) || $min == date("H:i", strtotime($re_res['out_time']))) {
                                // echo 'はなれてない';

                                if (strtotime($min) <= strtotime($re_res['in_time']) && strtotime($max) >= strtotime($re_res['out_time'])) {
                                    $min = $min;
                                    $max = $max;
                                } else if (strtotime($min) <= strtotime($re_res['in_time']) && strtotime($max) <= strtotime($re_res['out_time'])) {
                                    $min = $min;
                                    $max = $re_res['out_time'];
                                } else if (strtotime($min) >= strtotime($re_res['in_time']) && strtotime($max) >= strtotime($re_res['out_time'])) {
                                    $min = $re_res['in_time'];
                                    $max = $max;
                                }

                                // echo $min.'~'.$max;

                                print '<input  id = shift type ="hidden" name="in_time" value="' . $min . '"><input  id = shift type ="hidden" name="out_time" value="' . $max . '">';
                                print '<input type = "hidden" name="code" value="update">';
                                print '<input type="submit" name="submit" class="in_shift_btn" value="この時間帯でシフトに入る">';
                            } else {
                                // print '<input type="submit" value="この時間帯でシフトに入る" disabled>'; //送信ボタン無効
                                if($min <= $re_res['in_time'] && $max >= $re_res['in_time']){
                                    echo 'あなたはもう既にこの時間にシフトに入っているため入れません。';
                                }else{
                                    echo 'シフトを時間を空けて複数回入ることはできません。';
                                }
                            }
                        } else {
                            print '<input type="submit" name="submit" class="in_shift_btn" value="この時間帯でシフトに入る">';
                        }
                        

                        echo '</form>';
                        echo '</td>';
                        echo '</tr>';
                        // if($lesscount>0){
                        //     echo '</tbody>';
                        //     echo '</table>';
                        // }//不足人数ループ終わり
                    }
                }
                unset($lessStart);
                unset($lessEnd);
                unset($lessNum);


                // if(!empty($lessStart)){
                //     echo min($lessStart).'~'.max($lessEnd).'時<br>';
                //     echo min($lessNum).'人<br>';
                // }
            } //朝昼夜ループ終わり

            if (!$check) {
                echo '<td colspan=3 style="font-size:25px;">シフトの募集はありません。</td>';
            }

            echo '</tbody>';
            echo '</table>';


            echo '</div>';
            echo '</div>'; //表連結大枠div





        } catch (PDOException $e) {
            echo "<div>" . $e->getMessage() . "</div>";
        }

        ?>


        <?php

        function updateTableRow($data, $timePeriod, $receivedData)
        {

            echo '<tr>';
            echo '<td rowspan="' . ($receivedData + 1) . '">'; //oninput="syncInput(this.value, 'input2')"

            // echo '<input type="hidden" name="' . $timePeriod . '_時間帯_始" value="' . $timePeriod . '_時間帯_始">';
            // echo '<input type="hidden" name="' . $timePeriod . '_時間帯_終" value="' . $timePeriod . '_時間帯_終">';

            echo $timePeriod; // 朝昼夜表示
            echo '</td>';
            echo '<td rowspan="' . ($receivedData + 1) . '">';
            echo date('H:i', strtotime($data[$timePeriod]['時間帯']['始'])) . '~' . date('H:i', strtotime($data[$timePeriod]['時間帯']['終']));

            echo '</td>';

            for ($j = 1; $j < $receivedData; $j++) {
                echo '<td>' . $data[$timePeriod]['ポジション'][$j]['名前'] . '</td>';
                echo '<td>' . $data[$timePeriod]['ポジション'][$j]['必要人数'] . '</td>';
                echo '</tr>';
                echo '<tr>';
            }

            echo '<td style="background-color: rgb(253, 210, 245);">合計</td>';
            echo '<td style="background-color: rgb(253, 210, 245);">' . $data[$timePeriod]['ポジション'][$receivedData]['必要人数'] . '</td>';
            echo '</tr>';
            echo '<tr>';
        }




        ?>


    </div>

    <?php


    //日本語化
    // ob_start(function ($buf) {
    //     return mb_convert_encoding($buf,'UTF-8' , 'SJIS');
    // });


    // $cmd = 'php server.php';
    // $opt = shell_exec($cmd);
    // echo $opt;

    // ob_start();
    // passthru("ipconfig/all", $return_var);
    // $output = ob_get_clean();

    // $opt = shell_exec('cd');
    // echo $opt; 
    // print_r($opt);

    // $str = mb_convert_encoding($opt,"utf-8"); // シフトJISからUTF-8に変換
    // echo $opt; // 文字化けが起きない

    /// 実行したいコマンド本体
    // $command = "php server.php";

    // /// OSごとに少し起動方法を変える
    // if((substr(PHP_OS, 0, 3) !== 'WIN')){
    //     /// Linux系OSの場合
    //     exec($command . ' >/dev/null 2>&1 &');
    // }else{
    //     /// Windows系OSの場合
    //     $fp = popen('start "" '.$command, 'r');
    //     pclose($fp);
    // }

    ?>

    <footer>
        <p align=center>© 2024 j315 a.n shift_kanri</p>
    </footer>

</body>

</html>