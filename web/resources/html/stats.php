<a href="" class="btn btn-info stats-card">Neuen Chat analysieren</a>
<div class="card stats-card">
    <h3 class="card-header">Gesamt Statistik</h3>
    <div class="card-body">
        <div>
            <img class="icon" src="resources/img/glyphicons-422-send.png"> <span id="countNachrichten"></span> Nachrichten davon <img class="icon" src="resources/img/glyphicons-139-picture.png"> <span id="countBilder"></span> Medien</div>
        <div><img src="resources/img/glyphicons-4-user.png" class="icon"> <span id="countTeilnehmer"></span> Teilnehmer</div>
        <div><img src="resources/img/glyphicons-55-clock.png" class="icon"> Zwischen <span id="startTime"></span> und <span id="endTime"></span> Uhr schreibt ihr am öftesten, insgesamt <img src="resources/img/glyphicons-422-send.png" class="icon"> <span id="countMaxNachrichten"></span> Nachrichten</div>
        <div><img src="resources/img/glyphicons-605-text-size.png" class="icon"> Durchschnittlich schreibt ihr Nachrichten mit <span id="messageSizeAverage"></span> Buchstaben, insgesamt habt ihr <img src="resources/img/glyphicons-606-text-color.png" class="icon"> <span id="messageSizeSum"></span> Zeichen geschrieben.</div>
        <div><img src="resources/img/glyphicons-46-calendar.png" class="icon"> Am <span id="bestDay"></span> habt ihr mit insgesamt <span id="bestDayCount"></span> Nachrichten euren aktivsten Tag gehabt.</div>
    </div>
</div>
<div class="card stats-card">
    <h3 class="card-header">Nachrichten Verteilung auf Teilnehmer</h3>
    <div class="card-body">
        <div class="floatLeft">
            <h4>Nachrichten Verteilung</h4>
            <div id="chart1"></div>
        </div>
        <div class="floatLeft">
            <h4>Medien Verteilung</h4>
            <div id="chart2"></div>
        </div>
        <div class="floatLeft">
            <h4>Nachrichtenlänge</h4>
            <div id="chartMessageSize"></div>
        </div>
    </div>
</div>
<div class="card stats-card">
    <h3 class="card-header">Zeitverteilung der Nachrichten</h3>
    <div class="card-body">
        <div class="floatLeft">
            <div id="chart3"></div>
        </div>
    </div>
</div>