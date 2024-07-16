<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="CSS/simekiri.css">
    <title>Document</title>
</head>

<body>

    <?php

    //セッションを使うことを宣言
    session_start();

    // //ログインされていない場合は強制的にログインページにリダイレクト
    // if (!isset($_SESSION["login_name"])){
    //     header("Location: login.php");
    //     exit();
    // }

    //ログインされている場合は表示用メッセージを編集
    $myname = $_SESSION['login_name'];
    $num = $_SESSION['login_ID'];

    // if($message != "admin" || $num != "123456"){
    //     header("Location: ../login.php");
    //     exit();
    // }


    // echo $num;
    // echo "{$myname}さん<br><br>"; 

    $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    ?>
    <style>
        /* .right{
        text-align: right;
        margin-top: 30px;
        margin-right: 100px;
        font-size: 17px;
    }

    .left{
        text-align: left;
        margin-top: 30px;
        margin-left: 100px;
        font-size: 17px;

    } */



        #simekiri {
            font-family: "游ゴシック", "Yu Gothic";
            font-weight: bold;
            font-size: 17px;
            width: 209px;

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

        .center {
            width: fit-content;
            margin: auto;
            padding-bottom: 20px;
            text-align: center;
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

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
        }

        .separator {
            height: 100%;
            /* border-left: 2px solid #ccc; */
            margin: 0 20px;
        }

        .content {
            width: 50%;
            padding: 0 20px;
            text-align: center;
        }

        .content p {
            font-size: 18px;
            line-height: 1.6;
            margin-top: 20px;
        }

        .miteisyutu{
            text-align:center; 
            width:200px;
            border-collapse: collapse;
        }


    </style>

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

    <div class="container">
        <div class="content">

        <h1>締め切り設定画面</h1><!-- align=center style="margin-bottom:20px;" -->

            <?php

            $sql = 'SELECT * from シフト提出日 ORDER BY 日付 DESC';
            $stmt = $db->query($sql);
            $resister = $stmt->fetchAll();

            // foreach ($resister as $result) :
            // //   echo $result['userID'].'<br>';
            // echo 'しめきり:' . $result['日付'] . '<br>';
            // // $aru_simekiri = $result['日付'];
            // endforeach;

            ?>
            <form method="post"><!--class="center"-->
                <!-- <label for="name">送信者：</label><input style="border:none; outline:none; font-size:17px;" id="name" type="text" value="<?= $myname; ?>" readonly/><br>   -->
                <div style="padding-right:120px;"><label for="simekiri" style="width:100px; ">しめきり：</label><input id="simekiri" style="text-align:center;" type="date" name="simekiri"></div><br><br>
                <input type="submit" class="update" name="comp" value="送信">
            </form><br><br>

            <?php
            $comp = filter_input(INPUT_POST, "comp");

            if (isset($comp)) {
                $simekiri = filter_input(INPUT_POST, "simekiri");
                $formattedDate = date('Y-m-d H:i:s', strtotime($simekiri));

                //シフト提出日を挿入
                $sql = 'INSERT INTO シフト提出日(userID,日付) VALUES (:userID, :hiniti)';
                $stmt = $db->prepare($sql);

                $stmt->bindParam(':userID', $num);  // もし数字なら INT にしてください
                $stmt->bindParam(':hiniti', $formattedDate);

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
                            window.location.href = 'simekiri.php';
                        };
                    </script>

            <?php
                } else {
                    $alert = "<script type='text/javascript'>alert('登録できませんでした');</script>";
                    echo $alert;

                    // エラーメッセージを表示
                    $errorInfo = $stmt->errorInfo();
                    echo "エラーメッセージ: " . $errorInfo[2];
                }
            }
            ?>

        </div>
        <div class="separator"></div>
        <div class="content">
            <?php
            $nowMonth = date('Y-m');
           // echo $nowMonth.'<br>';

             $mon = $nowMonth.'-%';
            
            // // echo $nowMonth.'-%';

            // ///echo $mon.'<br>';

            $sql = "SELECT DISTINCT u.userID,u.name FROM `member` u WHERE u.name NOT IN ( SELECT DISTINCT rs.name FROM `request_shift` rs WHERE rs.date LIKE '$mon' )";
            $stmt = $db->query($sql);
            $resister = $stmt->fetchAll();
        ?>

        <div align="center">
        <table border="2" class="miteisyutu">
            <caption><?=$nowMonth?>シフト未提出者</caption>
            <thead style="background-color:aquamarine;">
                <th>ユーザーID</th>
                <th>名前</th>
            </thead>
            <tbody>
            <?php
            foreach($resister as $result){
                echo '<tr>';
                echo '<td>'.$result['userID'].'</td>';
                echo '<td>'.$result['name'].'</td>';
                echo '</tr>';
            }
            ?>

            </tbody>
        </table>
        </div>



        </div>
    </div>



</body>

</html>