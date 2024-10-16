<?php
session_start(); // Start the session at the top
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
        // Fetch student data
        $stmt = $pdo->prepare("
            SELECT u.firstName, u.prefix, u.lastName, e.name as education
            FROM user u
            JOIN education e ON u.educationId = e.id
            WHERE u.id = ?
        ");
        $stmt->execute([$_SESSION['user_id']]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if student data was fetched
        if (!$student) {
            echo "No student data found for the logged-in user.";
            exit();
        }

        // Fetch all keuzedelen
        $stmt = $pdo->prepare("SELECT id, code, title FROM keuzedeel ORDER BY title ASC");
        $stmt->execute();
        $keuzedelen = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Fetch selected keuzedelen for the user
        $stmt = $pdo->prepare("SELECT keuzedeel_id FROM user_keuzedeel WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $selectedKeuzedelen = $stmt->fetchAll(PDO::FETCH_COLUMN); // Get an array of selected IDs

        // Check if the user has confirmed their keuzedeel selection
        $stmt = $pdo->prepare("SELECT confirmed FROM user_keuzedeel WHERE user_id = ? LIMIT 1");
        $stmt->execute([$_SESSION['user_id']]);
        $keuzedeelConfirmed = $stmt->fetchColumn() == 1; // Check if confirmed column is 1

    } else {
        $student = null; // No student data if not logged in
        $keuzedelen = []; // No keuzedelen if not logged in
        $selectedKeuzedelen = []; // No selected keuzedelen if not logged in
        $keuzedeelConfirmed = false; // If not logged in, no confirmation
    }
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$keuzedeelConfirmed) {
    $selectedKeuzedelen = $_POST['keuzedeel'] ?? [];

    // Validate the number of selected keuzedelen
    if (count($selectedKeuzedelen) > 3) {
        echo "<script>alert('Je kunt maximaal 3 keuzedelen selecteren.');</script>";
    } else {
        // Clear previous selections for the user
        if (isset($_SESSION['user_id'])) {
            $stmt = $pdo->prepare("DELETE FROM user_keuzedeel WHERE user_id = ?");
            $stmt->execute([$_SESSION['user_id']]);
        }

        // Insert new selections into the user_keuzedeel table
        foreach ($selectedKeuzedelen as $keuzedeelId) {
            $stmt = $pdo->prepare("INSERT INTO user_keuzedeel (user_id, keuzedeel_id, confirmed) VALUES (?, ?, 1)");
            $stmt->execute([$_SESSION['user_id'], $keuzedeelId]);
        }

        // Save selected keuzedelen in session for UI feedback
        $_SESSION['selected_keuzedelen'] = $selectedKeuzedelen;

        // Redirect to prevent resubmission
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
}

// Initialize selected keuzedelen from session or fetch from DB if logged in
$selectedKeuzedelen = $_SESSION['selected_keuzedelen'] ?? $selectedKeuzedelen;

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
            const selectedCheckboxes = document.querySelectorAll('input[type="checkbox"]:checked');

            // Allow only 3 keuzedelen to be selected
            if (selectedCheckboxes.length > 3) {
                alert("Je kunt maximaal 3 keuzedelen selecteren.");
                checkbox.checked = false; // Uncheck if over the limit
                return;
            }

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

        // Confirmation dialog before form submission
        function confirmSelection(event) {
            if (confirm("Weet je zeker dat je deze keuzedelen wilt opslaan? Je kunt deze keuze later niet meer wijzigen.")) {
                return true; // Proceed with form submission
            } else {
                event.preventDefault(); // Cancel submission
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
            <?php
            if (isset($_SESSION['user_id'])) {
                // Fetch all exams for the user
                $stmt = $pdo->prepare("
                    SELECT exam_name, exam_score
                    FROM exam
                    WHERE user_id = ?
                    ORDER BY id DESC
                ");
                $stmt->execute([$_SESSION['user_id']]);
                $exams = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($exams) {
                    // Loop through each exam and display the name and score
                    foreach ($exams as $exam) {
                        echo "<p>" . htmlspecialchars($exam['exam_name']) . "</p>";
                        echo "<div class='exam-score'>" . htmlspecialchars($exam['exam_score']) . "</div>";
                    }
                } else {
                    // Display a message if no exam is found
                    echo "<p>Geen examen gevonden. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>";
                }
            } else {
                // Display a message if the user is not logged in
                echo "<p>Je bent niet ingelogd.</p>";
            }
            ?>
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
            <p>Student: <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo htmlspecialchars($student['firstName'] . ' ' . ($student['prefix'] ?? '') . ' ' . $student['lastName']); ?></strong></p>
            <p>Opleiding: <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo htmlspecialchars($student['education']); ?></strong></p>
            <p>Minimaal aantal SBU: <strong>720</strong></p>

            <h2>Selecteer keuzedelen</h2>
            <form method="post" action="" onsubmit="confirmSelection(event)">
                <div class="course-list">
                    <?php
                    if (!empty($keuzedelen)) {
                        foreach ($keuzedelen as $keuzedeel) {
                            $checked = in_array($keuzedeel['id'], $selectedKeuzedelen) ? 'checked' : '';
                            $disabled = $keuzedeelConfirmed ? 'disabled' : ''; // Disable if confirmed
                            echo "<p><label><input type='checkbox' name='keuzedeel[]' value='" . htmlspecialchars($keuzedeel['id']) . "' $checked $disabled onclick='moveToChosen(this)'>";
                            echo "" . htmlspecialchars($keuzedeel['code']) . " " . htmlspecialchars($keuzedeel['title']) . " </label></p>";
                        }
                    } else {
                        echo "<p>Geen keuzedelen beschikbaar.</p>";
                    }
                    ?>
                </div>
                <input type="submit" value="Opslaan" class="save" <?php if ($keuzedeelConfirmed) echo 'disabled'; ?>>
            </form>
            <form action="logout.php" method="post">
                <input type="submit" value="Uitloggen" class="logout-btn">
            </form>
        </div>
        <?php else: ?>
        <p>Je bent niet ingelogd. <a href="/views/admin/auth/login2.php">Log in</a>.</p>
    <?php endif; ?>
</div>
</body>
</html>
