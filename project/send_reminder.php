<?php
include 'config.php';

// Get student ID from URL parameter
$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : 0;

// Fetch student data by ID
$sql = "SELECT * FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reminder Sent</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container { margin-top: 30px; }
        .student-info img { max-width: 150px; margin-bottom: 15px; }
        .dashboard-info h2 { margin-top: 30px; }
        .btn { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header text-center mb-4">
            <h1>Mentor Dashboard</h1>
        </div>

        <div class="row">
            <!-- Student Information -->
            <div class="col-md-3">
                <div class="student-info text-center">
                    <img src="student-photo.jpg" class="rounded-circle img-fluid" alt="Student Photo">
                    <p><strong>NAAM:</strong> <?php echo $student['name']; ?></p>
                    <p><strong>OPLEIDING:</strong> <?php echo $student['course']; ?></p>
                    <p><strong>KLAS:</strong> <?php echo $student['class']; ?></p>
                </div>
            </div>

            <!-- Chosen Module and Results -->
            <div class="col-md-9">
                <div class="dashboard-info">
                    <h2>Keuzedeel Status</h2>
                    <p><strong>Gekozen keuzedeel:</strong> 
                        <?php echo $student['keuzedeel'] ? $student['keuzedeel'] : '<span class="text-danger">Not Chosen</span>'; ?>
                    </p>
                    <p><strong>Resultaten:</strong> 
                        <span class="<?php echo ($student['result'] == 'pass') ? 'text-success' : 'text-danger'; ?>">
                            <?php echo ($student['result'] == 'pass') ? 'Passed' : 'Failed'; ?>
                        </span>
                    </p>
                </div>

                <!-- Message Form -->
                <div class="message-box">
                    <h3>New Message</h3>
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="to">To:</label>
                            <input type="text" name="to" id="to" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject:</label>
                            <input type="text" name="subject" id="subject" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message:</label>
                            <textarea name="message" id="message" rows="5" class="form-control" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Send</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer text-center mt-4">
            <p>© 2024 Mentor Dashboard</p>
        </footer>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>
