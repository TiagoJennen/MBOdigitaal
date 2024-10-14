<?php
session_start(); // Start the session

$host = "127.0.0.1";
$dbName = "mbodigital";
$user = "mbogodigitalUser";
$password = "Vrieskist@247";

try {
    // Establish the database connection
    $dsn = "mysql:host=$host;dbname=$dbName;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Handle the login process
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
        $email = $_POST['email'];
        $secret = $_POST['secret'];

        // Fetch user from database
        $stmt = $pdo->prepare("SELECT id, firstName, prefix, lastName, secret, educationId FROM user WHERE email = ? AND enabled = 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $user['secret'] === $secret) {
            // Store user details in the session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['firstName'] = $user['firstName'];
            $_SESSION['prefix'] = $user['prefix'];
            $_SESSION['lastName'] = $user['lastName'];
            $_SESSION['educationId'] = $user['educationId'];

            // Redirect to student page
            header("Location: /project/student.php");
            exit();
        } else {
            $message = "Invalid email or password.";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/views/templates/head.php' ?>
</head>

<body class="bg-stone-950">
    <div id="loginModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-center border-b pb-2">
                <h3 class="text-xl font-semibold">Login</h3>
                <button class="text-gray-500 hover:text-gray-700" onclick="toggleModal('loginModal')">&times;</button>
            </div>

            <div class="m-2 font-bold text-red-400">
                <?php if (isset($message)) { echo $message; } ?>
            </div>

            <div class="mt-4">
                <form method="POST" action="">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Emailadres</label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" name="email" type="email" placeholder="Emailadres" required>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="secret">Wachtwoord</label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="secret" name="secret" type="password" placeholder="******************" required>
                    </div>
                    <div class="flex items-center justify-between">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="login">
                            Sign In
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php require $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/topbar.php' ?>

    <script>
        function toggleModal(modalID) {
            document.getElementById(modalID).classList.toggle('hidden');
        }

        document.addEventListener("DOMContentLoaded", function () {
            toggleModal('loginModal');
        });
    </script>
</body>
</html>
