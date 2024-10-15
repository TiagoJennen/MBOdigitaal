<?php
session_start(); // Start the session at the top

$host = "127.0.0.1";
$dbName = "mbodigital";
$user = "mbogodigitalUser";
$password = "Vrieskist@247";

try {
    // Establish the database connection
    $dsn = "mysql:host=$host;dbname=$dbName;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $password);

    // Set error mode to exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch user education information only if logged in
    if (isset($_SESSION['user_id'])) {
        $stmt = $pdo->prepare("
            SELECT u.firstName, u.prefix, u.lastName, e.name as education
            FROM user u
            JOIN education e ON u.educationId = e.id
            WHERE u.id = ?
        ");
        $stmt->execute([$_SESSION['user_id']]); // Use the logged-in user ID
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if student data was fetched
        if (!$student) {
            echo "No student data found for the logged-in user.";
            exit();
        }

        // Prepare the SQL query to fetch keuzedeel records
        $stmt = $pdo->prepare("SELECT id, code, title FROM keuzedeel ORDER BY title ASC");
        $stmt->execute();

        // Fetch the keuzedelen data
        $keuzedelen = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $student = null; // No student data if not logged in
        $keuzedelen = []; // No keuzedelen if not logged in
    }
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Store selected keuzedeel IDs in session
    $_SESSION['selected_keuzedelen'] = $_POST['keuzedeel'] ?? [];
}

// Initialize selected keuzedelen from session
$selectedKeuzedelen = $_SESSION['selected_keuzedelen'] ?? [];
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keuzedelen Overzicht</title>
    <?php require '../views/templates/head.php' ?>
    <link rel="stylesheet" href="student.css">
    <script>
        function moveToChosen(checkbox) {
            const chosenContainer = document.getElementById('chosen-keuzedelen');

            if (checkbox.checked) {
                // Create a new list item
                const listItem = document.createElement('p');
                const infoButton = document.createElement('a'); // Create an anchor element for the button
                infoButton.innerText = 'Informatie';
                infoButton.href = 'info.php'; // Link to your page here
                infoButton.className = 'info-btn'; // Apply the button class
                listItem.innerHTML = checkbox.nextSibling.textContent; // Get the text for the selected keuzedeel
                listItem.appendChild(infoButton); // Append the button to the list item
                chosenContainer.appendChild(listItem); // Append the list item to the chosen container
            } else {
                // Remove the item if unchecked
                const items = chosenContainer.getElementsByTagName('p');
                for (let item of items) {
                    if (item.textContent.includes(checkbox.nextSibling.textContent)) {
                        chosenContainer.removeChild(item);
                        break;
                    }
                }
            }
        }

        // Function to load previously selected keuzedelen on page load
        window.onload = function() {
            const selectedKeuzedelen = <?php echo json_encode($selectedKeuzedelen); ?>;
            selectedKeuzedelen.forEach(id => {
                const checkbox = document.querySelector(`input[type='checkbox'][value='${id}']`);
                if (checkbox) {
                    checkbox.checked = true;
                    moveToChosen(checkbox); // Move to chosen
                }
            });
        }
    </script>
</head>
<body>
<?php require '../views/templates/menu.php' ?>
<div class="container">
    <?php if ($student): ?>
        <div class="leftBox">
            <h2>Examen</h2>
            <p>K0023 Digitale vaardigheden gevorderd <br>(240 SBU)</p>
            <div class="exam-score">8</div>
        </div>

        <div class="middleBox">
            <h2>Gekozen keuzedelen</h2>
            <div id="chosen-keuzedelen"></div>
            <div class="deadlinesLine"></div>
            <div class="deadlines">
                <p>Deadline: 25/09/2024</p>
            </div>
        </div>

        <div class="rightBox">
            <h3>Overzicht keuzedelen</h3>
            <p>Student: <strong><?php echo htmlspecialchars($student['firstName'] . ' ' . ($student['prefix'] ?? '') . ' ' . $student['lastName']); ?></strong></p>
            <p>Opleiding: <strong><?php echo htmlspecialchars($student['education']); ?></strong></p>
            <p>Minimaal aantal SBU: <strong>720</strong></p>

            <h2>Selecteer keuzedelen</h2>
            <form method="post" action="">
                <div class="course-list">
                    <?php
                    if (!empty($keuzedelen)) {
                        foreach ($keuzedelen as $keuzedeel) {
                            $checked = in_array($keuzedeel['id'], $selectedKeuzedelen) ? 'checked' : '';
                            echo "<p><label><input type='checkbox' name='keuzedeel[]' value='" . htmlspecialchars($keuzedeel['id']) . "' $checked onclick='moveToChosen(this)'>";
                            echo "" . htmlspecialchars($keuzedeel['code']) . " " . htmlspecialchars($keuzedeel['title']) . " </label></p>";
                        }
                    } else {
                        echo "<p>Geen keuzedelen beschikbaar.</p>";
                    }
                    ?>
                </div>
                <input type="submit" value="Opslaan" class="save">
            </form>
            <!-- Voeg de uitlogknop toe -->
            <form action="logout.php" method="post">
                <input type="submit" value="Uitloggen" class="logout-btn">
            </form>
        </div>
    <?php else: ?>
        <div class="loginBox">
            <h2>Log in om toegang te krijgen</h2>
            <a href="/views/admin/auth/login2.php" class="login-btn">Log In</a>
        </div>
    <?php endif; ?>
</div>

<?php require '../views/templates/footer.php' ?>
</body>
</html>