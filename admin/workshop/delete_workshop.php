<?php
include 'db.php'; // Include your database connection file

// Handle closing a workshop if a request is received
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['close'])) {
    $workshopId = $_POST['workshop_id'];

    // Check if the workshop ID is set and is a valid integer
    if (!empty($workshopId) && is_numeric($workshopId)) {
        try {
            // Update the workshop status to 'closed'
            $stmt = $pdo->prepare("UPDATE workshops SET status = 'closed' WHERE id = ?");
            $stmt->execute([$workshopId]);

            // Check if any row was actually updated
            if ($stmt->rowCount() > 0) {
                echo "<script>alert('Workshop closed successfully.');</script>";
            } else {
                echo "<script>alert('Error: Workshop not found or could not be closed.');</script>";
            }
        } catch (PDOException $e) {
            echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('Invalid Workshop ID.');</script>";
    }
}

// Handle deleting a workshop if a request is received
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $workshopId = $_POST['workshop_id'];

    // Check if the workshop ID is set and is a valid integer
    if (!empty($workshopId) && is_numeric($workshopId)) {
        try {
            // Delete the workshop from the database
            $stmt = $pdo->prepare("DELETE FROM workshops WHERE id = ?");
            $stmt->execute([$workshopId]);

            // Check if any row was actually deleted
            if ($stmt->rowCount() > 0) {
                echo "<script>alert('Workshop deleted successfully.');</script>";
            } else {
                echo "<script>alert('Error: Workshop not found or could not be deleted.');</script>";
            }
        } catch (PDOException $e) {
            echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('Invalid Workshop ID.');</script>";
    }
}

// Fetch all workshops for display
$workshops = $pdo->query("SELECT * FROM workshops")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Workshops</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script>
        function confirmDelete(id) {
            // Ask for confirmation before deleting
            if (confirm("Are you sure you want to delete this workshop? This action cannot be undone.")) {
                // Submit the form to delete the workshop
                document.getElementById('deleteForm' + id).submit();
            }
        }

        function confirmClose(id) {
            // Ask for confirmation before closing the workshop
            if (confirm("Are you sure you want to close this workshop? This action cannot be undone.")) {
                // Submit the form to close the workshop
                document.getElementById('closeForm' + id).submit();
            }
        }
    </script>
</head>

<body>
    <div class="container mt-5">
        <h2>Manage Workshops</h2>
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
                <?php foreach ($workshops as $workshop): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($workshop['title']); ?></td>
                        <td><?php echo htmlspecialchars($workshop['description']); ?></td>
                        <td><?php echo htmlspecialchars($workshop['status']); ?></td>
                        <td>
                            <!-- Close Button -->
                            <?php if ($workshop['status'] !== 'closed'): ?>
                                <form id="closeForm<?php echo $workshop['id']; ?>" action="" method="post" style="display:inline;">
                                    <input type="hidden" name="workshop_id" value="<?php echo $workshop['id']; ?>">
                                    <input type="hidden" name="close" value="true">
                                    <button type="button" class="btn btn-warning" onclick="confirmClose(<?php echo $workshop['id']; ?>)">Close</button>
                                </form>
                            <?php else: ?>
                                <button class="btn btn-secondary" disabled>Closed</button>
                            <?php endif; ?>

                            <!-- Delete Button -->
                            <form id="deleteForm<?php echo $workshop['id']; ?>" action="" method="post" style="display:inline;">
                                <input type="hidden" name="workshop_id" value="<?php echo $workshop['id']; ?>">
                                <input type="hidden" name="delete" value="true">
                                <button type="button" class="btn btn-danger" onclick="confirmDelete(<?php echo $workshop['id']; ?>)">Delete</button>
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
