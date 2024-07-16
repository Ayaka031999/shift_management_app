<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php
   $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
<body>
<?php
        //現在の年取得
        $current_year = date("Y");
        //現在の月取得
        $current_month = date("n");


        // うるう年計算メソッド
        function urus_method($year){   
            //4でわりきれるか4で割り切れるかつ100で割り切れなくて400でわりきれる
            if($year%4 == 0 && $year%100 != 0){
                return 29;
            }else if($year%4 == 0 && $year%100==0 && $year%400==0){
                return 29;
            }else{
                return 28;
            }
        }

        // 日付からタイムスタンプを取得
        $timestamp = mktime(0,0,0,$current_month,1,$current_year);

        //1,3,5,7,8,10,12 ----> 31まで
        $month_array = [31,urus_method(date("Y", $timestamp)),31,30,31,30,31,31,30,31,30,31];

        // 1日の曜日の値を取得
        $week = date("w", $timestamp);//日月火。。。012

        $youbi_array=["日","月","火","水","木","金","土"];



?>


<?php
        echo '<div id="wrapper">';
        echo '<table align = center  border="2" class=table >';
        echo '<thead>';
        echo '<tr>';
        echo '<th colspan="2">人数／必要人数</th>';
        echo '<th style="display:none"></th>';

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

            $just = $current_year.'-'.$current_month.'-'.$i;//2024-01-01の表記 


            echo '<th>';
            

            //朝、昼、夜
            foreach ($timePeriods as $timename){
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

                echo $start_time.'~'.$end_time.'<br>';
                
                //1時間ごと
                for ($time = strtotime($start_time); $time <= strtotime($end_time); $time += 3600) {
                    $after = $time + 3600;
                    $allsql = $db->query("SELECT count(userID) as countuser FROM request_shift WHERE date = '$just' AND in_time <= '" . date('H:i:s', $time) . "' AND out_time >= '" . date('H:i:s', $after) . "'");
                    $all_res = $allsql->fetch(PDO::FETCH_ASSOC);

                    echo $must_shift.'  ';
                    echo $all_res['countuser'].'<br>';


                    if( $must_shift > $all_res['countuser']){
                        $lessStart[] = date('H', $time);
                        $lessEnd[] = date('H', $after);
                        $lessNum[] = $must_shift - $all_res['countuser'];
                        // echo date('H',$time).'~'.date('H',$after).'は'.$nai.'人たりない';
                    }
                }


                // echo '<pre>';
                // print_r($lessStart);
                // echo '</pre>';



                // foreach($all_res as $row){
                //     echo $row['userID'].'<br>';
                //     echo $row['in_time'].'<br>';
                //     echo $row['out_time'].'<br>';
                // }


                // if(!empty($lessStart)){
                //     echo min($lessStart).'~'.max($lessEnd).'時<br>';
                //     echo min($lessNum).'人<br>';
                // }
            }
            echo '</th>';
        }
                        

        echo '</tr>';

        echo '<tr >';
            echo '<th class="fixed01">ID</th>';
            echo '<th class="fixed01" width="80%">名前</th>';

            for($i=1,$k = $week;$i<$month_array[$current_month-1]+1;$k++,$i++){
                echo '<th class="fixed02">';
                echo $i.'<br>';
                if($k==7) $k=0;
                echo '('.$youbi_array[$k].')';
                echo "</th>";           
            }
            
        echo '</tr>';
        echo '</thead>';


?>

</body>
</html>