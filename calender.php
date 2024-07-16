<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style_calender.css">
    <title>カレンダー</title>
</head>

<body>
    <style>
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


        .month_title {
            padding-bottom: 20px;
        }
    </style>


    <?php

    //セッションを使うことを宣言
    session_start();

    //ログインされていない場合は強制的にログインページにリダイレクト
    if (!isset($_SESSION["login_name"]) || isset($_POST["logout"])) {
        // セッション情報を破棄してログインページにリダイレクト
        $_SESSION = array();
        session_destroy();
        header("Location: login.php");
        exit();
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
        $img_data = base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/事例研究/画像/icon.png'));
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
    <div class="calender_page">


        <?php

        //   echo $num;
        //   echo "{$message}さん";


        //現在の年取得
        $current_year = date("Y");
        //現在の月取得
        $current_month = date("n");
        // if($current_month<10) 
        // echo $current_month;//最初よびだすと001になってる



        //先月ボタン押した時の動作
        if (isset($_POST['last_mon'])) {
            $current_year = $_POST['year']; //yearの値を一年間保持
            if (isset($_POST['cnt'])) {
                $current_month = $_POST['cnt'] - 1;
                if ($current_month < 1) {
                    $current_month = 12;
                    $current_year = $_POST['year'] - 1; //一年が終わると去年に値を変更
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

        ?>


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

            .tutorial_div label {
                top: 220px;
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

            .month {
                font-family: "游ゴシック", "Yu Gothic";
                -webkit-font-family: "游ゴシック", "Yu Gothic";
                font-weight: bold;

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




            /* .tutorial {
            font-family: "游ゴシック", "Yu Gothic";
            -webkit-font-family: "游ゴシック", "Yu Gothic";
            border-radius: 50%;
            width: 50px;
            height: 50px;
            background-color: #ffc0cb;
            color: white;
            font-size: 25px;
            font-weight: bold;
            border: none;
        } */
        </style>

        <label class="back-btn-label">戻る</label>
        <a href="member.php" title="トップへ戻る"><img src="画像/return.png" class="back-btn"></a>

        <script>
            function openSubWindow() {
                // 新しいサブウィンドウを開く
                // var subWindow = window.open('チュートリアル/clender_CHU.html', '_blank', 'width=500,height=400');

                // サブ画面のURL
                var subWindowURL = 'チュートリアル/clender_CHU.html'; // サブ画面のURLに適切なものを指定してください

                // ウィンドウのサイズを指定してサブ画面を開く
                var windowFeatures = 'width=600,height=400'; // 幅:600px, 高さ:400px
                window.open(subWindowURL, 'subwindow', windowFeatures);
            }
        </script>
        <div class="tutorial_div">
            <label>チュートリアル</label>
            <button title="シフトカレンダーチュートリアル" onclick="openSubWindow()" class="tutorial">？</button>
        </div>
        <h1 align=center>

            <!-- <img src="画像/ヘルプ.jpg"> -->
            <form action="calender.php" method="post" accept-charset="UTF-8" class="month_title">
                <input type="submit" class="month" name="last_mon" value="◀ 先月">
                <?= $current_year ?>年
                <?= $current_month ?>月
                <input type="hidden" name="year" value="<?= $current_year ?>">
                <input type="hidden" name="cnt" value="<?= $current_month ?>">
                <input type="submit" class="month" name="next_mon" value="来月 ▶">
            </form>
        </h1>

        <!-- <style> #date{ color:rgb(4, 46, 46); }</style> -->


        <?php
        //うるう年計算メソッド
        function urus_method($year)
        {   //4でわりきれるか4で割り切れるかつ100で割り切れなくて400でわりきれる
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
        ?>

        <style>
            .table th,
            td {
                border: solid 0.5px;
                height:60px ;
            }

            .table {
                color: black;
                border-collapse: collapse;

                border-radius: 10px;
                /* 角丸指定 */
                border-style: solid 0.5px;
                width: 800px;
                height: 400px;
                /* border-collapse: collapse; */
            }

            td {
                border-style: solid;
            }

            tr {
                border-style: solid;
            }

            thead {
                background-color: #99d8fd;
            }
        </style>

        <table align=center class="table">
            <thead>
                <tr>
                    <?php
                    $youbi_array = ["日", "月", "火", "水", "木", "金", "土"];

                    for ($q = 0; $q < 7; $q++) {
                        echo '<th style="height:30px;">'.$youbi_array[$q].'</th>';
                    }
                    ?>
                </tr>
            </thead>

            <tbody>
                <?php //カレンダー部分

                try {
                      $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");




                    $date = $current_year . '-' . $current_month;
                    if ($current_month < 10) $current_month = '0' . $current_month;
                    $date = $current_year . '-' . $current_month;

                    //年と月を取り出して、その月のシフトの日付をとりだす
                    $sql = $db->query("SELECT date FROM request_shift WHERE userID = $num AND DATE_FORMAT(date,'%Y-%m') = '$date' ORDER BY date");

                    $resister = $sql->fetchAll();

                    //echo $resister['date'];

                    //年月日取得してシフトが入っていたら背景色を返す
                    function change_color($resister, $current_year, $current_month, $k)
                    {
                        $just = $current_year . '-' . $current_month . '-' . $k; //2024-01-01の表記   
                        foreach ($resister as $result) :
                            if ($result['date'] == $just) {
                                // echo $result['date'].'<br>';//自分が入ってる日にち
                                return '#FFCCCC';
                            }
                        endforeach;
                        return ' ';
                    }

                    //$db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4","root","");

                    //人手不足の場合は文字を赤くする
                    function men_change_color($current_year, $current_month, $k)
                    {
                        // データベース接続
                          $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");



                        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        // echo $current_month;
                        $just = $current_year . '-' . $current_month . '-' . $k; //2024-01-01の表記 
                        // 日付からタイムスタンプを取得
                        $timestamp = mktime(0, 0, 0, $current_month, $k, $current_year);
                        $youbi = date("w", $timestamp);

                        $check = false;

                        $dayOfWeek = ["日", "月", "火", "水", "木", "金", "土"];
                        $timePeriods = ["朝", "昼", "夜"];

                        $data = array(); //時間帯ごとのデータを格納する

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

                            //1じかんごと
                            for ($time = strtotime($start_time); $time < strtotime($end_time); $time += 3600) {
                                $after = $time + 3600;

                                $allsql = $db->query("SELECT count(userID) FROM request_shift WHERE date = '$just' AND in_time <= '" . date('H:i:s', $time) . "' AND out_time >= '" . date('H:i:s', $after) . "'");
                                $all_res = $allsql->fetch();
                                $all = $all_res['count(userID)'];

                                //足りないとき
                                if ($must_shift > $all) {
                                    $lessStart[] = date('H', $time);
                                    $lessEnd[] = date('H', $after);
                                    $lessNum[] = $must_shift - $all;
                                    // echo date('H',$time).'~'.date('H',$after).'は'.$nai.'人たりない';
                                }
                            } //1時間ごとおわり

                            //不足人数表示
                            if (!empty($lessStart)) {
                                // echo '<p style="color: red;">'.$just.''.min($lessStart).'~'.max($lessEnd).'時 '.min($lessNum).'人不足しています</p>';
                                $check = true;
                            }

                            unset($lessStart);
                            unset($lessEnd);
                            unset($lessNum);
                        }

                        if ($check) {
                            return 'red';
                        } else {
                            return 'rgba(0, 0, 0, 0.705)';
                        }
                    }

                    function simekiri($current_year, $current_month, $k)
                    {
                          $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");




                        $just = $current_year . '-' . $current_month . '-' . $k; //2024-01-01の表記   

                        // echo  "こんげつは".$kongetu."<br><br>";

                        $kongetu = $current_year . "-" . $current_month;

                        //$today = date("Y-m-d H:i:s")
                        //SELECT simekiri FROM シフト提出日 WHERE simekiri LIKE '2024-02%'

                        $simesql = $db->query("SELECT 日付 FROM シフト提出日 WHERE 日付 LIKE  '" . $kongetu . "%' ");
                        $sime_res = $simesql->fetch();
                        //$sime = $sime_res['week_people'];

                        if (isset($sime_res['日付'])) {

                            if ($just == date('Y-m-d', strtotime($sime_res['日付']))) echo '<p style="font-size: 15px; color: blue; margin:0px;">シフト提出日</p>';

                            //$dbDateTime  = $sime_res['simekiri'];

                            //echo date('Y-m-d',strtotime($sime_res['simekiri']));

                            //return "border: 2px solid red";

                        } else {
                            // echo "しめきりが登録されていません<br><br>";
                        }
                    }


                    //カレンダー
                    for ($z = 0; $z < 6; $z++) { //縦6行              
                        if ($z == 0) { //はじめの1行目、1日は何曜日から始まるか
                            echo "<tr >";
                            for ($i = 0, $k = 1; $i < 7; $i++) {
                                if ($week <= $i) {
                                    if ($k < 10) $k = '0' . $k;
                                    $color = change_color($resister, $current_year, $current_month, $k); //色を変える
                                    $mencolor = men_change_color($current_year, $current_month, $k); //色を変える
                                    simekiri($current_year, $current_month, $k);
                                    echo "<td align = center width='100' height='80' id='td_design' bgcolor={$color}>";
                                    echo "<form method='post' action='./day_shift.php' accept-charset='UTF-8'>";
                                    //session_regenerate_id(TRUE); //セッションidを再発行
                                    //$_SESSION["date"] = $current_year.'-'.$current_month.'-'.$k; //セッションにログイン情報を登録
                                    echo "<input type='hidden' name=date value=$current_year-$current_month-$k>"; //日付を送信
                                    // if($_SESSION['login_ID']==123456 && strcmp($_SESSION['login_name'], "admin") == 0){        
                                    //     echo '<input type=hidden name=innerID value='.$_POST['innerID'].'>';
                                    // }                                    
                                    echo "<style>
                                                #date_{$k}{ 
                                                    background-color:transparent; 
                                                    font-size: 25px;
                                                    border: 0em;
                                                    color:$mencolor; 
                                                }
                                            </style>";
                                    echo "<input type='submit' style='width: 113px; height:60px;' id ='date_$k' value=$k>"; //日付ボタン
                                    echo "</form>";
                                    echo "</td>";
                                    $k++;
                                } else {
                                    echo "<td align = center width='100' height='80'><a id = date href='./day_shift.php'></a></td>";
                                }
                            }
                            echo "</tr>";
                        } else {
                            echo "<tr >";
                            for ($i = 0; $i < 7; $i++, $k++) {
                                if ($k < ($month_array[$current_month - 1] + 1)) {
                                    if ($k < 10) $k = '0' . $k;
                                    $color = change_color($resister, $current_year, $current_month, $k);
                                    $mencolor = men_change_color($current_year, $current_month, $k); //色を変える
                                    echo "<td align = center width='100' height='80' bgcolor={$color}>";
                                    simekiri($current_year, $current_month, $k);
                                    echo "<form method='post' action='./day_shift.php' accept-charset='UTF-8'>";
                                    echo "<style>
                                        #date_$k{ 
                                            background-color:transparent; 
                                            font-size: 25px;
                                            border: 0em;
                                            color:$mencolor; 
                                        }
                                        </style>";
                                    echo "<input type='hidden' name=date value=$current_year-$current_month-$k>";
                                    echo "<input type='submit' id ='date_$k' value=$k>";
                                    echo "</form>";
                                    echo "</td>";
                                } else {
                                    echo "<td align = center width='100' height='80'><a id = date href='./day_shift.php'></a></td>";
                                } //見た目がいまいち
                            }
                            echo "</tr>";
                        }
                    }
                } catch (PDOException $e) {
                    echo "<div>" . $e->getMessage() . "</div>";
                }

                ?>
            </tbody>

        </table>

    </div>
</body>

</html>