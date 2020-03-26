<?php include_once 'track.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link type="text/css" rel="stylesheet" href="resources/public/css/main.less" />
<script type="text/javascript" src="resources/public/js/main.js"></script>
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
<p><b>Take a break....</b></p>
<form>
    <input type="button" onclick="makeBreak(doBreak)" id="break_button" value="Break" />
</form>
<p><i>Time:</i> <span id="break"></span></p>
<form style="margin-top: 30px;">
    <input type="button" onclick="endWork()" id="finish_button" value="FINISH" />
</form>
</div>
</body>
</html>