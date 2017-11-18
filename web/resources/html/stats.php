<a href="" class="btn btn-info stats-card"><?= __("Analyse new chat") ?></a>
<div class="card stats-card">
    <h3 class="card-header"><?= __("Overview") ?></h3>
    <div class="card-body">
        <div>
            <?= __("<img class='icon' src='resources/img/glyphicons-422-send.png'> <span id='countNachrichten'></span> messages therefrom <img class='icon' src='resources/img/glyphicons-139-picture.png'> <span id='countBilder'></span> media content")?>
        </div>
        <div>
            <?= __("<img src='resources/img/glyphicons-4-user.png' class='icon'> <span id='countTeilnehmer'></span> member")?>
        </div>
        <div>
            <?= __("<img src='resources/img/glyphicons-55-clock.png' class='icon'> You write most often between <span id='startTime'></span> and <span id='endTime'></span> o'clock with a total of <img src='resources/img/glyphicons-422-send.png' class='icon'> <span id='countMaxNachrichten'></span> messages")?>
        </div>
        <div>
            <?= __("<img src='resources/img/glyphicons-605-text-size.png' class='icon'> On average you write messages with <span id='messageSizeAverage'></span> letters. Overall, you have written <img src='resources/img/glyphicons-606-text-color.png' class='icon'> <span id='messageSizeSum'></span> characters.")?>
        </div>
        <div>
            <?= __("<img src='resources/img/glyphicons-46-calendar.png' class='icon'> On <span id='bestDay'></span> you had your most active day with a total of <span id='bestDayCount'></span> messages.")?>
        </div>
    </div>
</div>
<div class="card stats-card">
    <h3 class="card-header"><?= __("Message distribution") ?></h3>
    <div class="card-body">
        <div class="floatLeft">
            <h4><?= __("Messages") ?></h4>
            <div id="chart1"></div>
        </div>
        <div class="floatLeft">
            <h4><?= __("Media") ?></h4>
            <div id="chart2"></div>
        </div>
        <div class="floatLeft">
            <h4><?= __("Message length") ?></h4>
            <div id="chartMessageSize"></div>
        </div>
    </div>
</div>
<div class="card stats-card">
    <h3 class="card-header"><?= __("Time distribution") ?></h3>
    <div class="card-body">
        <div class="floatLeft">
            <div id="chart3"></div>
        </div>
    </div>
</div>