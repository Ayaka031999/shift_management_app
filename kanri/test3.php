<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    html {
        -webkit-font-family: "游ゴシック", "Yu Gothic";
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;
    }

    h2 {
        margin-bottom: 0px;
    }

    .myTable {
        -webkit-font-family: "游ゴシック", "Yu Gothic";
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;

        border-collapse: collapse;
        border-width: 0.5px;
        margin-bottom: 20px;

    }

    .myTable input {
        -webkit-font-family: "游ゴシック", "Yu Gothic";
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;


    }

    .update_btn {
        font-family: "游ゴシック", "Yu Gothic";
        font-weight: bold;
        color: rgba(0, 0, 0, 0.76);
        border: solid 0.5px;
        border-radius: 30px;
        background-color: #fff0f5;
        padding: 10px 30px;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        margin-right: 10px;
    }
</style>

<body>


    <?php


    // セッションを開始
    session_start();

    if (isset($_SESSION['youbiname'])) {
        $youbiname = $_SESSION['youbiname'];
    }

    echo '<h2 align=center>' . $youbiname . '曜日</h2>';

    try {

    
    
    // $maxPositions['朝'] = isset($_POST['Asa_data']) ? $_POST['Asa_data'] :  1;
    // $maxPositions['昼'] = isset($_POST['Hiru_data']) ? $_POST['Hiru_data'] :  1;
    // $maxPositions['夜'] = isset($_POST['Yoru_data']) ? $_POST['Yoru_data'] :  1;



    // foreach ($daytime as $onetime) {
    //     $maxPositions[$onetime] = 0;
    // }

?>

<?php

   
        $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");


        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $daytime = array('朝', '昼', '夜');
        $maxPositions = array(); // 各時間帯ごとの最大ポジション数を格納する配列

        foreach ($daytime as $onetime) {
            // SQLクエリの実行
            $stmt = $db->prepare("SELECT MAX(ポジション) FROM １日当たり必要人数 WHERE 曜日='$youbiname' AND 時間='$onetime'");
            $stmt->execute();
            $resister = $stmt->fetch(PDO::FETCH_ASSOC);

            // 最大ポジション数を配列に格納
            $maxPositions[$onetime] = $resister['MAX(ポジション)'];

            // デバッグ用に最大ポジション数を出力
            //echo $onetime . ':' . $maxPositions[$onetime] . '<br>';
        }

        //ここの数値を変えれば、いくらでも行数はかえられる
        // $maxPositions['朝'] = 3;
        // $maxPositions['昼'] =4;
        // $maxPositions['夜'] = 3;
?>

<!-- <form method="post">
    朝:<input type="number" id="RowNumber" name="AsaRow" value="<?=(isset($_POST['AsaRow'])?$_POST['AsaRow']:$maxPositions['朝'])?>">
    昼:<input type="number" id="RowNumber" name="HiruRow" value="<?=(isset($_POST['HiruRow'])?$_POST['HiruRow']:$maxPositions['昼'])?>">
    夜:<input type="number" id="RowNumber" name="YoruRow" value="<?=(isset($_POST['YoruRow'])?$_POST['YoruRow']:$maxPositions['夜'])?>">
    <input type="submit" name="rowbtn">
</form>

<script>
    function numberRange(){
        document.getElementById("RowNumber").value 
    }
</script> -->





<?php
        // if(isset($_POST['rowbtn'])){
        //     echo 'Rowかえた';
        //     if($maxPositions['朝']>= $_POST['AsaRow']){
        //         $maxPositions['朝'] = $_POST['AsaRow'];
        //     }
        //     if($maxPositions['昼'] >= $_POST['HiruRow']){
        //         $maxPositions['昼'] = $_POST['HiruRow'];
        //     }
        //     if($maxPositions['夜'] = $_POST['YoruRow']){
        //         $maxPositions['夜'] = $_POST['YoruRow'];
        //     }

        // }


        // SQLクエリの実行
        $stmt = $db->prepare("SELECT * FROM １日当たり必要人数 WHERE 曜日='$youbiname'");
        $stmt->execute();
        $resister = $stmt->fetchAll(PDO::FETCH_ASSOC);

        /*function timeChange($nameId, $dataSet)
        {   //もしデータがあれば
            if (isset($dataSet)) {
                // echo $dataSet;
                $arrayTime = explode(":", $dataSet);
                //name="朝_時間帯_始" id="朝_時間帯_始"
                echo '<select name="hour" id="hour" style="font-size:17px;" onchange="selectChange()">';
                echo '<option value="">--</option>';
                for ($i = 0; $i < 24; $i++) {
                    if ($i < 10) $i = '0' . $i;
                    if ($arrayTime[0] === $i) {
                        echo '<option style="font-size:17px;" value="' . $i . '" selected>' . $i . '</option>';
                    } else {
                        echo '<option style="font-size:17px;" value="' . $i . '">' . $i . '</option>';
                    }
                }
                echo '</select>';
                echo '<span>:</span>';
                echo '<select name="minute" id="minute" style="font-size:17px;" onchange="selectChange()">';
                echo '<option value="">--</option>';
                for ($k = 0; $k <= 45; $k += 15) {
                    if ($k < 10) $k = '0' . $k;
                    if ($arrayTime[1] === $k) {
                        echo '<option style="font-size:17px;" value="' . $k . '" selected>' . $k . '</option>';
                    } else {
                        echo '<option style="font-size:17px;" value="' . $k . '">' . $k . '</option>';
                    }
                }
                echo '</select>';
    ?>
                <script>
                    function selectChange() {
                        let hour = document.getElementById('hour').value;
                        let minute = document.getElementById('minute').value;
                        let time = hour + ':' + minute;
                        console.log(time);
                    }
                </script>
            <?php
            } else { //データ未登録

                echo '<select name="hour" style="font-size:17px;">';
                echo '<option value="" selected>--</option>';
                for ($i = 0; $i < 24; $i++) {
                    if ($i < 10) $i = '0' . $i;
                    echo '<option style="font-size:17px;" value="' . $i . '">' . $i . '</option>';
                }
                echo '</select>';
                echo '<span>:</span>';
                echo '<select name="minute" style="font-size:17px;">';
                echo '<option value="" selected>--</option>';
                for ($k = 0; $k <= 45; $k += 15) {
                    if ($k < 10) $k = '0' . $k;
                    echo '<option style="font-size:17px;" value="' . $k . '">' . $k . '</option>';
                }
                echo '</select>';
            }
        } */

        //DBに登録があるかないか
        if (!empty($resister)) {

            // データを連想配列として変換
            $data = array();
            foreach ($resister as $row){
                $data[$row['時間']]['時間帯']['始'] = $row['時間帯_始'];
                $data[$row['時間']]['時間帯']['終'] = $row['時間帯_終'];
                $data[$row['時間']]['ポジション'][$row['ポジション']]['名前'] = $row['ポジション名'];
                $data[$row['時間']]['ポジション'][$row['ポジション']]['必要人数'] = $row['必要人数'];
            }

            // echo '<pre>';
            // print_r($data);
            // echo '</pre>';
            ?>

            <!--     テーブル部分　 はじまり　　-->
            <div align=center>
                <form method="post">
                    <?php
                    $timePeriods = array("朝", "昼", "夜");
                    ?>
                    <table border="2" class="myTable">
                        <thead>
                            <th>時間</th>
                            <th>時間帯</th>
                            <th>ポジション</th>
                            <th>必要人数</th>
                        </thead>
                        <tbody>
                            <?php
                            updateTableRow($data, "朝", $maxPositions['朝']);
                            updateTableRow($data, "昼", $maxPositions['昼']);
                            updateTableRow($data, "夜", $maxPositions['夜']);
                            ?>
                            <tr>
                                <td>総合計時間</td>
                                <td>
                                    <input style="width:20px;" id="Full_StartHour" value="<?= date('H',strtotime($data['総合計']['時間帯']['始'])) ?>" readonly>
                                    <span>:</span>
                                    <input style="width:20px;"  id="Full_StartMinute" value="<?= date('i',strtotime($data['総合計']['時間帯']['始'])) ?>" readonly>
                                    <span>~</span>
                                    <input style="width:20px;"  id="Full_EndHour" value="<?= date('H',strtotime($data['総合計']['時間帯']['終'])) ?>" readonly>
                                    <span>:</span>
                                    <input style="width:20px;"  id="Full_EndMinute" value="<?= date('i',strtotime($data['総合計']['時間帯']['終'])) ?>" readonly>



                                    <input type="hidden" name="総合計時間帯_始" id="総合計時間帯_始" value="<?= $data['総合計']['時間帯']['始'] ?>" readonly>
                                    <input type="hidden" name="総合計時間帯_終" id="総合計時間帯_終" value="<?= $data['総合計']['時間帯']['終'] ?>" readonly>

                                    <!-- <input type="time" name="総合計時間帯_始" id="総合計時間帯_始" value="<?= $data['総合計']['時間帯']['始'] ?>" readonly>
                                    ~
                                    <input type="time" name="総合計時間帯_終" id="総合計時間帯_終" value="<?= $data['総合計']['時間帯']['終'] ?>" readonly> -->
                                </td>
                                <td>総合計人数</td>
                                <td>
                                    <!-- <input type="number" name="総合計人数" value="// isset($_POST["総合計人数"]) ? $_POST["総合計人数"] : '' ?>"> -->
                                    <input type="number" name="総合計人数" id="総合計人数" value="<?= $data['総合計']['ポジション'][1]['必要人数'] = $row['必要人数'] ?>">
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- <input type="hidden" name="youbiname" value=<$youbiname?>> -->

                    <input class="update_btn" id="updateButton" type="submit" name='updateSend' value="更新">
                </form>
            </div>

            <!--     テーブル部分　 おわり　　-->
            <?php
            //テーブルを配列に格納
            function processData($time, $postData, $maxJ)
            {
                $array = [];
                $sum = 0;

                $array["時間帯"]["始"] = $postData[$time . "_時間帯_始"];
                $array["時間帯"]["終"] = $postData[$time . "_時間帯_終"];

                for ($j = 1; $j <= $maxJ; $j++) {

                    $array["ポジション"][$j]["名前"] = $postData[$time . "_ポジション_" . $j];
                    $array["ポジション"][$j]["必要人数"] = $postData[$time . "_必要人数_" . $j];
                    // $sum += $array["ポジション"][$j]["必要人数"] = $postData[$time . "_必要人数_" . $j];
                }

                // if($j == $maxJ){
                $array["ポジション"][$maxJ + 1]["名前"] = "合計";
                $array["ポジション"][$maxJ + 1]["必要人数"] = $postData[$time . "_合計"];
                //     break;
                // }

                return $array;
            }


            // フォームからのデータを取得
            // if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['updateSend'])) {
                $postData = $_POST;
                // 多次元連想配列にデータを格納
                $result = array();
                $timePeriods = array("朝", "昼", "夜");

                $result["朝"] = processData("朝", $postData, $maxPositions['朝'] - 1);
                $result["昼"] = processData("昼", $postData, $maxPositions['昼'] - 1);
                $result["夜"] = processData("夜", $postData, $maxPositions['夜'] - 1);

                // 総合計時間と総合計人数を格納
                // $result["総合計"]["時間帯"]["始"] = $postData["総合計時間帯_始"];
                $result["総合計"]["時間帯"]["始"] = $postData["朝_時間帯_始"];

                // $result["総合計"]["時間帯"]["終"] = $postData["総合計時間帯_終"];
                $result["総合計"]["時間帯"]["終"] = $postData["夜_時間帯_終"];


                $result["総合計"]["ポジション"][1]["名前"] = "総合計人数";
                $result["総合計"]["ポジション"][1]["必要人数"] = $postData["総合計人数"];

                $i = $maxPositions['朝'] + $maxPositions['昼'] + $maxPositions['夜'] + 1;

                // 配列の内容を表示
                echo '<pre>';
                print_r($result);
                echo '</pre>';
                
                
                try {
                    // データベースへの接続
                    $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");

                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $youbi = $youbiname;
                    $con = 0;

                    // DELETE文の作成
                    $deleteSql = "DELETE FROM １日当たり必要人数 WHERE 曜日 = :youbi";

                    // ステートメントの準備と実行
                    $deleteStmt = $db->prepare($deleteSql);
                    $deleteStmt->bindParam(':youbi', $youbi);
                    $deleteStmt->execute();

                    $con = 0;


                    // データベースに登録
                    foreach ($result as $day => $values) {
                        $startTime = $values["時間帯"]["始"];
                        $endTime = $values["時間帯"]["終"];
                        $totalPeople = 0; // 初期値を0に設定

                        // データベースにデータを挿入するSQLクエリを構築
                        $sql = "INSERT INTO １日当たり必要人数 (曜日, 時間, 時間帯_始, 時間帯_終, ポジション, ポジション名, 必要人数) VALUES (:youbi, :day, :startTime, :endTime, :position, :positionName, :requiredPeople)"; // ON DUPLICATE KEY UPDATE 時間 = :day, 時間帯_始 = :startTime, 時間帯_終 = :endTime, ポジション = :position, ポジション名 = :positionName, 必要人数 = :requiredPeople";

                        //$sql = "UPDATE １日当たり必要人数 SET 曜日=:youbi ,時間 = :day, 時間帯_始 = :startTime, 時間帯_終 = :endTime, ポジション = :position, ポジション名 = :positionName, 必要人数 = :requiredPeople";

                        $stmt = $db->prepare($sql);
                        $stmt->bindParam(':youbi', $youbi);
                        $stmt->bindParam(':day', $day);
                        $stmt->bindParam(':startTime', $startTime);
                        $stmt->bindParam(':endTime', $endTime);
                        $stmt->bindParam(':position', $position);
                        $stmt->bindParam(':positionName', $positionName);
                        $stmt->bindParam(':requiredPeople', $requiredPeople);

                        // ポジションごとのデータを挿入
                        if (isset($values["ポジション"]) && is_array($values["ポジション"])) {
                            foreach ($values["ポジション"] as $position => $positionData) {
                                $positionName = $positionData["名前"];
                                $requiredPeople = $positionData["必要人数"];

                                // データベースにデータを挿入
                                $con += $stmt->execute();
                            }
                        }
                    }

                    //echo $con;
                    echo $i;

                    if ($con == $i) {
                        $alert = "<script type='text/javascript'>alert('登録完了');</script>";
                        echo $alert;
            ?>

                        <!-- <input type="hidden" name="youbiname" value=> -->

                        <script type='text/javascript'>
                            // アラートを表示した後に実行
                            window.onload = function() {
                                // ページ遷移
                                window.location.href = 'test3.php';
                            };
                        </script>
            <?php
                    } else { //登録できなかった
                        $alert = "<script type='text/javascript'>alert('登録できませんでした');</script>";
                        echo $alert;
                    }


                    echo "データが正常に挿入されました。";
                } catch (PDOException $e) {
                    echo "エラー: " . $e->getMessage();
                }
            }

            

            ?>





        <?php

        } 
    //     else {


    //         ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    //         ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    //         ////                                                                                                   ////
    //         ////                                                                                                   ////
    //         ////                                                                                                   ////
    //         ////                    新規データ挿入時                                                                ////
    //         ////                                                                                                   ////
    //         ////                                                                                                   ////
    //         ////                                                                                                   ////
    //         ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    //         ///////////////////////////////////////////////////////////////////////////////////////////////////////////



    //         $AsaData = isset($_POST['Asa_data']) ? $_POST['Asa_data'] :  0;
    //         $HiruData = isset($_POST['Hiru_data']) ? $_POST['Hiru_data'] :  0;
    //         $YoruData = isset($_POST['Yoru_data']) ? $_POST['Yoru_data'] :  0;
    //     ?>

             <!-- <form method=post>
                 <label for="input_rows">朝：</label>
                 <input type="number" id="input_rows" name="Asa_data" value="<?= $AsaData ?>">

                 <label for="input_rows">昼：</label>
                 <input type="number" id="input_rows" name="Hiru_data" value="<?= $HiruData ?>">

                 <label for="input_rows">夜：</label>
                 <input type="number" id="input_rows" name="Yoru_data" value="<?= $YoruData ?>">
                 <input type="submit" name="rowcomp">
             </form> -->



             <!--     テーブル部分　 はじまり　　-->

             <!-- <form method="post"> -->
                 <?php
    //             $timePeriods = array("朝", "昼", "夜");
    //             ?>
    <!-- //             <table border="2" class="myTable">
    //                 <thead>
    //                     <th>時間</th>
    //                     <th>時間帯</th>
    //                     <th>ポジション</th>
    //                     <th>必要人数</th>
    //                 </thead>
    //                 <tbody>

    //                     <?php 
    //                     generateTableRow("朝", $AsaData);
    //                     generateTableRow("昼", $HiruData);
    //                     generateTableRow("夜", $YoruData);
    //                     ?>
    //                     <tr>
    //                         <td>総合計時間</td>
    //                         <td>
    //                         <input style="width:20px;" id="Full_StartHour" value="<?= isset($_POST["総合計時間帯_始"]) ? date('H',strtotime($_POST["総合計時間帯_始"])) : '' ?>" readonly>
    //                         <span>:</span>
    //                         <input style="width:20px;"  id="Full_StartMinute" value="<?= isset($_POST["総合計時間帯_始"]) ? date('i',strtotime($_POST["総合計時間帯_始"])) : '' ?>" readonly>
    //                         <span>~</span>
    //                         <input style="width:20px;"  id="Full_EndHour" value="<?= isset($_POST["総合計時間帯_終"]) ? date('H',strtotime($_POST["総合計時間帯_終"])) : '' ?>" readonly>
    //                         <span>:</span>
    //                         <input style="width:20px;"  id="Full_EndMinute" value="<?= isset($_POST["総合計時間帯_終"]) ? date('i',strtotime($_POST["総合計時間帯_終"])) : '' ?>" readonly>



    //                         <input type="hidden" name="総合計時間帯_始" id="総合計時間帯_始" value="<?= isset($_POST["総合計時間帯_始"]) ? $_POST["総合計時間帯_始"] : '' ?>" readonly>
    //                         <input type="hidden" name="総合計時間帯_終" id="総合計時間帯_終" value="<?= isset($_POST["総合計時間帯_終"]) ? $_POST["総合計時間帯_終"] : '' ?>" readonly>



    //                             <!-- <input type="time" name="総合計時間帯_始" id="総合計時間帯_始" value="<?= isset($_POST["総合計時間帯_始"]) ? $_POST["総合計時間帯_始"] : '' ?>" readonly>
    //                             ~
    //                             <input type="time" name="総合計時間帯_終" id="総合計時間帯_終" value="<?= isset($_POST["総合計時間帯_終"]) ? $_POST["総合計時間帯_終"] : '' ?>" readonly> -->
                             <!-- </td>
                             <td>総合計人数</td>
                             <td>
                                 <input type="number" name="総合計人数" id="総合計人数" value="0">
                             </td>
                         </tr>
                     </tbody>
                 </table>
                 <input type="hidden" name='AsaRow' value=<?= $AsaData ?>>
                 <input type="hidden" name='HiruRow' value=<?= $HiruData ?>>
                <input type="hidden" name='YoruRow' value=<?= $YoruData ?>>

                 <input type="submit" name='dataSend' value="送信">
             </form> -->



             <!--     テーブル部分　 おわり　　-->



             <?php
    //         //テーブルを配列に格納
    //         function processData($time, $postData, $maxJ)
    //         {
    //             $array = [];
    //             $sum = 0;

    //             $array["時間帯"]["始"] = $postData[$time . "_時間帯_始"];
    //             $array["時間帯"]["終"] = $postData[$time . "_時間帯_終"];

    //             for ($j = 1; $j <= $maxJ; $j++) {

    //                 $array["ポジション"][$j]["名前"] = $postData[$time . "_ポジション_" . $j];
    //                 $array["ポジション"][$j]["必要人数"] = $postData[$time . "_必要人数_" . $j];
    //                 // $sum += $array["ポジション"][$j]["必要人数"] = $postData[$time . "_必要人数_" . $j];
    //             }
    //             $array["ポジション"][$maxJ + 1]["名前"] = "合計";
    //             $array["ポジション"][$maxJ + 1]["必要人数"] = $postData[$time . "_合計"];;

    //             return $array;
    //         }


    //         // フォームからのデータを取得
    //         // if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //         if (isset($_POST['dataSend'])) {
    //             $postData = $_POST;

    //             // 多次元連想配列にデータを格納
    //             $result = array();
    //             $timePeriods = array("朝", "昼", "夜");

    //             $result["朝"] = processData("朝", $postData, $_POST['AsaRow']);
    //             $result["昼"] = processData("昼", $postData, $_POST['HiruRow']);
    //             $result["夜"] = processData("夜", $postData, $_POST['YoruRow']);

    //             // 総合計時間と総合計人数を格納
    //             // $result["総合計"]["時間帯"]["始"] = $postData["総合計時間帯_始"];
    //             $result["総合計"]["時間帯"]["始"] =  $postData["朝_時間帯_始"];

    //             // $result["総合計"]["時間帯"]["終"] = $postData["総合計時間帯_終"];
    //             $result["総合計"]["時間帯"]["終"] = $postData["総合計時間帯_終"];


    //             $result["総合計"]["ポジション"][1]["名前"] = "総合計人数";
    //             $result["総合計"]["ポジション"][1]["必要人数"] = $postData["総合計人数"];

    //             $i = $_POST['AsaRow'] + $_POST['HiruRow'] + $_POST['YoruRow'] + 4;


    //             //配列の内容を表示
    //             echo '<pre>';
    //             print_r($result);
    //             echo '</pre>';


    //             try {
    //                 // データベースへの接続
    //                 $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");


    //                 $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //                 $youbi = $youbiname;
    //                 $con = 0;

    //                 // データベースに登録
    //                 foreach ($result as $day => $values) {
    //                     $startTime = $values["時間帯"]["始"];
    //                     $endTime = $values["時間帯"]["終"];
    //                     $totalPeople = 0; // 初期値を0に設定

    //                     // データベースにデータを挿入するSQLクエリを構築
    //                     $sql = "INSERT INTO １日当たり必要人数 (曜日, 時間, 時間帯_始, 時間帯_終, ポジション, ポジション名, 必要人数) VALUES (:youbi, :day, :startTime, :endTime, :position, :positionName, :requiredPeople) ON DUPLICATE KEY UPDATE 時間 = :day, 時間帯_始 = :startTime, 時間帯_終 = :endTime, ポジション = :position, ポジション名 = :positionName, 必要人数 = :requiredPeople";
    //                     $stmt = $db->prepare($sql);
    //                     $stmt->bindParam(':youbi', $youbi);
    //                     $stmt->bindParam(':day', $day);
    //                     $stmt->bindParam(':startTime', $startTime);
    //                     $stmt->bindParam(':endTime', $endTime);
    //                     $stmt->bindParam(':position', $position);
    //                     $stmt->bindParam(':positionName', $positionName);
    //                     $stmt->bindParam(':requiredPeople', $requiredPeople);

    //                     // ポジションごとのデータを挿入
    //                     if (isset($values["ポジション"]) && is_array($values["ポジション"])) {
    //                         foreach ($values["ポジション"] as $position => $positionData) {
    //                             $positionName = $positionData["名前"];
    //                             $requiredPeople = $positionData["必要人数"];

    //                             // データベースにデータを挿入
    //                             $con += $stmt->execute();
    //                         }
    //                     }
    //                 }


    //                 echo $con;
    //                 echo $i;

    //                 if ($con == $i) {
    //                     $alert = "<script type='text/javascript'>alert('登録完了');</script>";
    //                     echo $alert;
    //         ?>
                         <script type='text/javascript'>
    //                         // アラートを表示した後に実行
    //                         window.onload = function() {
    //                             // ページ遷移
    //                             window.location.href = 'test3.php';
    //                         };
    //                     </script>
     <?php
    //                 } else { //登録できなかった
    //                     $alert = "<script type='text/javascript'>alert('登録できませんでした');</script>";
    //                     echo $alert;
    //                 }



    //                 echo "データが正常に挿入されました。";
    //             } catch (PDOException $e) {
    //                 echo "エラー: " . $e->getMessage();
    //             }
    //         }
    //     } //DB登録あるか分岐

    } catch (PDOException $e) {
        echo "エラー: " . $e->getMessage();
    }


    ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
      var AsaStarthourSelect = document.querySelector('select[name="AsaStarthours"]');
      var AsaStartminuteSelect = document.querySelector('select[name="AsaStartminutes"]');
      var AsaEndhourSelect = document.querySelector('select[name="AsaEndhours"]');
      var AsaEndminuteSelect = document.querySelector('select[name="AsaEndminutes"]');

      var HiruStarthourSelect = document.querySelector('select[name="HiruStarthours"]');
      var HiruStartminuteSelect = document.querySelector('select[name="HiruStartminutes"]');
      var HiruEndhourSelect = document.querySelector('select[name="HiruEndhours"]');
      var HiruEndminuteSelect = document.querySelector('select[name="HiruEndminutes"]');

      var YoruStarthourSelect = document.querySelector('select[name="YoruStarthours"]');
      var YoruStartminuteSelect = document.querySelector('select[name="YoruStartminutes"]');
      var YoruEndhourSelect = document.querySelector('select[name="YoruEndhours"]');
      var YoruEndminuteSelect = document.querySelector('select[name="YoruEndminutes"]');


      //朝
      // 時間の選択肢を生成
      for (var i = 0; i < 24; i++) {
        var hourOption = document.createElement('option');
        hourOption.text = ('0' + i).slice(-2);
        AsaStarthourSelect.appendChild(hourOption);
      }

      for (var i = 0; i < 24; i++) {
        var hourOption = document.createElement('option');
        hourOption.text = ('0' + i).slice(-2);
        AsaEndhourSelect.appendChild(hourOption);
      }


      for (var j = 0; j <= 45; j += 15) {
        var minuteOption = document.createElement('option');
        minuteOption.text = (j < 10 ? '0' : '') + j;
        AsaStartminuteSelect.appendChild(minuteOption);

      }

      for (var j = 0; j <= 45; j += 15) {
        var minuteOption = document.createElement('option');
        minuteOption.text = (j < 10 ? '0' : '') + j;
        AsaEndminuteSelect.appendChild(minuteOption);

      }



      //昼
      // 時間の選択肢を生成
      for (var i = 0; i < 24; i++) {
        var hourOption = document.createElement('option');
        hourOption.text = ('0' + i).slice(-2);
        HiruStarthourSelect.appendChild(hourOption);
      }

      for (var i = 0; i < 24; i++) {
        var hourOption = document.createElement('option');
        hourOption.text = ('0' + i).slice(-2);
        HiruEndhourSelect.appendChild(hourOption);
      }


      for (var j = 0; j <= 45; j += 15) {
        var minuteOption = document.createElement('option');
        minuteOption.text = (j < 10 ? '0' : '') + j;
        HiruStartminuteSelect.appendChild(minuteOption);

      }

      for (var j = 0; j <= 45; j += 15) {
        var minuteOption = document.createElement('option');
        minuteOption.text = (j < 10 ? '0' : '') + j;
        HiruEndminuteSelect.appendChild(minuteOption);

      }

      //夜
      // 時間の選択肢を生成
      for (var i = 0; i < 24; i++) {
        var hourOption = document.createElement('option');
        hourOption.text = ('0' + i).slice(-2);
        YoruStarthourSelect.appendChild(hourOption);
      }

      for (var i = 0; i < 24; i++) {
        var hourOption = document.createElement('option');
        hourOption.text = ('0' + i).slice(-2);
        YoruEndhourSelect.appendChild(hourOption);
      }


      for (var j = 0; j <= 45; j += 15) {
        var minuteOption = document.createElement('option');
        minuteOption.text = (j < 10 ? '0' : '') + j;
        YoruStartminuteSelect.appendChild(minuteOption);

      }

      for (var j = 0; j <= 45; j += 15) {
        var minuteOption = document.createElement('option');
        minuteOption.text = (j < 10 ? '0' : '') + j;
        YoruEndminuteSelect.appendChild(minuteOption);

      }




    });


    document.addEventListener("DOMContentLoaded", function() {
      var AsastartHoursSelect = document.getElementById("AsastartHours");
      var AsastartMinutesSelect = document.getElementById("AsastartMinutes");
      var AsaendHoursSelect = document.getElementById("AsaendHours");
      var AsaendMinutesSelect = document.getElementById("AsaendMinutes");
      var AsaStarttimeRangeInput = document.getElementById("AsaStarttimeRange");
      var AsaEndtimeRangeInput = document.getElementById("AsaEndtimeRange");


      var HirustartHoursSelect = document.getElementById("HirustartHours");
      var HirustartMinutesSelect = document.getElementById("HirustartMinutes");
      var HiruendHoursSelect = document.getElementById("HiruendHours");
      var HiruendMinutesSelect = document.getElementById("HiruendMinutes");
      var HiruStarttimeRangeInput = document.getElementById("HiruStarttimeRange");
      var HiruEndtimeRangeInput = document.getElementById("HiruEndtimeRange");


      var YorustartHoursSelect = document.getElementById("YorustartHours");
      var YorustartMinutesSelect = document.getElementById("YorustartMinutes");
      var YoruendHoursSelect = document.getElementById("YoruendHours");
      var YoruendMinutesSelect = document.getElementById("YoruendMinutes");
      var YoruStarttimeRangeInput = document.getElementById("YoruStarttimeRange");
      var YoruEndtimeRangeInput = document.getElementById("YoruEndtimeRange");


      var FullstartHour = document.getElementById("Full_StartHour");
      var FullstartMinute = document.getElementById("Full_StartMinute");
      var FullendHour = document.getElementById("Full_EndHour");
      var FullendMinute = document.getElementById("Full_EndMinute");


      var FullStarttimeRangeInput = document.getElementById("総合計時間帯_始");
      var FullEndtimeRangeInput = document.getElementById("総合計時間帯_終");




      var updateButton = document.getElementById("updateButton");

      updateButton.addEventListener('click',updateTimeRange);

      

      // select要素の変更を監視し、両方とも値が選択された場合に隠しフィールドの値を設定し、送信ボタンを有効にする
      //////////
      //  朝  //
      //////////
      
      AsastartHoursSelect.addEventListener("change", updateTimeRange);
      AsastartMinutesSelect.addEventListener("change", updateTimeRange);
      AsaendHoursSelect.addEventListener("change", updateTimeRange);
      AsaendMinutesSelect.addEventListener("change", updateTimeRange);

      //////////
      //  昼  //
      //////////
      HirustartHoursSelect.addEventListener("change", updateTimeRange);
      HirustartMinutesSelect.addEventListener("change", updateTimeRange);
      HiruendHoursSelect.addEventListener("change", updateTimeRange);
      HiruendMinutesSelect.addEventListener("change", updateTimeRange);


      //////////
      //  夜  //
      //////////
      YorustartHoursSelect.addEventListener("change", updateTimeRange);
      YorustartMinutesSelect.addEventListener("change", updateTimeRange);
      YoruendHoursSelect.addEventListener("change", updateTimeRange);
      YoruendMinutesSelect.addEventListener("change", updateTimeRange);
        

      function updateTimeRange() {
        //////////
        //  朝  //
        //////////
        var AsastartHours = AsastartHoursSelect.value;
        var AsastartMinutes = AsastartMinutesSelect.value;
        var AsaendHours = AsaendHoursSelect.value;
        var AsaendMinutes = AsaendMinutesSelect.value;

        //////////
        //  昼  //
        //////////
        var HirustartHours = HirustartHoursSelect.value;
        var HirustartMinutes = HirustartMinutesSelect.value;
        var HiruendHours = HiruendHoursSelect.value;
        var HiruendMinutes = HiruendMinutesSelect.value;

        //////////
        //  夜  //
        //////////
        var YorustartHours = YorustartHoursSelect.value;
        var YorustartMinutes = YorustartMinutesSelect.value;
        var YoruendHours = YoruendHoursSelect.value;
        var YoruendMinutes = YoruendMinutesSelect.value;


        if (AsastartHours !== "" || AsastartMinutes !== "" || AsaendHours !== "" || AsaendMinutes !== "" || HirustartHours !== "" || HirustartMinutes !== "" || HiruendHours !== "" || HiruendMinutes !== "" || YorustartHours !== "" || YorustartMinutes !== "" || YoruendHours !== "" || YoruendMinutes !== "") {
          //////////
          //  朝  //
          //////////
          var AsaStarttimeRange = AsastartHours + ":" + AsastartMinutes;
          var AsaEndtimeRange = AsaendHours + ":" + AsaendMinutes;

          //////////
          //  昼  //
          //////////
          var HiruStarttimeRange = HirustartHours + ":" + HirustartMinutes;
          var HiruEndtimeRange = HiruendHours + ":" + HiruendMinutes;

          //////////
          //  夜  //
          //////////
          var YoruStarttimeRange = YorustartHours + ":" + YorustartMinutes;
          var YoruEndtimeRange = YoruendHours + ":" + YoruendMinutes;

          //////////////
          //  総合計  //
          //////////////
          var FullStarttimeRange = FullstartHour + ":" + FullstartMinute;
          var FullEndtimeRange = FullendHour + ":" + FullendMinute;



          //////////
          //  朝  //
          //////////
          AsaStarttimeRangeInput.value = AsaStarttimeRange;
          AsaEndtimeRangeInput.value = AsaEndtimeRange;

          //////////
          //  昼  //
          //////////
          HiruStarttimeRangeInput.value = HiruStarttimeRange;
          HiruEndtimeRangeInput.value = HiruEndtimeRange;

          //////////
          //  夜  //
          //////////
          YoruStarttimeRangeInput.value = YoruStarttimeRange;
          YoruEndtimeRangeInput.value = YoruEndtimeRange;

          //////////////
          //  総合計  //
          //////////////
          FullStarttimeRangeInput.value = FullStarttimeRange;
          FullEndtimeRangeInput.value = FullEndtimeRange;


          submitButton.disabled = false;
        } else {
          timeRangeInput.value = "";
          submitButton.disabled = true;
        }
      }
    });
  </script>








    <?php

    //朝昼夜表更新メソッド
    function updateTableRow($data, $timePeriod, $receivedData)
    {
        $timeColor = ["朝" => '#FFEEFF', "昼" => '#FFFFEE', "夜" => '#EEFFFF'];
        $timeTotal = ["朝" => '#FFCCFF', "昼" => '#FFFFCC', "夜" => '#CCFFFF'];

        echo '<tr style="background-color:' . $timeColor[$timePeriod] . ';">';
        echo '<td rowspan="' . ($receivedData + 1) . '" id="rowData">'; //oninput="syncInput(this.value, 'input2')"

        // echo '<input type="hidden" name="' . $timePeriod . '_時間帯_始" value="' . $timePeriod . '_時間帯_始">';
        // echo '<input type="hidden" name="' . $timePeriod . '_時間帯_終" value="' . $timePeriod . '_時間帯_終">';

        echo $timePeriod; // 朝昼夜表示
        echo '<button onclick="RowPlus()">+</button>';
        echo '</td>';
        echo '<td rowspan="' . ($receivedData + 1) . '">';

        if ($timePeriod == "朝") {
        //     timeChange("朝_時間帯_始",$data['朝']['時間帯']['始']);
        echo '
        <select id="AsastartHours" name="AsaStarthours" onchange="syncInput(this.value, \'Full_StartHour\')">
        <option value="'.date('H',strtotime($data['朝']['時間帯']['始'])).'">'.date('H',strtotime($data['朝']['時間帯']['始'])).'</option>
        </select>
        
      <span>:</span>
      <select id="AsastartMinutes" name="AsaStartminutes" onchange="syncInput(this.value, \'Full_StartMinute\')">
        <option value="'.date('i',strtotime($data['朝']['時間帯']['始'])).'">'.date('i',strtotime($data['朝']['時間帯']['始'])).'</option>
  
      </select>
  
      <span>~</span>
  
      <select id="AsaendHours" name="AsaEndhours"  onchange="syncInput(this.value, \'HirustartHours\')">
        <option value="'.date('H',strtotime($data['朝']['時間帯']['終'])).'">'.date('H',strtotime($data['朝']['時間帯']['終'])).'</option>
      </select>

      <span>:</span>

      <select id="AsaendMinutes" name="AsaEndminutes" onchange="syncInput(this.value, \'HirustartMinutes\')">
        <option value="'.date('i',strtotime($data['朝']['時間帯']['終'])).'">'.date('i',strtotime($data['朝']['時間帯']['終'])).'</option> <!-- 他の分オプション -->
      </select>
  
      <input id="AsaStarttimeRange" type="hidden" name="朝_時間帯_始">
      <input id="AsaEndtimeRange" type="hidden" name="朝_時間帯_終">';
  

//'.date('i',strtotime($data['朝']['時間帯']['終'])).'


            // echo '<input type="time" name="朝_時間帯_始" id="朝_時間帯_始" value="' . $data['朝']['時間帯']['始'] . '" oninput="syncInput(this.value, \'総合計時間帯_始\')">';
            // echo ' ~ ';
            // echo '<input type="time" name="朝_時間帯_終" id="朝_時間帯_終" value="' . $data['朝']['時間帯']['終'] . '" oninput="syncInput(this.value, \'昼_時間帯_始\')">';
        } else if ($timePeriod == "昼") {
            echo '
        <select id="HirustartHours" name="HiruStarthours" onchange="syncInput(this.value, \'AsaendHours\')">
        <option value="'.date('H',strtotime($data['昼']['時間帯']['始'])).'">'.date('H',strtotime($data['昼']['時間帯']['始'])).'</option>
      </select>
      <span>:</span>
      <select id="HirustartMinutes" name="HiruStartminutes" onchange="syncInput(this.value, \'AsaendMinutes\')">
        <option value="'.date('i',strtotime($data['昼']['時間帯']['始'])).'">'.date('i',strtotime($data['昼']['時間帯']['始'])).'</option>
      </select>
  
      <span>~</span>
  
      <select id="HiruendHours" name="HiruEndhours" onchange="syncInput(this.value, \'YorustartHours\')">
        <option value="'.date('H',strtotime($data['昼']['時間帯']['終'])).'">'.date('H',strtotime($data['昼']['時間帯']['終'])).'</option>
      </select>
      <span>:</span>
      <select id="HiruendMinutes" name="HiruEndminutes" onchange="syncInput(this.value, \'YorustartMinutes\')">
        <option value="'.date('i',strtotime($data['昼']['時間帯']['終'])).'">'.date('i',strtotime($data['昼']['時間帯']['終'])).'</option> <!-- 他の分オプション -->
      </select>
  
      <input id="HiruStarttimeRange" type="hidden" name="昼_時間帯_始">
      <input id="HiruEndtimeRange" type="hidden" name="昼_時間帯_終">
        ';

//'.date('i',strtotime($data['昼']['時間帯']['始'])).'
            // echo '<input type="time" name="昼_時間帯_始" id="昼_時間帯_始" value="' . $data['昼']['時間帯']['始'] . '" readonly>';
            // echo ' ~ ';
            // echo '<input type="time" name="昼_時間帯_終" id="昼_時間帯_終" value="' . $data['昼']['時間帯']['終'] . '" oninput="syncInput(this.value, \'夜_時間帯_始\')">';
        } else {
            echo '
        <select id="YorustartHours" name="YoruStarthours" onchange="syncInput(this.value, \'HiruendHours\')">
        <option value="'.date('H',strtotime($data['夜']['時間帯']['始'])).'">'.date('H',strtotime($data['夜']['時間帯']['始'])).'</option>
  
      </select>
      <span>:</span>
      <select id="YorustartMinutes" name="YoruStartminutes" onchange="syncInput(this.value, \'HiruendMinutes\')">
        <option value="'.date('i',strtotime($data['夜']['時間帯']['始'])).'">'.date('i',strtotime($data['夜']['時間帯']['始'])).'</option>
  
      </select>
  
      <span>~</span>
  
      <select id="YoruendHours" name="YoruEndhours" onchange="syncInput(this.value, \'Full_EndHour\')">
        <option value="'.date('H',strtotime($data['夜']['時間帯']['終'])).'">'.date('H',strtotime($data['夜']['時間帯']['終'])).'</option>
  
      </select>
      <span>:</span>
      <select id="YoruendMinutes" name="YoruEndminutes" onchange="syncInput(this.value, \'Full_EndMinute\')">
        <option value="'.date('i',strtotime($data['夜']['時間帯']['終'])).'">'.date('i',strtotime($data['夜']['時間帯']['終'])).'</option> <!-- 他の分オプション -->
      </select>
  
      <input id="YoruStarttimeRange" type="hidden" name="夜_時間帯_始">
      <input id="YoruEndtimeRange" type="hidden" name="夜_時間帯_終">
          ';

        //'.date('i',strtotime($data['夜']['時間帯']['終'])).'
            // echo '<input type="time" name="夜_時間帯_始" id="夜_時間帯_始" value="' . $data['夜']['時間帯']['始'] . '" readonly>';
            // echo ' ~ ';
            // echo '<input type="time" name="夜_時間帯_終" id="夜_時間帯_終" value="' . $data['夜']['時間帯']['終'] . '" oninput="syncInput(this.value, \'総合計時間帯_終\')">';
        }

        echo '</td>';

        for($j = 1; $j < $receivedData; $j++){
            echo '<td>';
                echo '<input type="text" name="' . $timePeriod . '_ポジション_' . $j . '"   value="' . $data[$timePeriod]['ポジション'][$j]['名前'] . '">';
            echo '</td>';
            echo '<td>';
                // echo '<input type="number" name="' . $timePeriod . '_必要人数_' . $j . '" value="' . (isset($_POST[$timePeriod . "_必要人数_" . $j]) ? $_POST[$timePeriod . "_必要人数_" . $j] : '') . '">';
                echo '<input type="number" name="' . $timePeriod . '_必要人数_' . $j . '" id="' . $timePeriod . '_必要人数_' . $j . '"  value="' . $data[$timePeriod]['ポジション'][$j]['必要人数'] . '" oninput="sumInput( \'' . $timePeriod . '\', \'' . $timePeriod . '_合計\', ' . $receivedData . ',' . $j . ')">';
                // echo '<button id="'.$timePeriod.'_'.$j.'_RowDelete" value="'.$timePeriod.','.$j.'" onclick="RowChange(this.value)">x</button>';
            echo '</td>';
            echo '</tr>';
            echo '<tr>';
        }

        

        echo '<td style="background-color:+' . $timeTotal[$timePeriod] . ';">合計</td>';
        echo '<td style="background-color:' . $timeTotal[$timePeriod] . ';">';
        // echo '<input type="number" name="' . $timePeriod . '_必要人数_' . $j . '" value="' . (isset($_POST[$timePeriod . "_必要人数_" . $j]) ? $_POST[$timePeriod . "_必要人数_" . $j] : '') . '">';
        echo '<input type="number" name="' . $timePeriod . '_合計" id="' . $timePeriod . '_合計" value="' .$data[$timePeriod]['ポジション'][$receivedData]['必要人数']. '" readonly>';//$data[$timePeriod]['ポジション'][$receivedData]['必要人数']
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
    }

    ?>






    <script>
        // function sendData(value,str) {
        //     // JavaScriptでPHPにデータを送信する
        //     window.location.href = "test3.php?"+str+"_data=" + encodeURIComponent(value);
        // }

        //作成途中5/16
        function RowPlus(str){
            
            let myArray = str.split(",");
            let timeRange = myArray[0];
            let num = myArray[1];

            // const rowpara = document.getElementById();
            let newCell = document.createElement('td');
            let el = document.createElement("input");
            let preel = document.getElementById(timeRange+"_必要人数_"+num);
            // let parentNode = preel.parentElement;

            num++;
            el.setAttribute("id", timeRange+"_必要人数_"+num);
            el.setAttribute("name", timeRange+"_必要人数_"+num);

            
            newCell.appendChild(el);

            console.log(timeRange+"_必要人数_"+num);

            // parentNode.insertBefore(el,preel);
        }
        

        function syncInput(value, targetId) {
            // 入力が行われると、指定されたターゲットの入力フィールドに値を設定
            document.getElementById(targetId).value = value;
        }

        // 前回の合計値を保持するローカル変数

        function sumInput(timeId, targetId, rows, now) {
            let sum = 0;


            if (document.getElementById(timeId + '_必要人数_' + now).value !== '') {

                for (i = parseInt(rows) - 1; i > 0; i--) {
                    sum += parseInt(document.getElementById(timeId + '_必要人数_' + i).value);
                }

                document.getElementById(targetId).value = sum;
                document.getElementById('総合計人数').value = parseInt(document.getElementById('朝_合計').value) + parseInt(document.getElementById('昼_合計').value) + parseInt(document.getElementById('夜_合計').value);


            } else {
                sum = 0;
                document.getElementById(targetId).value = 0;
                document.getElementById('総合計人数').value = 0;

            }

        }




        function preInput(timeId, targetId, rows, now) {
            let sum = 0;

            console.log(rows);


            if (document.getElementById(timeId + '_必要人数_' + now).value !== '') {

                for (i = 1; i <= parseInt(rows); i++) {

                    sum += parseInt(document.getElementById(timeId + '_必要人数_' + i).value);
                }

                document.getElementById(targetId).value = sum;

                document.getElementById('総合計人数').value = parseInt(document.getElementById('朝_合計').value) + parseInt(document.getElementById('昼_合計').value) + parseInt(document.getElementById('夜_合計').value);


            } else {
                sum = 0;
                document.getElementById(targetId).value = 0;
                document.getElementById('総合計人数').value = 0;

            }

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



        // function sumInput(value,targetId) {

        //     document.getElementById(targetId).value = parseInt(document.getElementById(targetId).value) + parseInt(value);

        // }
    </script>



</body>

</html>