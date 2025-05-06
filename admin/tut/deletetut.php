<?php
include 'db.php'; // Include your database connection file

// Handle closing a tuition if a request is received
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['close'])) {
    $tuitionId = $_POST['tuition_id'];

    // Check if the tuition ID is set and is a valid integer
    if (!empty($tuitionId) && is_numeric($tuitionId)) {
        try {
            // Update the tuition status to 'closed'
            $stmt = $pdo->prepare("UPDATE tuitions SET status = 'closed' WHERE id = ?");
            $stmt->execute([$tuitionId]);

            // Check if any row was actually updated
            if ($stmt->rowCount() > 0) {
                echo "<script>alert('Tuition closed successfully.');</script>";
            } else {
                echo "<script>alert('Error: Tuition not found or could not be closed.');</script>";
            }
        } catch (PDOException $e) {
            echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('Invalid Tuition ID.');</script>";
    }
}

// Handle deleting a tuition if a request is received
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $tuitionId = $_POST['tuition_id'];

    // Check if the tuition ID is set and is a valid integer
    if (!empty($tuitionId) && is_numeric($tuitionId)) {
        try {
            // Delete the tuition from the database
            $stmt = $pdo->prepare("DELETE FROM tuitions WHERE id = ?");
            $stmt->execute([$tuitionId]);

            // Check if any row was actually deleted
            if ($stmt->rowCount() > 0) {
                echo "<script>alert('Tuition deleted successfully.');</script>";
            } else {
                echo "<script>alert('Error: Tuition not found or could not be deleted.');</script>";
            }
        } catch (PDOException $e) {
            echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('Invalid Tuition ID.');</script>";
    }
}

// Fetch all tuitions for display
$tuitions = $pdo->query("SELECT * FROM tuitions")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Tuitions</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script>
        function confirmDelete(id) {
            // Ask for confirmation before deleting
            if (confirm("Are you sure you want to delete this tuition? This action cannot be undone.")) {
                // Submit the form to delete the tuition
                document.getElementById('deleteForm' + id).submit();
            }
        }

        function confirmClose(id) {
            // Ask for confirmation before closing the tuition
            if (confirm("Are you sure you want to close this tuition? This action cannot be undone.")) {
                // Submit the form to close the tuition
                document.getElementById('closeForm' + id).submit();
            }
        }
    </script>
</head>

<body>
    <div class="container mt-5">
        <h2>Manage Tuitions</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tuitions as $tuition): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($tuition['title']); ?></td>
                        <td><?php echo htmlspecialchars($tuition['description']); ?></td>
                        <td><?php echo htmlspecialchars($tuition['status']); ?></td>
                        <td>
                            <!-- Close Button -->
                            <?php if ($tuition['status'] !== 'closed'): ?>
                                <form id="closeForm<?php echo $tuition['id']; ?>" action="" method="post" style="display:inline;">
                                    <input type="hidden" name="tuition_id" value="<?php echo $tuition['id']; ?>">
                                    <input type="hidden" name="close" value="true">
                                    <button type="button" class="btn btn-warning" onclick="confirmClose(<?php echo $tuition['id']; ?>)">Close</button>
                                </form>
                            <?php else: ?>
                                <button class="btn btn-secondary" disabled>Closed</button>
                            <?php endif; ?>

                            <!-- Delete Button -->
                            <form id="deleteForm<?php echo $tuition['id']; ?>" action="" method="post" style="display:inline;">
                                <input type="hidden" name="tuition_id" value="<?php echo $tuition['id']; ?>">
                                <input type="hidden" name="delete" value="true">
                                <button type="button" class="btn btn-danger" onclick="confirmDelete(<?php echo $tuition['id']; ?>)">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
