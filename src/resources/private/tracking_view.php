<!DOCTYPE html>
<html>
<head>
    <title>Timetracking</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link type="text/css" rel="stylesheet/less" href="<?php echo PUBLIC_PATH ?>css/main.less" />
    <script src="https://ajax.aspnetcdn.com/ajax/jquery/jquery-1.9.0.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/3.11.1/less.min.js" ></script>
    <script type="text/javascript" src="<?php echo PUBLIC_PATH ?>less.js-master/dist/less.min.js"></script>
    <script type="text/javascript" src="<?php echo PUBLIC_PATH ?>js/main.js"></script>
</head>
<body>
<div class="header">
    <h2>Your own Timetracker
    <span id="timer" style="display: none;text-align: right;"></span>
    </h2>
</div>

<div class="container wrapper">
    <div class="row">
        <div class="col-9 work-start">
            <label for="time-list"><b>Zeitleiste:</b></label>
            <select id="time-list" class="form-control" name="time_list" size="5" multiple disabled>
            </select>
        </div>
        <div class="col-3">
            <label for="month-list"><b>Monate:</b></label>
            <select id="month-list" class="form-control" name="time_list" size="5" multiple></select>
        </div>
    </div>
    <div class="row">
        <div class="col-3 start">
            <input class="form-control" type="button" onclick="startWork()" id="start-button" value="Beginne" />
        </div>
        <div class="col-3 break">
            <input class="form-control" type="button" onclick="makeBreak(doBreak)" id="break-button" value="Pause" disabled />
        </div>
        <div class="col-3 work-end">
            <input class="form-control" type="button" onclick="endWork()" id="finish-button" value="Ende" disabled />
        </div>
        <div class="col-3 load-pdf">
            <input class="form-control" type="button" onclick="download_PDF()" id="pdf-button" value="PDF" />
        </div>
    </div>
</div>
<div class="footer"></div>
</body>
</html>