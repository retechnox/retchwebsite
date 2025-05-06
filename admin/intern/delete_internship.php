<?php
include 'db.php'; // Include your database connection file

// Handle closing an internship if a request is received
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['close'])) {
    $internshipId = $_POST['internship_id'];

    // Check if the internship ID is set and is a valid integer
    if (!empty($internshipId) && is_numeric($internshipId)) {
        try {
            // Update the internship status to 'closed'
            $stmt = $pdo->prepare("UPDATE internships SET status = 'closed' WHERE id = ?");
            $stmt->execute([$internshipId]);

            // Check if any row was actually updated
            if ($stmt->rowCount() > 0) {
                echo "<script>alert('Internship closed successfully. No more registrations will be accepted.');</script>";
            } else {
                echo "<script>alert('Error: Internship not found or could not be closed.');</script>";
            }
        } catch (PDOException $e) {
            echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('Invalid Internship ID.');</script>";
    }
}

// Handle deleting an internship if a request is received
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $internshipId = $_POST['internship_id'];

    // Check if the internship ID is set and is a valid integer
    if (!empty($internshipId) && is_numeric($internshipId)) {
        try {
            // Delete the internship from the database
            $stmt = $pdo->prepare("DELETE FROM internships WHERE id = ?");
            $stmt->execute([$internshipId]);

            // Check if any row was actually deleted
            if ($stmt->rowCount() > 0) {
                echo "<script>alert('Internship deleted successfully.');</script>";
            } else {
                echo "<script>alert('Error: Internship not found or could not be deleted.');</script>";
            }
        } catch (PDOException $e) {
            echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('Invalid Internship ID.');</script>";
    }
}

// Fetch all internships for display
$internships = $pdo->query("SELECT * FROM internships")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Internships</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script>
        function confirmClose(id) {
            // Ask for confirmation before closing
            if (confirm("Are you sure you want to close this internship? No more registrations will be accepted.")) {
                // Submit the form to close the internship
                document.getElementById('closeForm' + id).submit();
            }
        }

        function confirmDelete(id) {
            // Ask for confirmation before deleting
            if (confirm("Are you sure you want to delete this internship? This action cannot be undone.")) {
                // Submit the form to delete the internship
                document.getElementById('deleteForm' + id).submit();
            }
        }
    </script>
</head>

<body>
    <div class="container mt-5">
        <h2>Manage Internships</h2>
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
                <?php foreach ($internships as $internship): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($internship['title']); ?></td>
                        <td><?php echo htmlspecialchars($internship['description']); ?></td>
                        <td><?php echo htmlspecialchars($internship['status']); ?></td>
                        <td>
                            <!-- Close Button -->
                            <?php if ($internship['status'] == 'open'): ?>
                                <form id="closeForm<?php echo $internship['id']; ?>" action="" method="post" style="display:inline;">
                                    <input type="hidden" name="internship_id" value="<?php echo $internship['id']; ?>">
                                    <input type="hidden" name="close" value="true">
                                    <button type="button" class="btn btn-warning" onclick="confirmClose(<?php echo $internship['id']; ?>)">Close</button>
                                </form>
                            <?php else: ?>
                                <span class="badge badge-secondary">Closed</span>
                            <?php endif; ?>
                            
                            <!-- Delete Button -->
                            <form id="deleteForm<?php echo $internship['id']; ?>" action="" method="post" style="display:inline;">
                                <input type="hidden" name="internship_id" value="<?php echo $internship['id']; ?>">
                                <input type="hidden" name="delete" value="true">
                                <button type="button" class="btn btn-danger" onclick="confirmDelete(<?php echo $internship['id']; ?>)">Delete</button>
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
