<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アイコン画像変更</title>
</head>

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
    $message = $_SESSION['login_name'];
    $num = $_SESSION['login_ID'];

    // echo $num . ' ' . $message . 'さん';

   $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");


    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    ?>

    <style>
        /* 丸くするためのスタイル */
        .rounded-image {
            /* border-radius: 50%; 丸みを持たせる  */
            overflow: hidden;
            /* はみ出た部分を隠す */
            width: 300px;
            /* 画像のサイズを調整 */
            height: 300px;
            /* 画像のサイズを調整 */
        }
    </style>


    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>



    <?php

    $pic_id = $num;


    $sql = <<<SQL
    SELECT image_data
    FROM images
    WHERE imageID = :pic_id;
SQL;

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':pic_id', $pic_id);
    $stmt->execute();
    $image_row = $stmt->fetch(PDO::FETCH_ASSOC);


    if ($image_row) {
        $img_data = base64_encode($image_row['image_data']);

        if (isset($_POST['update'])) {
            // 変更ボタンを表示
            echo '<button onclick="window.history.back();">戻る</button>';
            echo '<div align="center">';
            echo '<form method="POST" action="upimage.php"  enctype="multipart/form-data">';
            echo '<input type="file" name="upimg" accept="image/*" onchange="previewImage(event)" required><br>';
            echo '<img class="rounded-image" id="preview" src="#" ><br>';
            echo '<input type="submit" name="upload" value="アップロード" id="uploadForm">';
            echo '</form>';
            echo '</div>';

        } else {
            echo '<div align="center">';
            echo '<img class="rounded-image" src="data:image/jpeg;base64,' . $img_data . '" width="100%" height="100%">';
            echo '<form method="POST" action="upimage.php">';
            // echo '<img id="preview" src="data:image/jpeg;base64,'.$img_data.'" alt="画像プレビュー">';
            echo '<input type="submit" name="update" value="変更する">';
            echo '</form>';
            echo '</div>';
            // 変更ボタンが押された場合にアップロードフォームが表示されるようにする
        }
    } else {
        echo '<form method="POST" action="" enctype="multipart/form-data">';
        echo '<input type="file" name="upimg" accept="image/*" onchange="previewImage(event)">';
        echo '<input type="submit" name="upload" value="アップロード">';
        echo '<img id="preview" class="rounded-image" src="#" >';
        echo '</form>';
    }


    if (isset($_POST['upload'])) {
        // データベースへの接続

        $pic_id = $num;

        $fp = fopen($_FILES['upimg']['tmp_name'], "rb");
        $img = fread($fp, filesize($_FILES['upimg']['tmp_name']));
        fclose($fp);

        $sql = <<<SQL
            INSERT INTO images (image_data, imageID)
            VALUES (:PIC, :pic_id)
            ON DUPLICATE KEY UPDATE image_data = :PIC;
            SQL;


        $stmt = $db->prepare($sql);
        $stmt->bindValue(':pic_id', $pic_id);
        $stmt->bindValue(':PIC', $img);
        $con = $stmt->execute();
        $stmt = null;

        if ($con) {
            // 画像データをbase64エンコード
            $img_data = base64_encode($img);

    ?>
            <script>
                window.onload = function() {
                    var newImgData = '<?php echo $img_data; ?>';
                    var imgElement = document.querySelector('.rounded-image');
                    imgElement.src = 'data:image/jpeg;base64,' + newImgData;

                    alert('データが登録されました。');
                    // 画像のsrc属性を更新して新しい画像を表示する
                };
            </script>
    <?php


        }
    }

?>
</body>

</html>