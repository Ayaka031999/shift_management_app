<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>シフト入力結果</title>
</head>
<body>

    <?php

        //セッションを使うことを宣言
        //session_start();

        //ログインされていない場合は強制的にログインページにリダイレクト
        if (!isset($_SESSION["login_name"])){
            // header("Location: login.php");
            // exit();
        }
            
        //ログインされている場合は表示用メッセージを編集
        $message = $_SESSION['login_name'];
        $num = $_SESSION['login_ID'];
            
        // echo $num;
        // echo "{$message}さん"; 
        
        $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4","root","");
        $db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        

        
        class ShiftProcessor {
            private $db;
        
        
            public function __construct(PDO $db) {
                $this->db = $db;
            }


            public function dateSend($date){
            }

        
            public function calculateShiftData($inTime, $outTime, $date, $userID, $name,$code) {
                $inDateTime = new DateTime($inTime);
                $outDateTime = new DateTime($outTime);
                $timeDifference = $inDateTime->diff($outDateTime);
                
        
                if ($timeDifference->invert === 1) {
                    //echo "エラー：終了時間は開始時間よりも後に設定してください。";
                    $alert = "<script type='text/javascript'>alert('エラー：終了時間は開始時間よりも後に設定してください。');</script>";
                    echo $alert;

                    return;
                }
        
                $worktime_minute = ((strtotime($outTime) - strtotime($inTime)))/60;

        
                if((($worktime_minute-60)/60)>=8){
                    $rest_time = 60;
                    echo "休憩時間は{$rest_time}分です<br>";
                } else if((($worktime_minute-45)/60)>=6 && (($worktime_minute-45)/60)<8){
                    $rest_time = 45;
                    echo "休憩時間は{$rest_time}分です<br>";
                } else {
                    $rest_time = 0;
                    echo "休憩時間はありません<br>";
                }
        

                $sql = 'SELECT 給料額,残業代割増率 from 給料関係設定';
                $stmt = $this->db->query($sql);
                $resister = $stmt->fetch();
                $salary = $resister['給料額'];
                $parsent = $resister['残業代割増率'];

                $kari = $parsent+100;
                $zangyou = $salary*($kari/100);

                if((($worktime_minute-60)/60)>8){//法定外残業
                    $money = 8*$salary+round((($worktime_minute-60)/60)-8)*$zangyou;
                }else{
                    $money = round((($worktime_minute-$rest_time)/60)*$salary);
                }
        
        
                $timeID = date('Y-m-d H:i:s');
        
                echo $timeID.' '.$userID.' '.$name.' '.$date.' '.$inTime.' '.$outTime.' '.$rest_time.' '.$money.' '.$code;
                
                if(strcmp($code, "insert") == 0){
                    $this->insertShiftData($timeID, $userID, $name, $date, $inTime, $outTime, $rest_time, $money);
                }else if(strcmp($code, "update") == 0){
                    $this->updateShiftData($timeID, $userID, $name, $date, $inTime, $outTime, $rest_time, $money);
                }// else if(strcmp($code, "delete") == 0){
                //     $this->deleteShiftData($timeID, $userID, $name, $date, $inTime, $outTime, $rest_time, $money);
        
                // }
        
            }
        
        
        
            private function insertShiftData($timeID, $userID, $name, $date, $inTime, $outTime, $rest_time, $money) {
                try {
                    $count = $this->db->exec("INSERT INTO request_shift(timeID,userID,name,date,in_time,out_time,rest_time,money) VALUES ('$timeID','$userID','$name','$date','$inTime','$outTime','$rest_time','$money')");
        
                    if ($count) {
                        $alert = "<script type='text/javascript'>alert('登録完了');</script>";
                        echo $alert;
                        echo "<form method='post' id='hiddenForm'>";
                        echo "<input type='hidden' id='hiddenDate' name=date value='$date'>";
                        echo "</form>";
                    // JavaScriptでフォームを生成して送信
                        echo "<script type='text/javascript'>
                                window.onload = function() {
                                    var form = document.createElement('form');
                                    form.method = 'post';
                                    form.action = ''; // 同じページのURLを設定
        
                                    var inputDate = document.createElement('input');
                                    inputDate.type = 'hidden';
                                    inputDate.name = 'date';
                                    inputDate.value = '" . htmlspecialchars($date, ENT_QUOTES, 'UTF-8') . "';
        
                                    form.appendChild(inputDate);
                                    document.body.appendChild(form);
        
                                    form.submit();
                                };
                            </script>";
                    }else{//登録できなかった
                        $alert = "<script type='text/javascript'>alert('登録できませんでした');</script>";
                        echo $alert;
                    }
        
                } catch (PDOException $e) {
                    echo "データベースエラー：" . $e->getMessage();
                }
            }//insertメソッド終わり
        
        
            private function updateShiftData($timeID, $userID, $name, $date, $inTime, $outTime, $rest_time, $money) {
        
                try {
                    $count = $this->db->exec("UPDATE request_shift SET timeID='$timeID',in_time='$inTime' , out_time='$outTime',money ='$money',rest_time='$rest_time' WHERE date = '$date' AND userID = '$userID'  ");
        
                    if ($count) {
                        $alert = "<script type='text/javascript'>alert('更新完了');</script>";
                        echo $alert;
                        echo "<form method='post' id='hiddenForm'>";
                        echo "<input type='hidden' id='hiddenDate' name=date value='$date'>";
                        echo "</form>";
                    // JavaScriptでフォームを生成して送信
                        echo "<script type='text/javascript'>
                                window.onload = function() {
                                    var form = document.createElement('form');
                                    form.method = 'post';
                                    form.action = ''; // 同じページのURLを設定
        
                                    var inputDate = document.createElement('input');
                                    inputDate.type = 'hidden';
                                    inputDate.name = 'date';
                                    inputDate.value = '" . htmlspecialchars($date, ENT_QUOTES, 'UTF-8') . "';
        
                                    form.appendChild(inputDate);
                                    document.body.appendChild(form);
        
                                    form.submit();
                                };
                            </script>";
                    }else{//登録できなかった
                        $alert = "<script type='text/javascript'>alert('更新できませんでした');</script>";
                        echo $alert;
                    }
        
                } catch (PDOException $e) {
                    echo "データベースエラー：" . $e->getMessage();
                }
        
        
            }
        
        
            public function deleteShiftData( $userID, $date) {
        
                try {
        
                    $count = $this->db -> query("DELETE FROM request_shift WHERE userID = '$userID' AND date = '$date'");
        
        
                    if ($count) {
                        $alert = "<script type='text/javascript'>alert('削除完了');</script>";
                        echo $alert;

                        echo "<form method='post' id='hiddenForm'>";
                        echo "<input type='hidden' id='hiddenDate' name=date value='$date'>";
                        echo "</form>";
                        echo "<script type='text/javascript'>
                            window.onload = function() {
                                var form = document.createElement('form');
                                form.method = 'post';
                                form.action = ''; // 同じページのURLを設定

                                var inputDate = document.createElement('input');
                                inputDate.type = 'hidden';
                                inputDate.name = 'date';
                                inputDate.value = '" . htmlspecialchars($date, ENT_QUOTES, 'UTF-8') . "';

                                form.appendChild(inputDate);
                                document.body.appendChild(form);

                                form.submit();
                            };
                        </script>";


                    }else{//登録できなかった
                        $alert = "<script type='text/javascript'>alert('削除できませんでした');</script>";
                        echo $alert;
                    }
        
                } catch (PDOException $e) {
                    echo "データベースエラー：" . $e->getMessage();
                }
        
        
            }        
        
        }//クラス終わり 
        
        // // クラスのインスタンス化
        //$db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");


        // $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // $shiftProcessor = new ShiftProcessor($db);
        
        // // 例として時間データを渡す
        // $shiftProcessor->calculateShiftData("09:00:00", "18:00:00", "2022-03-01", 6060, "志尊淳");
        
        ?>

<script>

function dateSend(){

}

</script>
        
    
</body>
</html>