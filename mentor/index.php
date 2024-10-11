<?php
include 'config.php';

// Fetch student data from the database
$sql = "SELECT * FROM students";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentor Dashboard</title>
    <?php require '../views/templates/head.php' ?>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container { margin-top: 30px; }
        .student-info img { max-width: 150px; margin-bottom: 15px; }
        .status-table { margin-top: 30px; }
        .status-table th, .status-table td { text-align: center; }
        .btn { margin: 10px 0; }
        .table .green { color: green; }
        .table .red { color: red; }
    </style>
</head>
<body>
    <?php require '../views/templates/menu.php' ?>
    <div class="container">
        <!-- Header -->
        <div class="header text-center mb-4">
            <h1>Mentor Dashboard</h1>
        </div>

        <!-- Student Information -->
        <div class="row">
            <div class="col-md-3">
                <div class="student-info text-center">
                    <img src="student-photo.jpg" class="rounded-circle img-fluid" alt="Student Photo">
                    <p><strong>NAAM:</strong> john pork</p>
                    <p><strong>OPLEIDING:</strong> Software developer</p>
                    <p><strong>KLAS:</strong>T1l.S42SenD </p>
                </div>
            </div>

            <!-- Dynamic Dashboard Information -->
            <div class="col-md-9">
                <h2 class="mb-3">John pork</h2>
                <p class="text-danger">Student heeft nog geen keuzedeel gekozen.</p>

                <!-- Table with student status -->
                <table class="table table-bordered table-hover status-table">
                    <thead class="thead-light">
                        <tr>
                            <th>STATUS</th>
                            <th>KLAS</th>
                            <th>Keuzedeel</th>
                            <th>RESULTS</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['class']; ?></td>
                                    <td class="<?php echo ($row['keuzedeel']) ? 'green' : 'red'; ?>">
                                        <?php echo ($row['keuzedeel']) ? $row['keuzedeel'] : 'Not Chosen'; ?>
                                    </td>
                                    <td class="<?php echo ($row['result'] == 'pass') ? 'green' : 'red'; ?>">
                                        <?php echo ($row['result'] == 'pass') ? 'Passed' : 'Failed'; ?>
                                    </td>
                                    <td>
                                        <form action="send_reminder.php" method="GET">
                                            <input type="hidden" name="student_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" class="btn btn-warning btn-sm">
                                                <i class="fas fa-bell"></i> Send Reminder
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No students found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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
