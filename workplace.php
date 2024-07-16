<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div align=center>
        <form action="in_shift.php" method='post' id="example" accept-charset="UTF-8">
            <label>バイト先名</label>
            <input name=placename><br>
            <label>給料</label> 
            <select name="pref" >   
                <option>時給</option>
                <option>日給</option>
            </select>
            <input name='salary'>円<br>
            <label>交通費</label>
            <input name=fare>円<br>
            <label>締め日</label>
            <input name=cutoff_day><br>
            <label>給料日</label>
            <input name=pay_day>
            <input type=submit name=set>
        </form>
    </div>

    <!-- form="example"   -->

</body>
</html>