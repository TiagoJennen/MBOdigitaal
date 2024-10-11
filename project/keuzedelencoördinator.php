<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MBO Go Digital</title>
    <?php require '../views/templates/head.php'; ?>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        /* Main content */
        .content {
            padding: 20px;
        }

        .category-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .category {
            background-color: #e0e0e0;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            width: 15%;
        }

        .category span {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        /* Years */
        .years {
            margin-top: 10px;
        }

        .year {
            background-color: #ccc;
            padding: 5px 10px;
            margin-top: 5px;
            display: inline-block;
            border-radius: 5px;
        }

        /* Footer buttons */
        .footer-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }

        .footer-buttons a {
            text-align: center;
            padding: 20px;
            background-color: #ccc;
            width: 48%;
            text-decoration: none;
            color: black;
            font-size: 18px;
            border-radius: 5px;
        }

        .footer-buttons a:hover {
            background-color: #aaa;
        }

    </style>
</head>
<body>

    <!-- Navigation bar (from menu.php) -->
    <?php require '../views/templates/menu.php'; ?>

    <!-- Main content -->
    <div class="content">
        <div class="category-row">
            <div class="category">
                Software Developer
                <span class="years">
                    <div class="year">2021</div>
                    <div class="year">2022</div>
                    <div class="year">2023</div>
                    <div class="year">2024</div>
                </span>
            </div>
            <div class="category">
                Allround Medewerker IT Systems and Devices
                <span class="years">
                    <div class="year">2021</div>
                    <div class="year">2022</div>
                    <div class="year">2023</div>
                    <div class="year">2024</div>
                </span>
            </div>
            <div class="category">
                Expert IT Systems and Devices
                <span class="years">
                    <div class="year">2021</div>
                    <div class="year">2022</div>
                    <div class="year">2023</div>
                    <div class="year">2024</div>
                </span>
            </div>
            <div class="category">
                Medewerker ICT Support
                <span class="years">
                    <div class="year">2021</div>
                    <div class="year">2022</div>
                    <div class="year">2023</div>
                    <div class="year">2024</div>
                </span>
            </div>
            <div class="category">
                Software Developer (vanaf 1-8-2024)
                <span class="years">
                    <div class="year">2021</div>
                    <div class="year">2022</div>
                    <div class="year">2023</div>
                    <div class="year">2024</div>
                </span>
            </div>
            <div class="category">
                Medewerker ICT (vanaf 1-8-2024)
                <span class="years">
                    <div class="year">2021</div>
                    <div class="year">2022</div>
                    <div class="year">2023</div>
                    <div class="year">2024</div>
                </span>
            </div>
        </div>

        <!-- Footer buttons -->
        <div class="footer-buttons">
            <a href="#">Deadline</a>
            <a href="#">Overzicht Studenten</a>
        </div>
    </div>

    <!-- Footer (from footer.php) -->
    <?php require '../views/templates/footer.php'; ?>
    
</body>
</html>
