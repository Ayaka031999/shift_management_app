<?php


$db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");


$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$dayOfWeek=["日","月","火","水","木","金","土"];
$timePeriods = ["朝", "昼", "夜"];


$youbi = date('w');
$today = date('Y-m-d');

echo '<h1>'.$today.'</h1>';

$data = array();

$posiData = array();

$posiAll = array();


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
    $start_time = $data[$timename]['時間帯_始'];
    $end_time = $data[$timename]['時間帯_終'];


    //1時間ごと        
    for ($time = strtotime($start_time); $time < strtotime($end_time); $time += 3600) {
        $after = $time + 3600;
        $start_hour = date('H', $time);
        $end_hour = date('H', $after);

        //1時間ごとに必要なポジションと人数
        $posistmt = $db->prepare("SELECT ポジション名, 必要人数 FROM １日当たり必要人数 WHERE 曜日=:youbi  AND ポジション名 != '合計' AND ポジション名 != '総合計人数' AND 時間帯_始 <= '" . date('H:i:s', $time) . "' AND 時間帯_終 >= '" . date('H:i:s', $after) . "'");
        $posistmt->bindParam(':youbi', $dayOfWeek[$youbi]);
        $posistmt->execute();
        $posiresister = $posistmt->fetchAll(PDO::FETCH_ASSOC);


        //その1時間ごとに入ってる人の名前
        $allsql = $db->query("SELECT name FROM request_shift WHERE date = '$today' AND in_time <= '" . date('H:i:s', $time) . "' AND out_time >= '" . date('H:i:s', $after) . "'");
        $all_res = $allsql->fetchAll(PDO::FETCH_ASSOC);


        foreach($posiresister as $posi){
            //echo $posi['ポジション名'];
            $posiData[$start_hour.'-'.$end_hour][] = [
                'ポジション名' => $posi['ポジション名'],
                '必要人数' => $posi['必要人数']
            ];
        }

        // 配列の要素数を取得
        $posicount = count($posiData[$start_hour.'-'.$end_hour]);


            $user = [];

            $k=0;
    
            foreach ($all_res as $row) {
                $user[$k]= $row['name'];
                $k++;
            }



            $i = 0;
            for($i=0;$i<$posicount;$i++){
                $numdata[$i]=$posiData[$start_hour . '-' . $end_hour][$i]['必要人数'];
            }

            echo count($user).'人<br>';

            for ($z =0, $i = 0; $z<count($user) ;$i++,$z++) {
                    if ($i == $posicount) {//1巡目がおわる
                        $i = 0; // $iがポジション数に達した場合、0にリセット
                        
                    }
            

                    if ($numdata[$i] == 0){
                        
                        $i++;
                        if ($i == $posicount) {//1巡目がおわる
                            $i = 0; // $iがポジション数に達した場合、0にリセット
                            continue;
                            
                        }
                    } 


                    echo 'ポジション名' . $i . '<br>';


                    echo $posiData[$start_hour . '-' . $end_hour][$i]['ポジション名'];
            
                    // 各従業員にポジションを1つずつ割り当てる
                    $posiAll[$start_hour . '-' . $end_hour][$user[$z]] = $posiData[$start_hour . '-' . $end_hour][$i]['ポジション名'];
                    $numdata[$i]--;
                    echo $numdata[$i];

                    

                    $allZero = true;

                    for($p=0;$p<$posicount;$p++){
                        if ($numdata[$p] != 0) {
                            $allZero = false;
                            break;
                        }
                    }


                    if ($allZero) {
                        echo "全て0";
                        for($p=0;$p<$posicount;$p++){
                            $numdata[$p]=$posiData[$start_hour . '-' . $end_hour][$p]['必要人数'];
                        }
                        $i=-1;
                    }
            }
    }//1時間ごと終わり
}


            echo '<pre>';
            print_r($posiAll);
            echo '</pre>';


?>