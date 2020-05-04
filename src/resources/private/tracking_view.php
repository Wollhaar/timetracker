<?php

if ($_GET['pdf']) {
    $doc_control->buildPDF();
}

if ($_GET['f']) {
    $close_page = true;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Timetracking</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link type="text/css" rel="stylesheet/less" href="<?php echo PUBLIC_PATH ?>css/main.less" />
<script type="text/javascript" src="<?php echo PUBLIC_PATH ?>less.js-master/dist/less.min.js"></script>
<script type="text/javascript" src="<?php echo PUBLIC_PATH ?>js/main.js"></script>
</head>
<body>
<div class="header"><h2>Your own Timetracker</h2></div>

<form>
    <input type="button" onclick="testPDF(doBreak)" id="pdf_button" value="PDF-Download" />
</form>
<div class="wrapper">
    <div class="work-start">
        <p><b>Start working:</b><br />
        <span class="time-text">
        <?php
                echo date('d M Y H:i', strtotime('+2 hours', $start_time));
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