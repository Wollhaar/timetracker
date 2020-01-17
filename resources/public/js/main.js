let doBreak = 'begin';
let windowObject;
let strWindowFeatures = 'toolbar=1,scrollbars=1,location=1,statusbar=0,menubar=1,resizable=1,width=430,height=350';
let url = 'http://localhost/timetracker/index.php';

openWindow();

function makeBreak(str) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

            if(str == 'begin'){
                document.getElementById("break").innerHTML = '<p>Start:' + this.responseText + '</p>';

                doBreak = 'end';
                document.getElementById("break_button").value = doBreak.toUpperCase();
            }
            if(str == 'end'){
                document.getElementById("break").innerHTML += '<p>Ende:' + this.responseText + '</p>';

                doBreak = 'begin';
                document.getElementById("break_button").value = doBreak.toUpperCase();
            }

        }
    };
    xmlhttp.open("GET", "track.php?q=" + str, true);
    xmlhttp.send();
}

function endWork() {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET", "track.php?f=finish", true);
    xmlhttp.send();

    window.close()
}

function openWindow(){
    windowObject = window.open(url, 'Timetracker', strWindowFeatures);

}