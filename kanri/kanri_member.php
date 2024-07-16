<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="CSS\member.css">
    <title>Dynamic Table with Row and Column Totals</title>
</head>

    <?php
    //セッションを使うことを宣言
    session_start();

    //ログインされていない場合は強制的にログインページにリダイレクト
    if (!isset($_SESSION['login_name'])){
        header("Location: ../login.php");
        exit();
    }
            
    //ログインされている場合は表示用メッセージを編集
    $message = $_SESSION['login_name'];
    $num = $_SESSION['login_ID'];


    // strcmp($message, "123456admin") != 0 || strcmp($num, "123456admin")

    // if($message != "admin" || $num != "123456"){
    //     header("Location: ../login.php");
    //     exit();
    // }
            
    // echo $num;
    // echo "{$message}さん"; 
   $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
?>

<header>
    <h1><a href="kanri_top.php"  target="_top">シフト管理</a></h1><?php echo '👤'.$num.' '.$message.'さん';?>
    <ul class="menu">
        <li class="menu-item"><a href="kanri_shiftdata.php"  class="menu-link" target="_top">全体シフト</a>
        <li class="menu-item"><a href="kanri_member.php" class="menu-link" target="_top">メンバー・ポジション設定</a>
        <li class="menu-item"><a href="kanri_chat.php" class="menu-link" target="_top">店長チャット</a>
        <li class="menu-item"><a href="simekiri.php" class="menu-link" target="_top">シフトしめきり設定</a>
        <li class="menu-item"><a href="kyuyo.php" class="menu-link" target="_top">給与設定</a>
        <li class="menu-item"><?php
            print '<form method="post" accept-charset="UTF-8">';
            print '<input type="submit" name=logout value="ログアウト">';
            print '</form>';
        
            $i = filter_input(INPUT_POST, "logout");
        
            if(isset($i)){
                $_SEESSION = array();
                session_destroy();
                header("Location: login.php");
                exit();
            }
        
        ?>

    </ul>
</header>
<div class="separator"></div>

<body>

<?php 

$rows = filter_input(INPUT_POST, "rows");

?>

<form method="post">
    <label for="rows">行数：</label>
    <input type="number" id="rows" name="rows" min="1" value="<?= isset($rows) ? $rows : 1 ?>">
    <input type="submit" name="createTable" value="表を作成">
</form>

<?php

$daysOfWeek = ['月','火', '水', '木', '金', '土', '日'];
$cols = 7;

$sql = $db->query("SELECT ポジション名, 月, 火, 水, 木, 金, 土, 日 FROM 必要人数表");
$resister = $sql->fetchAll();


if(!empty($resister)){

    // 2次元配列を初期化
    $twoDimensionalArray = [];

    $count=0;

    foreach ($resister as $result) {
        // データを1行分の連想配列として追加
        $rowData = [
            'ポジション名' => $result['ポジション名'],
            '月' => $result['月'],
            '火' => $result['火'],
            '水' => $result['水'],
            '木' => $result['木'],
            '金' => $result['金'],
            '土' => $result['土'],
            '日' => $result['日'],
        ];
        // 2次元配列に追加
        $twoDimensionalArray[] = $rowData;
        $count++;
    }    

// クエリ実行
// $query = $db->query("SELECT MAX(日) AS 日, MAX(月) AS 月, MAX(火) AS 火, MAX(水) AS 水, MAX(木) AS 木, MAX(金) AS 金, MAX(土) AS 土 FROM 必要人数表");

// // 結果を取得
// $result = $query->fetch(PDO::FETCH_ASSOC);

// // 曜日の順序に従ってデータを格納する配列
// $resultArray = [
//     $result['日'], // 日曜日
//     $result['月'], // 月曜日
//     $result['火'], // 火曜日
//     $result['水'], // 水曜日
//     $result['木'], // 木曜日
//     $result['金'], // 金曜日
//     $result['土']  // 土曜日
// ];

// // 結果表示
// print_r($resultArray);

    /***表に表示***/
    echo '<form method="post">';
    echo '<table>';
    echo '<tr>';
    echo '<th>ポジション名</th>';

    // 列のヘッダーを表示
    for ($j = 0; $j < $cols; $j++) {
        echo '<th align=center>'.$daysOfWeek[$j].'</th>';
    }
    echo '</tr>';

    $i=0;
    $j=0;
    foreach ($twoDimensionalArray as $rowData) {
        echo '<tr>';
        foreach ($rowData as $value) {
            if($j>7) $j=0;
            if($j==0){
            echo '<td><input type="text" name="cell_'.$i.'_'.$j.'" value="'.$value.'"></td>';
            }else{
            echo '<td><input type="number" name="cell_'.$i.'_'.$j.'" value="'.$value.'"></td>';//cell_'.$i.'_'.$j.'
            }
            $j++;
        }
        echo '</tr>';
        $i++;
    }
    echo '</table>';
    echo '<input type="hidden" name="rows" value='.$count.'>';
    echo '<input type="submit" name="upkeisan" value="計算して更新">';
    echo '</form>';

    $upkeisan =filter_input(INPUT_POST, "upkeisan");
    
    if (isset($upkeisan)) {//更新
        $buttn=2;
        echo "計算して更新<br>";
        $rows = $count-1;
        $cols = 8;
        // 二次元配列に値を格納
        $tableData = array();
        
        // 各列のセルの値を表示
        for ($j = 0; $j <$cols; $j++){//列
            $rowData = array();//各行ごと？
            ///$rowData[] = $_POST['position_'.$i];
            $kasan = 0;
            
            for ($i = 0; $i < $rows; $i++) {//行
                if($j==0){//ポジション名
                    $cellValue = isset($_POST['cell_'.$i.'_'.$j]) ? $_POST['cell_'.$i.'_'.$j] : null;
                    echo 'cell_'.$i.'_'.$j.'の値は、'.$cellValue.'<br>';
                    $rowData[] = $cellValue;
                    //if($i+1==$rows) $rowData[$rows] = "合計";
                    continue;
                }
    
                //$daysOfWeek[$j]
                $cellValue = isset($_POST['cell_'.$i.'_'.$j]) ? (int)$_POST['cell_'.$i.'_'.$j] : 0;
                echo 'cell_'.$i.'_'.$j.'の値は、'.$cellValue.'<br>';
                $rowData[] = $cellValue;
                $kasan += $cellValue;
            }
    
            if($j==0){
                $rowData[] = "合計";
            }else{
                // 合計をセット
                $rowData[] = $kasan;
            }
            echo '<br>';
            $tableData[] = $rowData;
        }
    
        // 二次元配列を表示
        echo '<pre>';
        print_r($tableData);
        echo '</pre>';
    
        function combine_array($first, $second){
            if (sizeof($first) > sizeof($second)) {
                return array_combine(array_slice($first, 0, sizeof($second)), $second);
            } else {
                return array_combine($first, array_slice($second, 0, sizeof($first)));
            }
        }
    
        $abbreviation = array("ポジション名","月","火","水","木","金","土","日");
        $uparray = combine_array($abbreviation, $tableData);
    
        echo '<pre>';
        print_r($uparray);
        echo '</pre>';
        $con=0;

        $sql = "DELETE FROM 必要人数表";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        
        
        foreach ($uparray['ポジション名'] as $position_index => $position_name) {
    
            echo $position_name;
            echo $uparray['月'][$position_index];
            echo $uparray['火'][$position_index];
            echo $uparray['水'][$position_index];
            echo $uparray['木'][$position_index];
            echo $uparray['金'][$position_index];
            echo $uparray['土'][$position_index];
            echo $uparray['日'][$position_index];
            echo '<br>';

            // プリペアドステートメントを準備
            //$sql = "UPDATE 必要人数表 SET ポジション名 = ?, 月 = ?, 火 = ? , 水 = ? , 木 = ? , 金 = ? , 土 = ? , 日 = ?";
            $sql = "INSERT INTO 必要人数表(ポジション名, 月, 火, 水, 木, 金, 土, 日) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $db->prepare($sql);
        
            // プリペアドステートメントにバインド
            $stmt->bindParam(1, $position_name, PDO::PARAM_STR);
            $stmt->bindParam(2, $uparray['月'][$position_index], PDO::PARAM_INT);
            $stmt->bindParam(3, $uparray['火'][$position_index], PDO::PARAM_INT);
            $stmt->bindParam(4, $uparray['水'][$position_index], PDO::PARAM_INT);
            $stmt->bindParam(5, $uparray['木'][$position_index], PDO::PARAM_INT);
            $stmt->bindParam(6, $uparray['金'][$position_index], PDO::PARAM_INT);
            $stmt->bindParam(7, $uparray['土'][$position_index], PDO::PARAM_INT);
            $stmt->bindParam(8, $uparray['日'][$position_index], PDO::PARAM_INT);
        
            // ステートメントを実行
            $con += $stmt->execute();
            
        }
        
        echo $con;
        if ($con == $rows+1) {
            $alert = "<script type='text/javascript'>alert('登録完了');</script>";
            echo $alert;
    ?>
        <script type='text/javascript'>
        // アラートを表示した後に実行
        window.onload = function() {
            // ページ遷移
            window.location.href = 'kanri_member.php';
        };
        </script>
    <?php
        }else{//登録できなかった
            $alert = "<script type='text/javascript'>alert('登録できませんでした');</script>";
            echo $alert;
        }
        

        
    }


}else{////////

    //$createTable = filter_input(INPUT_POST, "createTable");
    //$createTable = ;

    /***表作成されたら***/
    if (isset($_POST['createTable'])) {
        $rows = isset($rows) ? (int)$rows : 1;

        echo '<form method="post">';
        echo '<table>';
        echo '<tr>';
        echo '<th>ポジション名</th>';

        // 列のヘッダーを表示
        for ($j = 0; $j < $cols; $j++) {
            echo '<th align=center>'.$daysOfWeek[$j].'</th>';
        }
        echo '</tr>';

        // 各行ごとのデータ入力欄を表示
        for ($i = 0; $i < $rows; $i++) {
            echo '<tr>';
            // echo '<td><input type="text" name="position_'.$i.'" value=""></td>';
            // 各列の入力欄を表示
            for ($j = 0; $j < $cols+1; $j++) {
                if($j==0){
                    echo '<td><input type="text" name="cell_'.$i.'_'.$j.'" value=""></td>';
                    continue;
                } 
                echo '<td><input type="number" name="cell_'.$i.'_'.$j.'"></td>';
            }
            echo '</tr>';
        }

        echo '</table>';
        echo '<input type="hidden" name="rows" value='.$rows.'>';
        echo '<input type="submit" name="keisan" value="計算して登録">';
        echo '</form>';
    }

    $keisan = filter_input(INPUT_POST, "keisan");

    /***計算ボタンが押されたら***/
    if (isset($keisan)){
        $buttn=2;
        echo "計算<br>";
        $rows = filter_input(INPUT_POST, "rows");
        $cols = 8;
        // 二次元配列に値を格納
        $tableData = array();
        
        // 各列のセルの値を表示
        for ($j = 0; $j <$cols; $j++) {//列
            $rowData = array();//各行ごと？
            ///$rowData[] = $_POST['position_'.$i];
            $kasan = 0;
            
            for ($i = 0; $i < $rows; $i++) {//行
                if($j==0){//ポジション名
                    $cellValue = isset($_POST['cell_'.$i.'_'.$j]) ? $_POST['cell_'.$i.'_'.$j] : null;
                    echo 'cell_'.$i.'_'.$j.'の値は、'.$cellValue.'<br>';
                    $rowData[] = $cellValue;
                    //if($i+1==$rows) $rowData[$rows] = "合計";
                    continue;
                }
    
                //$daysOfWeek[$j]
                $cellValue = isset($_POST['cell_'.$i.'_'.$j]) ? (int)$_POST['cell_'.$i.'_'.$j] : 0;
                echo 'cell_'.$i.'_'.$j.'の値は、'.$cellValue.'<br>';
                $rowData[] = $cellValue;
                $kasan += $cellValue;
            }
    
            if($j==0){
                $rowData[] = "合計";
            }else{
                // 合計をセット
                $rowData[] = $kasan;
            }
    
            echo '<br>';
            $tableData[] = $rowData;
        }
    
        // 二次元配列を表示
        echo '<pre>';
        print_r($tableData);
        echo '</pre>';
    
        function combine_array($first, $second)
        {
            if (sizeof($first) > sizeof($second)) {
                return array_combine(array_slice($first, 0, sizeof($second)), $second);
            } else {
                return array_combine($first, array_slice($second, 0, sizeof($first)));
            }
        }
    
        $abbreviation = array("ポジション名", "月","火", "水","木","金","土","日");
        $uparray = combine_array($abbreviation, $tableData);
    
        echo '<pre>';
        print_r($uparray);
        echo '</pre>';
    
        
        $con=0;
        
        foreach ($uparray['ポジション名'] as $position_index => $position_name) {

    
            // プリペアドステートメントを準備
            $sql = "INSERT INTO 必要人数表(ポジション名, 月, 火, 水, 木, 金, 土, 日) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
        
            // プリペアドステートメントにバインド
            $stmt->bindParam(1, $position_name, PDO::PARAM_STR);
            $stmt->bindParam(2, $uparray['月'][$position_index], PDO::PARAM_INT);
            $stmt->bindParam(3, $uparray['火'][$position_index], PDO::PARAM_INT);
            $stmt->bindParam(4, $uparray['水'][$position_index], PDO::PARAM_INT);
            $stmt->bindParam(5, $uparray['木'][$position_index], PDO::PARAM_INT);
            $stmt->bindParam(6, $uparray['金'][$position_index], PDO::PARAM_INT);
            $stmt->bindParam(7, $uparray['土'][$position_index], PDO::PARAM_INT);
            $stmt->bindParam(8, $uparray['日'][$position_index], PDO::PARAM_INT);
            
        
            // ステートメントを実行
           $con += $stmt->execute();
        }
        
        echo $con;
        if ($con == $rows+1) {
            $alert = "<script type='text/javascript'>alert('登録完了');</script>";
            echo $alert;
    ?>
        <script type='text/javascript'>
        // アラートを表示した後に実行
        window.onload = function() {
            // ページ遷移
            window.location.href = 'kanri_member.php';
        };
        </script>
    <?php
        }else{//登録できなかった
            $alert = "<script type='text/javascript'>alert('登録できませんでした');</script>";
            echo $alert;
        }
    
    }//計算ボタンおわり
    
}///////////




// function return_sql($button){
//     if($button==1){
//         $sql = "UPDATE 必要人数表 SET ポジション名 = ?, 月 = ?, 火 = ? , 水 = ? , 木 = ? , 金 = ? , 土 = ? , 日 = ?";
//         return $sql;
//     }else{
//         $sql = "INSERT INTO 必要人数表(ポジション名, 月, 火, 水, 木, 金, 土, 日) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
//         return $sql;
//     }
// }

?>

</body>
</html>
