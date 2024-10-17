<?php
include 'config.php';  // Include the database configuration file

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
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container { margin-top: 30px; }
        .student-info { cursor: pointer; }
        .hidden-row { display: none; }
    </style>
    <script>
        // Function to toggle the visibility of the results row
        function toggleRow(id) {
            var row = document.getElementById('details-' + id);
            if (row.style.display === 'none' || row.style.display === '') {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <?php require '../views/templates/menu.php'; ?>
    <?php require '../views/templates/head.php'; ?>
    <link rel="stylesheet" href="styles.css">
    <div class="container">
        <div class="search-student">
            <form action="zoek_student.php" method="GET">
                <input type="text" name="student" placeholder="Zoek student..." required>
                <button type="submit">Zoek</button>
            </form>
        </div>
    <div class="container">
        <h1 class="text-center">Mentor Dashboard</h1>

        <!-- Table with student status -->
        <table class="table table-bordered table-hover status-table">
            <thead class="thead-light">
                <tr>
                    <th>NAME</th>
                    <th>COURSE</th>
                    <th>CLASS</th>
                    <th>RESULT</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <!-- Main Row: Clickable to toggle details -->
                        <tr class="student-info" onclick="toggleRow(<?php echo $row['id']; ?>)">
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['course']; ?></td>
                            <td><?php echo $row['class']; ?></td>
                            <td class="<?php echo ($row['result'] == 'pass') ? 'text-success' : 'text-danger'; ?>">
                                <?php echo ($row['result'] == 'pass') ? 'Passed' : 'Failed'; ?>
                            </td>
                            <td>
                                <form action="send_reminder.php" method="POST">
                                    <input type="hidden" name="student_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-warning btn-sm">Send Reminder</button>
                                </form>
                            </td>
                        </tr>
                        <!-- Hidden Row: Expanded details (Initially hidden) -->
                        <tr id="details-<?php echo $row['id']; ?>" class="hidden-row">
                            <td colspan="5">
                                <div class="p-3 bg-light">
                                    <p><strong>Keuzedeel:</strong> <?php echo $row['keuzedeel'] ?? 'Not Chosen'; ?></p>
                                    <p><strong>Result:</strong> <?php echo ($row['result'] == 'pass') ? 'Passed' : 'Failed'; ?></p>
                                </div>
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>
