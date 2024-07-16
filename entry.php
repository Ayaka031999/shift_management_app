<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>シフト管理ツール</title>
    <link rel="stylesheet" href="CSS/style_entry.css">
</head>
<style>
    html {
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;
    }

    h1 {
        color: rgba(0, 0, 0, 0.705);
        /* メニューのテキスト色 */

    }

    .entry {
        text-align: center;
    }

    label {
        display: inline-block;
        text-align: right;
        width: 150px;
        color: rgba(0, 0, 0, 0.705);
    }

    input {
        margin: auto;
        text-align: center;
        border-radius: 10px;
        padding-top: 10px;
        padding-bottom: 10px;
        padding-left: 10px;
        padding-right: 40px;
        border-color: rgba(0, 0, 0, 0.705);
        border-style: solid;
    }


    header {
        position: fixed;
        width: 100%;
        height: 90px;
        padding-bottom: 0px;
        top: 0;
        left: 0;
        /* background-color: rgb(255, 161, 127);  */
        background-color: #99d8fd;
        /* ヘッダーの背景色  #99d8fd*/
        /* padding: 15px; */
        text-align: left;
        border: none;
        box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);

    }

    header h1 {
        color: rgba(0, 0, 0, 0.705);
        /* メニューのテキスト色 */
        margin-top: 10px;
        margin-left: 20px;
        margin-bottom: 0px;
        padding-bottom: 0px;
    }

    body {
        padding-top: 100px;
    }

    #entry_btn {
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;
        font-size: 20px;
        padding-left: 4em;
        padding-right: 4em;
        padding-top: 1em;
        padding-bottom: 1em;
        color: white;
        background-color: deepskyblue;
        /* border-radius: 10px;  */
        border-style: none;
        border-radius: 100em;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
    }

    #entry_btn:hover {
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;

        font-size: 20px;
        padding-left: 4em;
        padding-right: 4em;
        padding-top: 1em;
        padding-bottom: 1em;
        color: deepskyblue;
        background-color: #fff;
        /* border-radius: 10px;  */
        border: solid 0.5px;
        border-radius: 100em;

        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
    }


    .center {
        width: fit-content;
        margin-left:268px;/*上　右　下　左 */
        padding-bottom: 20px;
    }

    label {
        /* position: absolute;
        top: 50%; */
        display: inline-block;
        width: 200px;
        padding-top: 15px;
        vertical-align: top;
        text-align: right;
        margin-right: 20px;
    }

    .page-right {
        display: inline-block;
        height: 27px;
        font-size: 15px;
        padding-top: 10px;
        padding-left: 10px;
        padding-bottom: 0px;
        margin: 0px;
        width: 100%;
        background-color: antiquewhite;
        border: none;

    }

    .birthday_input {
        width: 162px;
    }
</style>

<?php

$db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");



$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = $db->query("SELECT userID FROM member");
$members = $sql->fetchAll(PDO::FETCH_ASSOC);

// データが正しく取得されているか確認
// print_r($members);

echo "<script>";
echo "const members = " . json_encode($members) . ";";
echo "</script>";

?>

<header>
    <h1>シフト管理</h1>
    <div class="page-right"><a href="login.php">ログイン画面</a>-><a>新規登録画面</a>
        <div>
</header>



<body>

    <div class=entry align=center>
        <h1 align=center>新規登録</h1>
        <form action='check.php' method="post" accept-charset="UTF-8">
            <div class="center">
                <label>ユーザーID</label>
                <input align=center type="number" name="userID" id="message-input" oninput="validateNumber()" min="0" step="1" class='userID' onchange="IDcheck()" required /><br>
                <span id="hint" style="font-size:11px; color:red; margin-bottom: 5px; margin-left:170px; ">※4桁の数字を入力してください</span><br>
                <label>名前</label>
                <input type="text" name="name" id="message-input" required /><br><br>
                <label>生年月日</label>
                <input type="date" name="birthday" class="birthday_input" id="message-input" required /><br><br>
                <label>メールアドレス</label>
                <input type="email" name="email" id="message-input" required /><br>
                <span style="font-size:11px; color:red; margin-bottom: 5px; margin-left:170px; ">※gmailのアドレスを入力してください</span><br>
                <label>電話番号</label>
                <input type="tel" name="tel" id="message-input" required /><br><br>


                <div class="form-group">
                    <label>パスワード</label>
                    <input type="password" class="form-control" name="password" id="password" oninput="passNumber()" required><br>
                    <span id="passhint" style="font-size:11px; color:red;  margin-bottom: 5px; margin-left:190px; ">※4桁以上8桁以下で入力してください</span><br>
                </div>
                <div class="form-group">
                    <label>パスワード (再確認)</label>
                    <input type="password" class="form-control" name="confirm" oninput="CheckPassword(this)" required>
                </div>
            </div>
            <!-- <label>パスワード</label>
        <input type = "password" name="password_1" id="message-input" required /><br><br>
        <label>パスワード(確認用)</label>
        <input type = "password" name="password_2" id="message-input"  oninput="CheckPassword(this)" required /><br><br> -->
            <button type="submit" id="entry_btn" name="entry">確認画面へ</button>
            <!-- <button type="submit">登録</button> -->
            <!-- <input type="submit" value="登録"> -->
        </form>
    </div>

    <script>
        const form = document.getElementById("message-input")
        const button = document.getElementById("entry_btn")
        button.disabled = true;
        // button.classList.add('is-inactive');

        form.addEventListener("input", update)
        form.addEventListener("change", update)

        function update() {
            const isRequired = form.checkValidity()

            if (isRequired) {
                button.disabled = false;
                // alert('値を入力してください');
                // button.classList.remove('is-inactive');
                // button.classList.add('is-active');
                return
            } else {

                button.disabled = true;
                // button.classList.remove('is-active');
                // button.classList.add('is-inactive');
            }
        }

        function CheckPassword(confirm) {
            // 入力値取得
            var input1 = password.value;
            var input2 = confirm.value;
            // パスワード比較
            if (input1 != input2) {
                confirm.setCustomValidity("入力値が一致しません。");
            } else {
                confirm.setCustomValidity('');
            }
        }

        function IDcheck() {
            let userID = document.getElementsByClassName('userID')[0].value;
            let hint = document.getElementById('hint');


            members.forEach(function(member) {
                // 各メンバーのuserIDと検索対象のuserIDを比較し、一致するものがあるかを確認する
                if (member.userID == userID) {
                    alert('このユーザーIDは既に登録されています。');
                    document.getElementsByClassName('userID')[0].value = '';
                    hint.style.display = 'inline';

                    // 一致した場合は処理を終了する
                    return;
                }
            });
        }

        function validateNumber() {
            let userID = document.getElementsByClassName('userID')[0];
            let hint = document.getElementById('hint');
            let maxDigits = 4; // 最大桁数

            if (userID.value.length > 0) {
                // ユーザーが何か入力したら、補足テキストを非表示にする
                hint.style.display = 'none';
                if (userID.value.length > maxDigits) {
                    // 最大桁数を超える場合は、値を修正する
                    userID.value = userID.value.slice(0, maxDigits);
                }

            } else {
                // 入力が空の場合は、補足テキストを再表示する
                hint.style.display = 'inline';
            }
        }

        function passNumber() {
            let passInput = document.getElementById('password');
            let passhint = document.getElementById('passhint');
            let min = 4; // 最小桁数
            let max = 8; // 最大桁数

            if (passInput.value.length >= min && passInput.value.length <= max) {
                // 入力が条件を満たしている場合
                passhint.style.display = 'none'; // 補足テキストを非表示にする
            } else {
                // 入力が条件を満たしていない場合
                passhint.style.display = 'inline'; // 補足テキストを表示する
            }

            // 入力が8桁を超えた場合は、入力値を8桁までに修正する
            if (passInput.value.length > max) {
                passInput.value = passInput.value.slice(0, max);
            }
        }
    </script>

    <?php

    if (isset($_POST['entry'])) {
       $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");


        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $db->query("SELECT userID FROM member");
        $member = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach ($member as $mem) {
            if ($mem['userID'] == $_POST['userID']) {
                $alert = "<script type='text/javascript'>alert('このユーザーIDは既に登録されています。');</script>";
                echo $alert;
            }
        }
    }



    ?>

</body>

</html>