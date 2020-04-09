<!DOCTYPE html>
<html>
<head>
    <title>Timetracking</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link type="text/css" rel="stylesheet/less" href="<?php echo $pwd_view . $public ?>css/main.less" />
<script type="text/javascript" src="<?php echo $pwd_view . $public ?>less.js-master/dist/less.min.js"></script>
<script type="text/javascript" src="<?php echo $pwd_view . $public ?>js/main.js"></script>
</head>
<body>
<div class="header"><h2>Your own Timetracker</h2></div>
<div class="wrapper">
    <div class="work-start">
        <p><b>Start working:</b><br />
            <span class="time-text">
                <?php
                echo date('d M Y H:i', $start_time) . '  <i>' . date('P e', $start_time) . '</i>';
                ?>
            </span>
        </p>
    </div>
    <div class="break">
<p><b>Take a break....</b></p>
<form>
    <input type="button" onclick="makeBreak(doBreak)" id="break_button" value="Break" />
</form>
        <div id="break">
            <p><i>Time:</i></p>
        </div>
    </div>
    <div class="work-end">
<form>
    <input type="button" onclick="endWork()" id="finish_button" value="FINISH" />
</form>
    </div>
</div>
<div class="footer"></div>
</body>
</html>