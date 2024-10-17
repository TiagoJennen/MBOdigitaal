<?php
include 'config.php';  // Include the database connection

// Get the student ID from the POST request
$student_id = isset($_POST['student_id']) ? intval($_POST['student_id']) : 0;

if ($student_id > 0) {
    // Fetch student details from the database
    $sql = "SELECT * FROM students WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();

    if ($student) {
        // Here you can implement the logic for sending an email or SMS reminder
        // For now, we'll just display a message confirming the reminder

        echo "<h2>Reminder Sent!</h2>";
        echo "<p>A reminder has been sent to <strong>{$student['name']}</strong> for the course <strong>{$student['course']}</strong>.</p>";
        echo "<p>Class: <strong>{$student['class']}</strong></p>";
        echo "<p>Keuzedeel: <strong>{$student['keuzedeel']}</strong></p>";
        echo "<p>Result: <strong>{$student['result']}</strong></p>";
    } else {
        echo "<p>Student not found.</p>";
    }
} else {
    echo "<p>Invalid student ID.</p>";
}

$conn->close();  // Close the database connection
?>
