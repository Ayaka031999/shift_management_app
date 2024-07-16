<style>
/* html{
  font-family: "游ゴシック","Yu Gothic"; 
  font-weight: bold;
}

table {
  border-collapse: collapse;
  width: 80%;
  border: 2px solid black;
}
table th,
table td {
  max-width: 6rem;
  min-width: 6rem;
  padding: 0.5rem;
  max-height: 2rem;
  min-height: 2rem;
  font-size: 0.85rem;
  line-height: 1rem;
  text-align: center;
}
table thead th {
  background-color: lavenderblush;
}
table tbody tr td:nth-child(1),
table tbody tr td:nth-child(2) {
  background-color: aliceblue;
}
table thead tr th:nth-child(1),
table tbody tr th:nth-child(1),
table thead tr td:nth-child(1),
table tbody tr td:nth-child(1),
table thead tr th:nth-child(2),
table tbody tr th:nth-child(2),
table thead tr td:nth-child(2),
table tbody tr td:nth-child(2) {
  position: sticky;
  z-index: 1;
}
table thead tr th:nth-child(1),
table tbody tr th:nth-child(1),
table thead tr td:nth-child(1),
table tbody tr td:nth-child(1) {
  left: 0;
}
table thead tr th:nth-child(2),
table tbody tr th:nth-child(2),
table thead tr td:nth-child(2),
table tbody tr td:nth-child(2) {
  left: 6rem;
}
table thead tr:nth-child(1) th,
table thead tr:nth-child(2) th {
  position: sticky;
  z-index: 2;
}
table thead tr:nth-child(1) th {
  top: 0;
}
table thead tr:nth-child(2) th {
  top: 5.0rem;
}
table thead tr th:nth-child(1),
table thead tr th:nth-child(2) {
  z-index: 3;
} */

</style>

<button onclick="convertToPDF()">PDFに変換</button>



<?php
    //DBよびだし
    $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4","root","");
    $db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $current_year = date("Y");
    //現在の月取得
    $current_month = date("n");

    if($current_month<10) $current_month='0'.$current_month;
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

    $data= array();

    $sql = $db->query("SELECT userID, name FROM member");
    $member = $sql->fetchAll(PDO::FETCH_ASSOC);

    foreach($member as $mem){
        $userID = $mem['userID'];
        $allsql = $db->query("SELECT date, in_time, out_time FROM request_shift WHERE userID=$userID AND date LIKE '$current_year-$current_month-%'");
        $all_res = $allsql->fetchAll(PDO::FETCH_ASSOC);
        $data[$userID] = $all_res;
    }

    echo '<pre>';
    print_r($data);
    echo '</pre>';

    
    echo '<table border=1 id="print-table">';
    echo '<thead>';
    // echo '<tr >';
    // echo '<th colspan="2">時間帯＼不足人数</th>';
    // echo '<th style="display:none"></th>';
    // echo '</tr >';
    echo '<tr >';
    echo '<th >ID</th>';
    echo '<th >名前</th>';
    for ($i = 1, $k = $week; $i < $month_array[$current_month - 1] + 1; $k++, $i++) {
            echo '<th class="fixed02">';
            echo $i;
            if($k==7) $k=0;
            echo '('.$youbi_array[$k].')';
            echo "</th>";           
    }
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    foreach($member as $mem){
    echo '<tr>';
    echo '<td>'.$mem['userID'].'</td><td>'.$mem['name'].'</td>';
    for ($i = 1, $k = $week; $i < $month_array[$current_month - 1] + 1; $k++, $i++) {
        if ($i < 10) $i = '0'.$i;
        foreach($data[$mem['userID']] as $info){
            if($info['date']==$current_year.'-'.$current_month.'-'.$i){
                echo '<td>'.$info['in_time'].'～'.$info['out_time'].'</td>';
            }else{
                echo '<td></td>';
            } 
        }             
    }
    echo '</tr>';

    }

    echo '</tbody>';
    echo '</table>';


    // foreach($all_res as $res){
    //     echo '<tr>';

    //     echo '<td>'.$res['userID'].'</td><td>'.$res['name'];
    //     echo '</tr>';

    // }

?>

    


<?php
/*    //現在の年取得
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

    echo '<table align = center  border="2" class=table id="print-table">';
    echo '<thead>';
    echo '<tr>';
    echo '<th colspan="2">時間帯＼不足人数</th>';
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
            

            $lessStart = array();
            $lessEnd = array();
            $lessNum = array();

            
            //1時間ごと
            for ($time = strtotime($start_time); $time <= strtotime($end_time); $time += 3600) {
                $after = $time + 3600;
                $allsql = $db->query("SELECT count(userID) as countuser FROM request_shift WHERE date = '$just' AND in_time <= '" . date('H:i:s', $time) . "' AND out_time >= '" . date('H:i:s', $after) . "'");
                $all_res = $allsql->fetch(PDO::FETCH_ASSOC);

                if( $must_shift > $all_res['countuser']){
                    $lessStart[] = date('H', $time);
                    $lessEnd[] = date('H', $after);
                    $lessNum[] = $must_shift - $all_res['countuser'];
                    // echo date('H',$time).'~'.date('H',$after).'は'.$nai.'人たりない';
                }
            }

            if(!empty($lessStart)){
                echo '<p style="color: red;">'.min($lessStart).'~'.max($lessEnd).'時'.min($lessNum).'人</p>';
            }

            unset($lessStart);
            unset($lessEnd);
            unset($lessNum);
            
        }
        echo '</th>';
    }
                    

    echo '</tr>';

    echo '<tr >';
        echo '<th class="fixed01">ID</th>';
        echo '<th class="fixed01" width="80%">名前</th>';

        for($i=1,$k = $week;$i<$month_array[$current_month-1]+1;$k++,$i++){
            echo '<th class="fixed02">';
            echo $i;
            if($k==7) $k=0;
            echo '('.$youbi_array[$k].')';
            echo "</th>";           
        }
        
    echo '</tr>';
    echo '</thead>';


        $sql = $db -> query("SELECT userID,name FROM member");

        $resister = $sql->fetchAll();
        $count=0;


        if($current_month<10) $current_month = '0'.$current_month;

        foreach ($resister as $result):
            $count++;
            echo '<tbody>';
            echo '<tr>';
            echo '<td class="fixed03" align="center" width="100" height="60">';
            
            echo $result['userID'];

            echo '</td>';
        
            // ユーザー名前
            echo '<td class="fixed04" align="center" width="100" height="60">'.$result['name'].'</td>';
        
            $num = $result['userID'];
            $name = $result['name'];
        
            for ($i = 1; $i < $month_array[$current_month-1] + 1; $i++) {
                echo '<td class="cellID">';
                $formID = $num.'-'.$i; // ユーザーごと、日ごとに一意のIDを生成

                if ($i < 10) $i = '0'.$i;
                $date = $current_year.'-'.$current_month.'-'.$i;
        
                // 取得したユーザーIDと、毎日日付をずらして検索し、シフトがあれば表示
                $shift_sql = $db->query("SELECT in_time, out_time, date FROM request_shift WHERE userID ='$num' AND DATE_FORMAT(date,'%Y-%m-%d') = '$date' ORDER BY date");
                $shift_resister = $shift_sql->fetchAll();
        
                if (!empty($shift_resister)) {
                    // シフトデータ編集
                    foreach ($shift_resister as $result):
                        $in_time = date('H:i', strtotime($result['in_time']));
                        $out_time =  date('H:i', strtotime($result['out_time']));
                        echo $in_time.'～'.$out_time;
                    endforeach;

                }
                echo '</td>';
            }
            echo '<tr>';
            // 最後にforeachを終わらせる。
        endforeach;
                    echo '</tbody>';
        echo '</table>';
*/
    


?>

<script>
        function convertToPDF() {
            // テーブルの内容を取得
            var tableContent = document.getElementById('print-table').outerHTML;

            // 新しいフォームを作成
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'hyou.php';

            // テーブルのHTMLを隠しフィールドに設定
            var hiddenField = document.createElement('input');
            hiddenField.type = 'hidden';
            hiddenField.name = 'tableContent';
            hiddenField.value = tableContent;
            form.appendChild(hiddenField);

            // フォームをbodyに追加して自動送信
            document.body.appendChild(form);
            form.submit();
        }
</script>
