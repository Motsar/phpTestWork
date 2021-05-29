<!doctype html>
<html lang="eng">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Stargazings">
    <meta name="author" content="Martin Mõtsar">
    <title>Star observation in Estonia</title>
    <link type="text/css" rel="stylesheet" href="public/CSS/style.css">
</head>

<body>
    <header>
        <h1>Stargazing in Estonia</h1>
    </header>
    <div class="body_content">
        <div id="content">
            <div class="body-row center">
                <div class="rotate">
                    <div class="headers">
                        <h1>Star observation events in Estonia</h1>
                        <h3>On dates 31.05.2021, 01.06.2021, 02.06.2021, 03.06.2021, 04.06.2021</h3>
                    </div>
                    <div class="row headers">
                        <div class="column headers">
                            <h5>Events are held in following towns: </h5>
                        </div>
                        <div class="column headers">
                            <h5>Tallinn<br>Tartu<br>Narva<br>Pärnu<br>Jõhvi<br>Jõgeva<br>Põlva<br>Valga</h5>
                        </div>
                        <div class="column headers">
                            <h5>Sessions start at: </h5>
                        </div>
                        <div class="column headers">
                            <h5>20:00<br>23:00<br>02:00<br>05:00</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="body-row center">
                <h4>Register to Event</h4>
                <h4>Events are being held only in the case of clear sky</h4>
                <h4>Event sessions are being compared to weather conditions</h4>
                <?php
                include("./formPlugin/FormView/eventForm.php")
                ?>
            </div>
        </div>
    </div>
    <div class="footer">
        <p>No kopirait</p>
    </div>
</body>