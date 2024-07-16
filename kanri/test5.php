<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>要素並び替えの例</title>
    <style>
        .container {
            margin: 20px;
            padding: 10px;
            border: 1px solid #ccc;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        button {
            display: block;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <?php
        // セッションを開始
        session_start();

        if (isset($_SESSION['youbiname'])) {
            $youbiname = $_SESSION['youbiname'];
        }

        
        $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    ?>
    <div class="container" id="sortable-container">
        <form id="orderForm" method="post">
            <table id="sortable-table">
                <thead>
                    <tr>
                        <th>時間</th>
                        <th>時間帯</th>
                        <th>ポジション</th>
                        <th>人数</th>
                        <th>削除ボタン</th>
                    </tr>
                </thead>
                <?php
                $timesOfDay = ['朝', '昼', '夜'];

                //テーブルを配列に格納
                function processData($time, $postData, $maxJ)
                {
                    $array = [];
                    $sum = 0;

                    $array["時間帯"]["始"] = $postData[$time.'Starthours'].':'.$postData[$time.'Startminutes'];
                    $array["時間帯"]["終"] = $postData[$time.'Endhours'].':'.$postData[$time.'Endminutes'];


                    $posiArray = $postData[$time . "_ポジション_"];
                    $numArray = $postData[$time . "_必要人数_"];


                    for ($j = 0; $j < $maxJ; $j++) {
                        $array["ポジション"][$j]["名前"] =$posiArray[$j];// . $j
                        $array["ポジション"][$j]["必要人数"] = $numArray[$j];
                        // $sum += $array["ポジション"][$j]["必要人数"] = $postData[$time . "_必要人数_" . $j];
                    }

                    // if($j == $maxJ){
                    $array["ポジション"][$maxJ]["名前"] = "合計";//+
                    $array["ポジション"][$maxJ]["必要人数"] = $postData[$time . "_合計"];
                    //     break;
                    // }
                    return $array;
                }

                // SQLクエリの実行
                $stmt = $db->prepare("SELECT * FROM １日当たり必要人数 WHERE 曜日='$youbiname'");
                $stmt->execute();
                $resister = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $timePeriods = array("朝", "昼", "夜");



                        //DBに登録があるかないか
                if (!empty($resister)) {

                    // データを連想配列として変換
                    $result = array();
                    foreach ($resister as $row){
                        $result[$row['時間']]['時間帯']['始'] = $row['時間帯_始'];
                        $result[$row['時間']]['時間帯']['終'] = $row['時間帯_終'];
                        $result[$row['時間']]['ポジション'][$row['ポジション']]['名前'] = $row['ポジション名'];
                        $result[$row['時間']]['ポジション'][$row['ポジション']]['必要人数'] = $row['必要人数'];
                    }
                }






                //データがおくられてきたら
                if (isset($_POST["submit"])) {
                    // 朝のデータを受け取る
                    $item_朝 = $_POST['朝_ポジション_']; // 配列として受け取るので、$_POST['朝_ポジション_'] が朝のポジションの配列になる
                    $num_朝 = $_POST['朝_必要人数_']; // 同様に、朝の必要人数の配列

                    // 昼のデータを受け取る
                    $item_昼 = $_POST['昼_ポジション_']; // 昼のポジションの配列
                    $num_昼 = $_POST['昼_必要人数_']; // 昼の必要人数の配列

                    // 夜のデータを受け取る
                    $item_夜 = $_POST['夜_ポジション_']; // 夜のポジションの配列
                    $num_夜 = $_POST['夜_必要人数_']; // 夜の必要人数の配列


                    // $_POST['AsaStarthours'].':'.$_POST['AsaStartminutes']

                    // 配列にまとめる
                    $timeItems = [
                        '朝' => $item_朝,
                        '昼' => $item_昼,
                        '夜' => $item_夜
                    ];

                    $timeNumbers = [
                        '朝' => $num_朝,
                        '昼' => $num_昼,
                        '夜' => $num_夜
                    ];

                    $postData = $_POST;

                    print_r($postData);

                    // 多次元連想配列にデータを格納
                    $result = array();
        
                    $result["朝"] = processData("朝", $postData, count($timeItems['朝']));
                    $result["昼"] = processData("昼", $postData, count($timeItems['昼']));
                    $result["夜"] = processData("夜", $postData, count($timeItems['夜']));
        
                    // 総合計時間と総合計人数を格納
                    // $result["総合計"]["時間帯"]["始"] = $postData["総合計時間帯_始"];
                    $result["総合計"]["時間帯"]["始"] = $postData['朝Starthours'].':'.$postData['朝Startminutes'];
        
                    // $result["総合計"]["時間帯"]["終"] = $postData["総合計時間帯_終"];
                    $result["総合計"]["時間帯"]["終"] = $postData['夜Endhours'].':'.$postData['夜Endminutes'];
        
        
                    $result["総合計"]["ポジション"][1]["名前"] = "総合計人数";
                    $result["総合計"]["ポジション"][1]["必要人数"] = $postData["総合計人数"];
        
                    // $i = $maxPositions['朝'] + $maxPositions['昼'] + $maxPositions['夜'] + 1;
        
                    // 配列の内容を表示
                    echo '<pre>';
                    print_r($result);
                    echo '</pre>';

                    /*DB登録*/
                    /*try {
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
                    }*/


                    foreach ($timesOfDay as $time) {
                        $items = $timeItems[$time];
                        $numbers = $timeNumbers[$time];
                        $rowspan = count($items) + 1;

                        echo '<tbody id="tbody_' . $time . '">';
                        echo '<td rowspan="' . $rowspan + 1 . '" id="column_' . $time . '">' . $time . '<button type="button" id="addButton_' . $time . '">＋要素追加</button></td>';
                        echo '<td rowspan="' . $rowspan + 1 . '" id="column_' . $time . '_time">';

                        if ($time == "朝") {
                            echo '
                            <select id="AsastartHours" name="朝Starthours" onchange="syncInput(this.value, \'Full_StartHour\')" required>
                                <option>'.date('H', strtotime($result['朝']['時間帯']['始'])).'</option>
                            </select>
                                
                            <span>:</span>
                            <select id="AsastartMinutes" name="朝Startminutes" onchange="syncInput(this.value, \'Full_StartMinute\')" required>
                                <option>'.date('i', strtotime($result['朝']['時間帯']['始'])).'</option>
                            </select>
                        
                            <span>~</span>
                        
                            <select id="AsaendHours" name="朝Endhours"  onchange="syncInput(this.value, \'HirustartHours\')" required>
                                <option>'.date('H', strtotime($result['朝']['時間帯']['終'])).'</option>
                            </select>
                        
                            <span>:</span>
                        
                            <select id="AsaendMinutes" name="朝Endminutes" onchange="syncInput(this.value, \'HirustartMinutes\')" required>
                                <option>'.date('i', strtotime($result['朝']['時間帯']['終'])).'</option> <!-- 他の分オプション -->
                            </select>
                        
                            <input id="AsaStarttimeRange" type="hidden" name="朝_時間帯_始" >
                            <input id="AsaEndtimeRange"   type="hidden" name="朝_時間帯_終">';

                        } elseif ($time == "昼") {
                            echo '
                                <select id="HirustartHours" name="昼Starthours" onchange="syncInput(this.value, \'AsaendHours\')" required>
                                    <option>'.date('H', strtotime($result['昼']['時間帯']['始'])).'</option>
                                </select>
                                <span>:</span>
                                <select id="HirustartMinutes" name="昼Startminutes" onchange="syncInput(this.value, \'AsaendMinutes\')" required>
                                    <option>'.date('i', strtotime($result['昼']['時間帯']['始'])).'</option>
                                </select>
                            
                                <span>~</span>
                            
                                <select id="HiruendHours" name="昼Endhours" onchange="syncInput(this.value, \'YorustartHours\')" required>
                                    <option>'.date('H', strtotime($result['昼']['時間帯']['終'])).'</option>
                                </select>
                                <span>:</span>
                                <select id="HiruendMinutes" name="昼Endminutes" onchange="syncInput(this.value, \'YorustartMinutes\')" required>
                                    <option>'.date('i', strtotime($result['昼']['時間帯']['終'])).'</option> <!-- 他の分オプション -->
                                </select>
                            
                                <input id="HiruStarttimeRange" type="hidden" name="昼_時間帯_始">
                                <input id="HiruEndtimeRange" type="hidden" name="昼_時間帯_終">
                            ';
                        } elseif ($time == "夜") {
                            echo '
                                <select id="YorustartHours" name="夜Starthours" onchange="syncInput(this.value, \'HiruendHours\')" required>
                                    <option>'.date('H', strtotime($result['夜']['時間帯']['始'])).'</option>
                                </select>
                                <span>:</span>
                                <select id="YorustartMinutes" name="夜Startminutes" onchange="syncInput(this.value, \'HiruendMinutes\')" required>
                                    <option>'.date('i', strtotime($result['夜']['時間帯']['始'])).'</option>
                                </select>
                            
                                <span>~</span>
                            
                                <select id="YoruendHours" name="夜Endhours" onchange="syncInput(this.value, \'Full_EndHour\')" required>
                                    <option>'.date('H', strtotime($result['夜']['時間帯']['終'])).'</option>
                                </select>
                                <span>:</span>
                                <select id="YoruendMinutes" name="夜Endminutes" onchange="syncInput(this.value, \'Full_EndMinute\')" required>
                                    <option>'.date('i', strtotime($result['夜']['時間帯']['終'])).'</option> <!-- 他の分オプション -->
                                </select>
                            
                                <input id="YoruStarttimeRange" type="hidden" name="夜_時間帯_始">
                                <input id="YoruEndtimeRange" type="hidden" name="夜_時間帯_終">
                            ';
                        }


                        echo '</td>';

                        echo '<input type="hidden" value="' . count($items) . '" id="kazu_' . $time . '">';
                        for ($index = 0; $index < count($items); $index++) {
                            // echo $time . 'の' . $index . ':' . $items[$index] . '(' . $numbers[$index] . ')<br>';
                            echo '
                                <tr class="item-row">
                                    <td><input class="item" name="'.$time.'_ポジション_[]" id="'.$time.'_ポジション_'.$index.'" value="'. htmlspecialchars($items[$index]) . '" required></td>
                                    <td>'.$time.'_必要人数_'.$index.'<input type="number" class="item" name="'.$time.'_必要人数_[]" id="'.$time.'_必要人数_'.$index. '" value="' . htmlspecialchars($numbers[$index]) . '" oninput="sumInput( \'' . $time . '\', \'' . $time . '_合計\', ' . count($items)-1 . ',' . $index . ')"></td>';
                            if($index !== 0){
                                echo '<td><button type="button" class="delete-button" data-time="' . $time . '" data-index="' . $index . '">✖</button></td>';
                            }        
                            // if ($index == 0) { //count($items) - 1
                            //     echo '<td><button type="button" id="addButton_' . $time . '">＋要素追加</button></td>';
                            // }
                            echo '</tr>';
                        }

                        echo '<tr>';
                            echo '<td>合計</td>';
                            echo '<td>';
                            echo '<input type="number" name="'.$time.'_合計" id="'.$time.'_合計" value="'.$result[$time]['ポジション'][count($items)]['必要人数'].'" readonly>'; //$data[$timePeriod]['ポジション'][$receivedData]['必要人数']
                            echo '</td>';
                        echo '</tr>';

                        echo '</tbody>';
                    }

                    echo '
                    <tr>
                        <td>総合計時間</td>
                        <td>
                            <input style="width:20px;" id="Full_StartHour" value="'.date('H', strtotime($result["総合計"]["時間帯"]["始"])).'" readonly>
                            <span>:</span>
                            <input style="width:20px;" id="Full_StartMinute" value="'.date('i', strtotime($result["総合計"]["時間帯"]["始"])).'" readonly>
                            <span>~</span>
                            <input style="width:20px;" id="Full_EndHour" value="'.date('H', strtotime($result["総合計"]["時間帯"]["終"])).'" readonly>
                            <span>:</span>
                            <input style="width:20px;" id="Full_EndMinute" value="'.date('i', strtotime($result["総合計"]["時間帯"]["終"])).'" readonly>



                            <input type="hidden" name="総合計時間帯_始" id="総合計時間帯_始" value="" readonly>
                            <input type="hidden" name="総合計時間帯_終" id="総合計時間帯_終" value="" readonly>

                            <!-- <input type="time" name="総合計時間帯_始" id="総合計時間帯_始" value="" readonly>
                            ~
                            <input type="time" name="総合計時間帯_終" id="総合計時間帯_終" value="" readonly> -->
                        </td>
                        <td>総合計人数</td>
                        <td>
                            <input type="number" name="総合計人数" id="総合計人数" value="'.$result["総合計"]["ポジション"][1]["必要人数"].'">
                        </td>
                    </tr>
                ';

                } else {//まだsubmitが押されてなかったら
                    foreach ($timesOfDay as $time) {
                        // echo '<tbody id="tbody_' . $time . '">';
                        // echo '<tr><td rowspan="3" id="column_' . $time . '">' . $time . ' <button type="button" id="addButton_' . $time . '">＋要素追加</button></td></tr>';
                        echo '<tbody id="tbody_' . $time . '">';
                        echo '<td rowspan="3" id="column_' . $time . '">' . $time . '<button type="button" id="addButton_' . $time . '">＋要素追加</button></td>';
                        echo '<td rowspan="3" id="column_' . $time . '_time">';

                        if ($time == "朝") {
                            echo '
                            <select id="AsastartHours" name="朝Starthours" onchange="syncInput(this.value, \'Full_StartHour\')"  required>
                                <option></option>
                            </select>
                                
                            <span>:</span>
                            <select id="AsastartMinutes" name="朝Startminutes" onchange="syncInput(this.value, \'Full_StartMinute\')" required>
                                <option></option>
                            </select>
                        
                            <span>~</span>
                        
                            <select id="AsaendHours" name="朝Endhours"  onchange="syncInput(this.value, \'HirustartHours\')" required>
                                <option></option>
                            </select>
                        
                            <span>:</span>
                        
                            <select id="AsaendMinutes" name="朝Endminutes" onchange="syncInput(this.value, \'HirustartMinutes\')" required>
                                <option></option> <!-- 他の分オプション -->
                            </select>
                        
                            <input id="AsaStarttimeRange" type="hidden" name="朝_時間帯_始" >
                            <input id="AsaEndtimeRange"   type="hidden" name="朝_時間帯_終">';

                        } elseif ($time == "昼") {
                            echo '
                                <select id="HirustartHours" name="昼Starthours" onchange="syncInput(this.value, \'AsaendHours\')" required>
                                    <option></option>
                                </select>
                                <span>:</span>
                                <select id="HirustartMinutes" name="昼Startminutes" onchange="syncInput(this.value, \'AsaendMinutes\')" required>
                                    <option></option>
                                </select>
                            
                                <span>~</span>
                            
                                <select id="HiruendHours" name="昼Endhours" onchange="syncInput(this.value, \'YorustartHours\')" required>
                                    <option></option>
                                </select>
                                <span>:</span>
                                <select id="HiruendMinutes" name="昼Endminutes" onchange="syncInput(this.value, \'YorustartMinutes\')" required>
                                    <option></option> <!-- 他の分オプション -->
                                </select>
                            
                                <input id="HiruStarttimeRange" type="hidden" name="昼_時間帯_始">
                                <input id="HiruEndtimeRange" type="hidden" name="昼_時間帯_終">
                            ';
                        } elseif ($time == "夜") {
                            echo '
                                <select id="YorustartHours" name="夜Starthours" onchange="syncInput(this.value, \'HiruendHours\')" required>
                                    <option></option>
                                </select>
                                <span>:</span>
                                <select id="YorustartMinutes" name="夜Startminutes" onchange="syncInput(this.value, \'HiruendMinutes\')" required>
                                    <option></option>
                                </select>
                            
                                <span>~</span>
                            
                                <select id="YoruendHours" name="夜Endhours" onchange="syncInput(this.value, \'Full_EndHour\')" required>
                                    <option></option>
                                </select>
                                <span>:</span>
                                <select id="YoruendMinutes" name="夜Endminutes" onchange="syncInput(this.value, \'Full_EndMinute\')" required>
                                    <option></option> <!-- 他の分オプション -->
                                </select>
                            
                                <input id="YoruStarttimeRange" type="hidden" name="夜_時間帯_始">
                                <input id="YoruEndtimeRange" type="hidden" name="夜_時間帯_終">
                            ';
                        }
                        echo '</td>';

                        echo '
                            <tr class="item-row">
                            <td><input class="item" name="'.$time.'_ポジション_[]" id="'.$time.'_ポジション_0" value="" required></td>
                            <td><input type="number" class="item" name="'.$time.'_必要人数_[]" id="'.$time.'_必要人数_0" value="0" oninput="sumInput( \'' . $time. '\', \'' . $time . '_合計\', 3,3)"></td>
                        ';

                        // <td><button type="button" class="delete-button" data-time="' . $time . '" data-index="0">✖</button></td>
                        echo '</tr>';
                        echo '<td>合計</td>';
                        echo '<td>';
                        // echo '<input type="number" name="' . $timePeriod . '_必要人数_' . $j . '" value="' . (isset($_POST[$timePeriod . "_必要人数_" . $j]) ? $_POST[$timePeriod . "_必要人数_" . $j] : '') . '">';
                        echo '<input type="number" name="' . $time . '_合計" id="' . $time . '_合計" value="0" readonly>'; //$data[$timePeriod]['ポジション'][$receivedData]['必要人数']
                        echo '</td>';

                        echo '</tbody>';
                    }

                    echo '
                        <tr>
                            <td>総合計時間</td>
                            <td>
                                <input style="width:20px;" id="Full_StartHour" value="" readonly>
                                <span>:</span>
                                <input style="width:20px;" id="Full_StartMinute" value="" readonly>
                                <span>~</span>
                                <input style="width:20px;" id="Full_EndHour" value="" readonly>
                                <span>:</span>
                                <input style="width:20px;" id="Full_EndMinute" value="" readonly>



                                <input type="hidden" name="総合計時間帯_始" id="総合計時間帯_始" value="" readonly>
                                <input type="hidden" name="総合計時間帯_終" id="総合計時間帯_終" value="" readonly>

                                
                            </td>
                            <td>総合計人数</td>
                            <td>
                                <input type="number" name="総合計人数" id="総合計人数" value="0">
                            </td>
                        </tr>
                    ';
                }


                // <!-- <input type="time" name="総合計時間帯_始" id="総合計時間帯_始" value="" readonly>
                //                 ~
                //                 <input type="time" name="総合計時間帯_終" id="総合計時間帯_終" value="" readonly> -->

                ?>
            </table>
            <input type="hidden" name="order" id="orderInput">
            <input type="submit" name="submit" id="total_submit" value="データセットを作成" >
            <input type="submit" name="submit" id="total_submit" value="データベースに登録" disabled>
        </form>
    </div>


    <!-- SortableJSライブラリの読み込み -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script>
        // SortableJSを使ってドラッグアンドドロップを有効にする
        var table = document.getElementById('sortable-table').getElementsByTagName('tbody');
        for (let i = 0; i < table.length; i++) {
            new Sortable(table[i], {
                animation: 150,
                ghostClass: 'sortable-ghost',
                onUpdate: function(evt) {
                    updateOrderInput();
                }
            });
        }

        //ページを読み込んだ時に作用する
        document.addEventListener('DOMContentLoaded', function() {
            const timesOfDay = ['朝', '昼', '夜'];

            //時間ループを回す
            timesOfDay.forEach(time => {
                const columnHeader = document.getElementById(`column_${time}`);
                const columnTimeHeader = document.getElementById(`column_${time}_time`);
                let num = parseInt(document.getElementById(`kazu_${time}`) ? document.getElementById(`kazu_${time}`).value : 1);
                const addButton = document.getElementById(`addButton_${time}`);
                const tbody = document.getElementById(`tbody_${time}`);

                if (addButton && tbody) {
                    addButton.addEventListener('click', function() {
                        // 新しい行を作成
                        const newRow = document.createElement('tr');
                        newRow.className = 'item-row';

                        // 新しいセルを作成
                        const newCell = document.createElement('td');
                        const newItem = document.createElement('input');
                        newItem.className = 'item';
                        newItem.setAttribute('id', `${time}_ポジション_${num}`);
                        newItem.setAttribute('name', `${time}_ポジション_[]`);
                        newItem.setAttribute('value', ``);//新しい要素 ${num}

                        // 新しいセルを作成
                        const newNumCell = document.createElement('td');
                        const newNum = document.createElement('input');
                        newNum.className = 'item';
                        newNum.setAttribute('id', `${time}_必要人数_${num}`);
                        newNum.setAttribute('name', `${time}_必要人数_[]`);
                        newNum.setAttribute('type', 'number');
                        newNum.setAttribute('value', 0);

                        newCell.appendChild(newItem);
                        newNumCell.appendChild(newNum);

                        newRow.appendChild(newCell);
                        newRow.appendChild(newNumCell);

                        // 削除ボタンを含むセルを作成
                        const deleteCell = document.createElement('td');
                        const deleteButton = document.createElement('button');
                        deleteButton.textContent = '✖';
                        deleteButton.type = 'button';
                        deleteButton.className = 'delete-button';
                        deleteButton.setAttribute('data-time', time);
                        deleteButton.setAttribute('data-index', num);

                        deleteCell.appendChild(deleteButton);
                        newRow.appendChild(deleteCell);

                        // テーブルに新しい行を追加
                        tbody.appendChild(newRow);

                        // rowspanの値を1増やす
                        columnHeader.setAttribute('rowspan', parseInt(columnHeader.getAttribute('rowspan')) + 2);

                        columnTimeHeader.setAttribute('rowspan', parseInt(columnHeader.getAttribute('rowspan')) + 2);

                        document.getElementById("total_submit").click();

                        num++;
                        updateOrderInput(time);
                    });
                }

                window[`deleteyouso_${time}`] = function(index) {
                    let deleteRow = document.getElementById(`${time}_ポジション_${index}`);
                    //const parenrParent = parent.parentNode;

                    if (deleteRow) {
                        goukei = document.getElementById(`${time}_合計`).value - document.getElementById(`${time}_必要人数_${index}`).value;
                        document.getElementById(`${time}_合計`).setAttribute('value', goukei);

                        const parentRow = deleteRow.closest('tr');
                        if (parentRow) {
                            parentRow.remove();
                            //echo '<td><button type="button" id="addButton_' . $time . '">＋要素追加</button></td>';
                            //rowspanの値を1減らす
                            columnHeader.setAttribute('rowspan', parseInt(columnHeader.getAttribute('rowspan')) - 1);
                            updateOrderInput(time);
                            console.log(deleteRow);
                            // document.getElementById("total_submit").click();


                        } else {
                            console.log('親のtrがみつかりません');
                        }
                    } else {
                        console.log('子の要素がみつかりません');
                    }
                };

                //並び順更新メソッド
                function updateOrderInput(time) {
                    const order = [];
                    const rows = tbody.getElementsByClassName('item-row');
                    for (let i = 0; i < rows.length; i++) {
                        order.push(i);
                    }
                    document.getElementById('orderInput').value = order.join(',');
                }

                // フォーム送信前に並び順を更新
                document.getElementById('orderForm').addEventListener('submit', function() {
                    updateOrderInput(time);
                });



                // すべての削除ボタンにイベントリスナーを追加
                document.addEventListener('click', function(e) {
                    if (e.target && e.target.className === 'delete-button') {

                        const time = e.target.getAttribute('data-time');
                        const index = e.target.getAttribute('data-index');

                        window[`deleteyouso_${time}`](index);
                        // 初期化時に順序を設定
                        updateOrderInput(time);

                    }
                });

                // 初期化時に順序を設定
                updateOrderInput(time);


            });

        });
    </script>

    <script>
        function syncInput(value, targetId) {
            // 入力が行われると、指定されたターゲットの入力フィールドに値を設定
            document.getElementById(targetId).value = value;
        }

        function sumInput(timeId, targetId, rows, now){
            let sum = 0;

            console.log(timeId + '_必要人数_' + now);

            if (document.getElementById(timeId + '_必要人数_' + now).value !== '') {


                for(i = parseInt(rows); i >= 0; i--){//for(i = parseInt(rows) - 1; i > 0; i--){
                    console.log(timeId + '_必要人数_' + i);
                    sum += parseInt(document.getElementById(timeId + '_必要人数_' + i).value);
                }

                document.getElementById(targetId).value = sum;
                document.getElementById('総合計人数').value = parseInt(document.getElementById('朝_合計').value) + parseInt(document.getElementById('昼_合計').value) + parseInt(document.getElementById('夜_合計').value);

                document.getElementById("total_submit").click();


            } else {
                sum = 0;
                document.getElementById(targetId).value = 0;
                document.getElementById('総合計人数').value = 0;
            }
        }

        // function preInput(timeId, targetId, rows, now) {
        //     let sum = 0;

        //     console.log(rows);


        //     if (document.getElementById(timeId + '_必要人数_' + now).value !== '') {

        //         for (i = 1; i <= parseInt(rows); i++) {
        //             sum += parseInt(document.getElementById(timeId + '_必要人数_' + i).value);
        //         }

        //         document.getElementById(targetId).value = sum;
        //         document.getElementById('総合計人数').value = parseInt(document.getElementById('朝_合計').value) + parseInt(document.getElementById('昼_合計').value) + parseInt(document.getElementById('夜_合計').value);

        //     } else {
        //         sum = 0;
        //         document.getElementById(targetId).value = 0;
        //         document.getElementById('総合計人数').value = 0;

        //     }

        // }


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


    </script>



    <script>

        document.addEventListener('DOMContentLoaded', function() {
            var AsaStarthourSelect = document.querySelector('select[name="朝Starthours"]');
            var AsaStartminuteSelect = document.querySelector('select[name="朝Startminutes"]');
            var AsaEndhourSelect = document.querySelector('select[name="朝Endhours"]');
            var AsaEndminuteSelect = document.querySelector('select[name="朝Endminutes"]');

            var HiruStarthourSelect = document.querySelector('select[name="昼Starthours"]');
            var HiruStartminuteSelect = document.querySelector('select[name="昼Startminutes"]');
            var HiruEndhourSelect = document.querySelector('select[name="昼Endhours"]');
            var HiruEndminuteSelect = document.querySelector('select[name="昼Endminutes"]');

            var YoruStarthourSelect = document.querySelector('select[name="夜Starthours"]');
            var YoruStartminuteSelect = document.querySelector('select[name="夜Startminutes"]');
            var YoruEndhourSelect = document.querySelector('select[name="夜Endhours"]');
            var YoruEndminuteSelect = document.querySelector('select[name="夜Endminutes"]');


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


        function valueChange(){
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

            updateButton.addEventListener('click', updateTimeRange);



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
        }
    </script>

</body>

</html>