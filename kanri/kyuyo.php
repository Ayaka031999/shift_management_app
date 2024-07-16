<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="CSS/kyuyo.css">
    <title>Document</title>
</head>
<style>
    h1 {
        margin-bottom: 10px;
    }

    .center {
        width: fit-content;
        margin: auto;
        padding-bottom: 20px;
    }

    label {
        /* position: absolute;
        top: 50%; */
        font-size: 17px;

        display: inline-block;
        width: 200px;
        vertical-align: top;
        text-align: right;
        margin-right: 20px;
    }

    .kyu_input {
        margin-left: -108px;
    }

    input {
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;
        font-size: 17px;

    }

    .update {
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;
        font-size: 17px;
        color: rgba(0, 0, 0, 0.76);
        border: solid 0.5px;
        border-radius: 40px;
        background-color: #fff0f5;
        padding: 20px 50px;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        margin-right: 10px;
        cursor: pointer;
    }

    .update:hover {
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;
        font-size: 17px;
        color: rgba(0, 0, 0, 0.76);
        border: solid 0.5px;
        border-radius: 40px;
        background-color: #fff;
        padding: 20px 50px;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        margin-right: 10px;
        cursor: pointer;
    }

    .separator {
        margin-top: 30px
    }
</style>

<body>

    <?php

    //セッションを使うことを宣言
    session_start();

    //ログインされていない場合は強制的にログインページにリダイレクト
    if (!isset($_SESSION["login_name"])) {
        header("Location: login.php");
        exit();
    }

    //ログインされている場合は表示用メッセージを編集
    $myname = $_SESSION['login_name'];
    $num = $_SESSION['login_ID'];

    // echo $num;
    // echo "{$myname}さん<br><br>"; 

   $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");


    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    ?>

    <header>
        <h1><a href="kanri_top.php" target="_top">シフト管理</a></h1><?php echo '👤' . $num . ' ' . $myname . 'さん'; ?>
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

                    $i = filter_input(INPUT_POST, "logout");

                    if (isset($i)) {
                        $_SEESSION = array();
                        session_destroy();
                        header("Location: ../login.php");
                        exit();
                    }

                    ?>
                </p>
        </ul>
    </header>
    <div class="separator">


        <script>
            function handleInput(inputId) {
                var inputElement = document.getElementById(inputId);
                var inputValue = parseFloat(inputElement.value);

                // 入力が範囲外の場合はクリアする
                if (inputValue <= 0 || inputValue > 31) {
                    alert('正の数かつ31以下の値を入力してください。');
                    inputElement.value = '';
                }
            }

            function setupInputValidation(inputId, checkboxId) {
                // テキスト入力に対してイベントリスナーを設定
                document.getElementById(inputId).addEventListener('input', function() {
                    document.getElementById(checkboxId).checked = false;
                    handleInput(inputId);
                });

                // チェックボックスがクリックされた場合に実行される関数
                document.getElementById(checkboxId).addEventListener('click', function() {
                    document.getElementById(inputId).value = '';
                });
            }
        </script>

        <?php
        $sql = 'SELECT * from 給料関係設定';
        $stmt = $db->query($sql);
        $resister = $stmt->fetch();

        // foreach ($resister as $result) :
            //echo $result['userID'].'<br>';
            $salary =  $resister['給料額'];
            $parsent =  $resister['残業代割増率'];
            $simebi =   $resister['給料締め日'];
            $payday =  $resister['給料日'];
        // endforeach;

        


        //もうすでに値が登録されていれば
        if (isset($salary) && isset($simebi) && isset($payday)) {
            $simebiValue = ($simebi === '月末') ? 'checked' : $simebi;
            $paydayValue = ($payday === '月末') ? 'checked' : $payday;
        ?>

            <div align=center>
                <h1>給与額設定</h1>

                <form method="post" class="center">
                    <div class="kyu_input"><label for="salary">給料額：時給</label><input type="number" id="salary" name="salary" value="<?= $salary; ?>">円</div><br>
                    <div class="kyu_input"><label for="parsent">法定外残業代の割増率：</label><input type="number"  min="25" max="50" id="parsent" name="parsent" value="<?= $parsent; ?>">%</div><br>
                    <?php
                        // echo $parsent;
                        $kari = $parsent+100;
                        $zangyou = $salary*($kari/100);
                    ?>

                    <div class="kyu_input"><label for="zangyo">残業代：時給</label><input type="number"  id="zangyo" name="zangyo" value="<?= $zangyou ?>" readonly>円</div><br>

                    <label for="simebi">給料締め日：毎月</label><input type="number" id="simebi" name="simebi" value="<?= $simebiValue; ?>" id="simebiInput">日
                    または
                    <input type="checkbox" name="simebi" value="月末" id="simebiEnd" <?= ($simebi === '月末') ? 'checked' : ''; ?>>月末<br><br>
                    <label for="payday">給料日：毎月</label><input type="number" id="payday" name="payday" value="<?= $paydayValue; ?>" id="paydayInput">日
                    または
                    <input type="checkbox" name="payday" value="月末" id="paydayEnd" <?= ($payday === '月末') ? 'checked' : ''; ?>>月末<br><br>
                    <input class="update" type="submit" name="kyuup" value="更新"><br>
                </form>
            </div>

            <script>
                // 給与日の入力フィールドと関連するチェックボックスのセットアップ
                setupInputValidation('simebiInput', 'simebiEnd');

                // 給与日の入力フィールドと関連するチェックボックスのセットアップ
                setupInputValidation('paydayInput', 'paydayEnd');
            </script>

            <?php

            $kyuup = filter_input(INPUT_POST, "kyuup");

            if (isset($kyuup)) {

                $salary = filter_input(INPUT_POST, "salary");
                $parsent = filter_input(INPUT_POST, "parsent");
                $simebi = filter_input(INPUT_POST, "simebi");
                $payday = filter_input(INPUT_POST, "payday");

                echo $$simebi;

                $sql = 'UPDATE 給料関係設定 SET 給料額=:salary, 残業代割増率=:parsent,給料締め日=:simebi, 給料日=:payday WHERE userID=:userID';
                $stmt = $db->prepare($sql);

                // プリペアドステートメントにバインド
                $stmt->bindParam(':userID', $num);
                $stmt->bindParam(':salary', $salary);
                $stmt->bindParam(':parsent', $parsent);
                $stmt->bindParam(':simebi', $simebi);
                $stmt->bindParam(':payday', $payday);

                // ステートメントを実行
                $con = $stmt->execute();
                if ($con) {
                    $alert = "<script type='text/javascript'>alert('登録完了');</script>";
                    echo $alert;
            ?>


                    <script type='text/javascript'>
                        // アラートを表示した後に実行
                        window.onload = function() {
                            // ページ遷移
                            window.location.href = 'kyuyo.php';
                        };
                    </script>


            <?php
                } else {
                    $alert = "<script type='text/javascript'>alert('登録できませんでした');</script>";
                    echo $alert;
                }
            }
        } else { //まだ値が未登録の場合

            ?>


            <form method="post">
                給料額：月額<input type="number" name="salary">円<br>
                <div class="kyu_input"><label for="parsent">法定外残業代の割増率：</label><input type="number"  min="25" max="50" id="parsent" name="parsent" value="<?= $parsent; ?>">%</div><br>
                <?php
                    echo $parsent;
                    $kari = $parsent+100;
                    $zangyou = $salary*($kari/100);
                ?>
                <div class="kyu_input"><label for="zangyo">残業代：時給</label><input type="number"  id="zangyo" name="zangyo" value="<?=  $zangyou?>" readonly>円</div><br>

                給料締め日：毎月<input type="number" name="simebi" id="simebiInput">日 または <input type="checkbox" name="simebi" value="月末" id="simebiEnd">月末<br><br>
                給料日：毎月<input type="number" name="payday" id="paydayInput">日 または <input type="checkbox" name="payday" value="月末" id="paydayEnd">月末<br>
                <input type="submit" name="kyucomp" value="送信"><br>
            </form>

    </div>

    <script>
        // 給与日の入力フィールドと関連するチェックボックスのセットアップ
        setupInputValidation('simebiInput', 'simebiEnd');
        // 給与日の入力フィールドと関連するチェックボックスのセットアップ
        setupInputValidation('paydayInput', 'paydayEnd');
    </script>

    <?php

            $kyucomp = filter_input(INPUT_POST, "kyucomp");

            if (isset($kyucomp)) {

                $salary = filter_input(INPUT_POST, "salary");
                $parsent = filter_input(INPUT_POST, "parsent");
                $simebi = filter_input(INPUT_POST, "simebi");
                $payday = filter_input(INPUT_POST, "payday");

                $sql = 'INSERT INTO 給料関係設定(userID, 給料額, 残業代割増率,給料締め日, 給料日) VALUES (:userID, :salary,:parsent :simebi, :payday)';
                $stmt = $db->prepare($sql);

                // プリペアドステートメントにバインド
                $stmt->bindParam(':userID', $num);
                $stmt->bindParam(':salary', $salary);  // ':給料額' から ':salary' に修正
                $stmt->bindParam(':parsent', $parsent);  // ':給料額' から ':salary' に修正
                $stmt->bindParam(':simebi', $simebi);  // ':給料締め日' から ':simebi' に修正
                $stmt->bindParam(':payday', $payday);  // ':給料日' から ':payday' に修正

                // ステートメントを実行
                $con = $stmt->execute();
                if ($con) { //登録完了
                    $alert = "<script type='text/javascript'>alert('登録完了');</script>";
                    echo $alert;
    ?>

            <script type='text/javascript'>
                // アラートを表示した後に実行
                window.onload = function() {
                    // ページ遷移
                    window.location.href = 'kyuyo.php';
                };
            </script>

<?php
                } else { //登録できなかった
                    $alert = "<script type='text/javascript'>alert('登録できませんでした');</script>";
                    echo $alert;
                }
            }
        }

?>






</body>

</html>