<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style_money.css">
    <title>お給料</title>
</head>
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

    .money_block{
        padding-top: 50px;
    }
</style>
<body>

    <div align=center>

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

        // echo $num;
        // echo "{$message}さん";

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
        <div class="separator"></div>


        <script type=text/javascript>
            // window.addEventListener("load", function () {
            //   history.pushState(null, null, location.href);
            //   window.addEventListener("popstate", function () {
            //     history.pushState(null, null, location.href);
            //   });
            //   alert('リロードしないでください');
            // });
        </script>
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
        
        <label class="back-btn-label">戻る</label>
        <a href="member.php" title="トップへ戻る"><img src="画像/return.png" class="back-btn"></a>

        <div class="money_block">
        <?php
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
        // $date = date('Y-m');

        try {
              $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");




            echo '<form action="money.php" method="post">';
            echo       $current_year . '年';
            echo       $current_month . '月';
            echo     '<h3>今月のお給料は</h3>';

            $sql = 'SELECT * from 給料関係設定';
            $stmt = $db->query($sql);
            $resister = $stmt->fetchAll();

            foreach ($resister as $result) :
                //echo $result['userID'].'<br>';
                $salary = $result['給料額'];
                $simebi =  $result['給料締め日'];
                $payday = $result['給料日'];
            endforeach;

            // $simebi


            //年月から月末の日付を取得
            function getLastDayOfMonth($current_year, $current_month)
            {
                // 日付文字列を作成
                $dateString = sprintf("%04d-%02d", $current_year, $current_month);
                // 月末の日付を取得
                $lastDay = date('t', strtotime($dateString));
                return $lastDay;
            }

            if ($simebi == "月末") {
                $simebi = getLastDayOfMonth($current_year, $current_month);
                // echo "月末：". $simebi ."<br>";
                // 今月の月末日を取得
                $this_month_day = date('Y-m-d', strtotime($current_year . '-' . $current_month . '-' . $simebi . ''));
                // 今月の1日を取得
                $last_month_day = date('Y-m-d', strtotime($current_year . '-' . $current_month . '-1 '));
            } else {
                $simebi = 20;
                // 今月の20日を取得
                $this_month_day = date('Y-m-d', strtotime($current_year . '-' . $current_month . '-' . $simebi . ''));
                $before_simebi = $simebi + 1;
                // 先月の21日を取得
                $last_month_day = date('Y-m-d', strtotime($current_year . '-' . $current_month . '-' . $before_simebi . ' last month'));
            }

            // echo "先月の21日: " . $last_month_day . "<br>";
            // echo "今月の20日: " . $this_month_day;

            //if($current_month<10) $current_month = '0'.$current_month;
            //$date = $current_year.'-'.$current_month.'-'. $simebi;


            //echo $date;

            // SELECT SUM(money) FROM `request_shift` WHERE userID='6060' AND date BETWEEN '2024-01-20' AND '2024-02-20';


            $sql = $db->query("SELECT SUM(money) FROM `request_shift` WHERE userID='$num' AND date BETWEEN '$last_month_day' AND '$this_month_day'");
            $resister = $sql->fetch();
            $money = $resister['SUM(money)'];
            if (empty($money)) $money = 0;

            // echo '<div>';
            // echo '<input type="submit" id="last_mon" name="last_mon" value="◀ 先月">';
            // echo '<input type="hidden" name="year" value='.$current_year.'>';
            // echo '<input type="hidden" name="cnt" value='.$current_month.'>';
            // echo '</div>';
            // echo '<div id="money">';
            // echo '<script type="text/javascript">';
            // echo 'let price1 = '.$money.';';
            // echo "let jpy_price1 = price1.toLocaleString('ja-JP', {style:'currency', currency: 'JPY'});";
            // echo 'document.write(jpy_price1);';
            // echo '</script>';
            // echo '</div>';
            // echo '<div>';
            // echo '<input type="submit" id="next_mon" name="next_mon" value="来月 ▶">';
            // echo '</div>';

            echo    '<input type="submit" id = "last_mon" name="last_mon" value="◀ 先月">';
            echo    '<span style="font-size: 45px;">';
            echo    '<script type=text/javascript>';
            echo        'let price1 = ' . $money . ';';
            echo        "let jpy_price1 = price1.toLocaleString('ja-JP', {style:'currency', currency: 'JPY'});";
            echo        'document.write(jpy_price1);';
            echo    '</script>';
            echo     '</span>';
            echo    '<input type="hidden" name="year" value=' . $current_year . '>';
            echo    '<input type="hidden" name="cnt" value=' . $current_month . '>';
            echo    '<input type="submit" id ="next_mon" name="next_mon" value="来月 ▶">';
            echo  '</form>';

            $paymonth = $current_month + 1;
            $payyear = $current_year;

            if ($paymonth == 13) {
                $paymonth = 1;
                $payyear = $payyear + 1;
            }
            if ($payday == "月末") {
                $payday = getLastDayOfMonth($payyear, $paymonth);
            }

            echo '<br><br><h3>お支払い日は、' . $payyear . '年' . $paymonth . '月' . $payday . '日です</h3>';
        } catch (PDOException $e) {
            echo "<div>" + $e->getMessage() + "</div>";
        }


        ?>
        </div>
    </div>
</body>

</html>