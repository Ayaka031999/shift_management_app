<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Time Input</title>
</head>

<body>
  <label for="time" style="font-size:17px;">予定の時刻：</label>


  <?php
  // if(isset($_POST['submit'])){
  //     $hour = $_POST['hour'];
  //     $minute = $_POST['minute'];

  //     // 時間を"hh:mm"の形式に整形
  //     $timeString = sprintf('%02d:%02d', $hour, $minute);

  //     // フォーマットに従って時間型に変換
  //     $time = date_create_from_format('H:i', $timeString);

  //     // 変換された時間を出力
  //     echo $time->format('H:i');
  // }
  ?>

  <!-- <form method="post">
    <select name="hour" style="font-size:17px;" required>
        <?php
        // for($i=0;$i<24;$i++){
        //     $hour = ($i < 10) ? '0'.$i : $i;
        //     echo '<option style="font-size:17px;" value="'.$hour.'">'.$hour.'</option>';
        // }
        ?>
    </select>
    <span>:</span>
    <select name="minute" style="font-size:17px;" required>
        <?php
        // for($k=0;$k<=45;$k+=15){
        //     $minute = ($k == 0) ? '00' : $k;
        //     echo '<option style="font-size:17px;" value="'.$minute.'">'.$minute.'</option>';
        // }
        ?>
    </select>
    <button type="submit" name="submit">送信</button>
</form>     -->


  <div>

  </div>

  <form method="post">


    <!------朝------->
    <select id="AsastartHours" name="AsaStarthours">
      <option value=""></option>

    </select>
    <span>:</span>
    <select id="AsastartMinutes" name="AsaStartminutes">
      <option value=""></option>

    </select>

    <span>~</span>

    <select id="AsaendHours" name="AsaEndhours">
      <option value=""></option>

    </select>
    <span>:</span>
    <select id="AsaendMinutes" name="AsaEndminutes">
      <option value=""></option> <!-- 他の分オプション -->
    </select>

    <input id="AsaStarttimeRange" type="hidden" name="朝_時間帯_始">
    <input id="AsaEndtimeRange" type="hidden" name="朝_時間帯_終">


    <br>
    <!------昼------->
    <select id="HirustartHours" name="HiruStarthours">
      <option value=""></option>
    </select>
    <span>:</span>
    <select id="HirustartMinutes" name="HiruStartminutes">
      <option value=""></option>
    </select>

    <span>~</span>

    <select id="HiruendHours" name="HiruEndhours">
      <option value=""></option>
    </select>
    <span>:</span>
    <select id="HiruendMinutes" name="HiruEndminutes">
      <option value=""></option> <!-- 他の分オプション -->
    </select>

    <input id="HiruStarttimeRange" type="hidden" name="昼_時間帯_始">
    <input id="HiruEndtimeRange" type="hidden" name="昼_時間帯_終">
    <br>


    <!------夜------->
    <select id="YorustartHours" name="YoruStarthours">
      <option value=""></option>

    </select>
    <span>:</span>
    <select id="YorustartMinutes" name="YoruStartminutes">
      <option value=""></option>

    </select>

    <span>~</span>

    <select id="YoruendHours" name="YoruEndhours">
      <option value=""></option>

    </select>
    <span>:</span>
    <select id="YoruendMinutes" name="YoruEndminutes">
      <option value=""></option> <!-- 他の分オプション -->
    </select>

    <input id="YoruStarttimeRange" type="hidden" name="夜_時間帯_始">
    <input id="YoruEndtimeRange" type="hidden" name="夜_時間帯_終">




    <input id="submitButton" type="submit" value="Submit" disabled>
  </form>

  <?php

  if (isset($_POST['朝_時間帯_始']) && isset($_POST['朝_時間帯_終']) && isset($_POST['昼_時間帯_始']) && isset($_POST['昼_時間帯_終']) && isset($_POST['夜_時間帯_始']) && isset($_POST['夜_時間帯_終'])) {
    echo $_POST['朝_時間帯_始'] . '~' . $_POST['朝_時間帯_終'].'<br>';
    echo $_POST['昼_時間帯_始'] . '~' . $_POST['昼_時間帯_終'].'<br>';
    echo $_POST['夜_時間帯_始'] . '~' . $_POST['夜_時間帯_終'].'<br>';

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



      var submitButton = document.getElementById("submitButton");

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


        if (AsastartHours !== "" && AsastartMinutes !== "" && AsaendHours !== "" && AsaendMinutes !== "" && HirustartHours !== "" && HirustartMinutes !== "" && HiruendHours !== "" && HiruendMinutes !== "" && YorustartHours !== "" && YorustartMinutes !== "" && YoruendHours !== "" && YoruendMinutes !== "") {
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


          submitButton.disabled = false;
        } else {
          timeRangeInput.value = "";
          submitButton.disabled = true;
        }
      }
    });
  </script>

</body>

</html>