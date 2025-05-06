<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'])) {
        $stmt = $pdo->prepare('DELETE FROM updates WHERE id = ?');
        $stmt->execute([$_POST['id']]);
    } elseif (isset($_POST['add'])) {
        $stmt = $pdo->prepare('INSERT INTO updates (title, content) VALUES (?, ?)');
        $stmt->execute([$_POST['title'], $_POST['content']]);
    }
}

$stmt = $pdo->query('SELECT * FROM updates ORDER BY created_at DESC');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - KTU Magic</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
 
    <div class="container mt-5">
    <br><br>
    <a href="admin.php">back</a><br><br>
        <h2>Admin Updates</h2>
        <form method="post" class="mb-3">
            <div class="form-group">
                <label for="title">updates title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="content">Content (HTML allowed)</label>
                <textarea class="form-control" id="content" name="content" required></textarea>
                <small class="form-text text-muted">You can include HTML tags like <code>&lt;a&gt;</code> for
                    links.</small>
            </div>
            <button type="submit" name="add" class="btn btn-success">Add Update</button>
        </form>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Date Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $stmt->fetch()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['content']); ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td>
                            <form method="post" style="display:inline-block;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>