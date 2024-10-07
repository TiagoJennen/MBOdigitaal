<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keuzedelen Overzicht</title>
    <?php require '../views/templates/head.php' ?>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .container {
            display: flex;
            justify-content: space-around;
            padding: 20px;
        }
        .leftBox {
            margin-left: -90px;
            border: none;
            padding: 10px;
            border-radius: 10px;
            width: 377;
            height: 267px;
            background-color: whitesmoke;
        }
        .middleBox {
            margin-top: 320px;
            margin-left: -645px;
            border: none;
            padding: 10px;
            border-radius: 10px;
            height: 307px;
            width: 320px;
            background-color: whitesmoke;
        }
        .rightBox {
            padding: 20px;
            width: 600px;
        }
        .leftBox h2 {
            text-align: center;
            font-size: larger;
            font-weight: 500;
            margin-bottom: 15px;
        }
        .leftBox p {
            font-size: small;
        }
        .middleBox h2 {
            text-align: center;
            font-size: larger;
            font-weight: 500;
            margin-bottom: 15px;
        }
        .middleBox p {
            font-size: small;
            text-align: center;
            margin-bottom: 2px;
            margin-top: 5px;
        }
        .rightBox h2 {
            font-size: 30PX;
            font-weight: 500;
            margin-top: 70px;
            margin-left: -225px;
        }
        .rightBox p {
            font-size: 20PX;
            margin-bottom: 15px;
            margin-left: -160px;
        }
        .rightBox strong {
            font-size: 20PX;
            margin-bottom: 15px;
            margin-left: 50px;
        }
        .rightBox h3 {
            font-size: 30PX;
            font-weight: 500;
            margin-bottom: 15px;
            margin-left: -225px;
        }
        .exam-score {
            font-size: 16px;
            text-align: center;
            color: white;
            margin-left: 260px;
            margin-top: -35px;
            background-color: #007bff;
            padding: 4px;
            margin-right: 10px;
            width: 30px;
            height: 30px;
        }
        .course-list {
            margin-top: 50px;
            margin-left: -245px;
            border-spacing: 40px;
            padding-bottom: 1em;
            font-size: large;
        }
        .course-list p{
            margin-top: -25px;
            margin-left: 40px;
            margin-bottom: 30px;
            font-size: large;
        }
        .course-list input {
            margin-right: 10px;
        }
        .course-info {
            margin-top: 10px;
        }
        .info-btn {
            margin-left: 100px;  
            margin-bottom: 2px;
            font-size: 12px;                  
            background-color: #007bff;
            color: white;
            padding: 0px 15px;
            border: none;
            border-radius: 15px;
            cursor: pointer;
        }
        .deadlines {
            text-align: center;
            margin-top: 30px;
        }
        .deadlinesLine{
            width: 340px;
            margin-left: -30px;
            margin-right: -30px;
            margin-top: 20px;
            height: 5px;
            background-color: white;
        }
        .deadlines p {
            margin: 5px 0;
            font-weight: 600;
        }
    </style>
</head>
<body>
<?php require '../views/templates/menu.php' ?>
<div class="container">
    <div class="leftBox">
        <h2>Examen</h2>
        <p>K0023 Digitale vaardigheden gevorderd <br>(240 SBU)</p>
        <div class="exam-score">8</div>
    </div>

    <div class="middleBox">
        <h2>Gekozen keuzedelen</h2>
        <p>K0023 Digitale vaardigheden gevorderd (240 SBU)</p>
        <button class="info-btn">Informatie</button>
        <p>K0072 Ondernemend gedrag (240 SBU)</p>
        <button class="info-btn">Informatie</button>
        <p>K0505 Verdieping software (240 SBU)</p>
        <button class="info-btn">Informatie</button>
        <div class="deadlinesLine">
        </div>
        <div class="deadlines">
            <p>Deadline: 25/09/2024</p>
        </div>
    </div>

    <div class="rightBox">
        <h3>Overzicht keuzedelen</h3>
        <p>Student: <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Abdiraman Elmi</strong></p>
        <p>Opleiding: <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Software Development</strong></p>
        <p>Minimaal aantal SBU: <strong>720</strong></p>

        <h2>Selecteer keuzedelen</h2>
        <div class="course-list">
        <p><label><input type="checkbox"> &nbsp;&nbsp;&nbsp;K0788 Basis programmeren van games (240 SBU)</label></p>
        <p><label><input type="checkbox" checked> &nbsp;&nbsp;&nbsp;K0023 Digitale vaardigheden gevorderd (240 SBU)</label></p>
        <p><label><input type="checkbox"> &nbsp;&nbsp;&nbsp;K0495 Fotografie basis (240 SBU)</label><br></p>
        <p><label><input type="checkbox"> &nbsp;&nbsp;&nbsp;K0226 Inspelen op innovaties (240 SBU)</label><br></p>
        <p><label><input type="checkbox" checked> &nbsp;&nbsp;&nbsp;K0072 Ondernemend gedrag (240 SBU)</label><br></p>
        <p><label><input type="checkbox"> &nbsp;&nbsp;&nbsp;K0800 Oriëntatie op ondernemerschap (240 SBU)</label><br></p>
        <p><label><input type="checkbox" checked> &nbsp;&nbsp;&nbsp;K0505 Verdieping software (240 SBU)</label><br></p>
        <p><label><input type="checkbox"> &nbsp;&nbsp;&nbsp;K0927 Praktijkonderzoek (480 SBU)</label></p>
        </div>
    </div>
</div>
    <?php require '../views/templates/footer.php' ?>
</body>
</html>
