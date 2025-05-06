<?php
include 'db.php';

// Handle Add Update Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['update'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Define upload directory
    $uploadDir = 'uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $imageName;
        
        // Move the uploaded image to the server
        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            // Insert data into the database
            $stmt = $pdo->prepare("INSERT INTO latestupdates (image, title, description) VALUES (?, ?, ?)");
            if ($stmt->execute([$imagePath, $title, $description])) {
                echo "Update added successfully!";
            } else {
                echo "Failed to add update.";
            }
        } else {
            echo "Failed to upload image.";
        }
    } else {
        // Handle cases where no image is uploaded
        $stmt = $pdo->prepare("INSERT INTO latestupdates (title, description) VALUES (?, ?)");
        if ($stmt->execute([$title, $description])) {
            echo "Update added successfully!";
        } else {
            echo "Failed to add update.";
        }
    }
}

// Handle Update Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = 'uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $imageName = basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $imageName;
        
        // Move the uploaded image to the server
        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            $stmt = $pdo->prepare("UPDATE latestupdates SET image = ?, title = ?, description = ? WHERE id = ?");
            $stmt->execute([$imagePath, $title, $description, $id]);
        } else {
            echo "Failed to upload image.";
            exit;
        }
    } else {
        $stmt = $pdo->prepare("UPDATE latestupdates SET title = ?, description = ? WHERE id = ?");
        $stmt->execute([$title, $description, $id]);
    }

    echo "Update edited successfully!";
}

// Fetch all updates
$updates = $pdo->query("SELECT * FROM latestupdates")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Updates</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <br><br>
 
    <div class="container mt-5">
    <a href="admin.php">Back</a>
        <h2>Manage Latest Updates</h2>
        
        <!-- Form to Add New Update -->
        <form action="admin_latest.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control-file" id="image" name="image" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Update</button>
        </form>

        <hr>

        <!-- List of Existing Updates -->
        <h3>Existing Updates</h3>
        <?php foreach ($updates as $update): ?>
        <div class="card mb-3">
            <img src="<?php echo htmlspecialchars($update['image']); ?>" class="card-img-top" alt="Image">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($update['title']); ?></h5>
                <p class="card-text"><?php echo htmlspecialchars($update['description']); ?></p>
                <button class="btn btn-info" data-toggle="modal" data-target="#editModal<?php echo $update['id']; ?>">Edit</button>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal<?php echo $update['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Update</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="admin_latest.php" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <input type="hidden" name="id" value="<?php echo $update['id']; ?>">
                            <div class="form-group">
                                <label for="editTitle">Title</label>
                                <input type="text" class="form-control" id="editTitle" name="title" value="<?php echo htmlspecialchars($update['title']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="editDescription">Description</label>
                                <textarea class="form-control" id="editDescription" name="description" rows="3" required><?php echo htmlspecialchars($update['description']); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="editImage">Image (Optional)</label>
                                <input type="file" class="form-control-file" id="editImage" name="image">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="update" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
<?php
include 'db.php';

// Handle Add Update Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['update'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Define upload directory
    $uploadDir = 'uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $imageName;
        
        // Move the uploaded image to the server
        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            // Insert data into the database
            $stmt = $pdo->prepare("INSERT INTO latestupdates (image, title, description) VALUES (?, ?, ?)");
            if ($stmt->execute([$imagePath, $title, $description])) {
                echo "Update added successfully!";
            } else {
                echo "Failed to add update.";
            }
        } else {
            echo "Failed to upload image.";
        }
    } else {
        // Handle cases where no image is uploaded
        $stmt = $pdo->prepare("INSERT INTO latestupdates (title, description) VALUES (?, ?)");
        if ($stmt->execute([$title, $description])) {
            echo "Update added successfully!";
        } else {
            echo "Failed to add update.";
        }
    }
}

// Handle Update Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = 'uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $imageName = basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $imageName;
        
        // Move the uploaded image to the server
        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            $stmt = $pdo->prepare("UPDATE latestupdates SET image = ?, title = ?, description = ? WHERE id = ?");
            $stmt->execute([$imagePath, $title, $description, $id]);
        } else {
            echo "Failed to upload image.";
            exit;
        }
    } else {
        $stmt = $pdo->prepare("UPDATE latestupdates SET title = ?, description = ? WHERE id = ?");
        $stmt->execute([$title, $description, $id]);
    }

    echo "Update edited successfully!";
}

// Fetch all updates
$updates = $pdo->query("SELECT * FROM latestupdates")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Updates</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <br><br>
 
    <div class="container mt-5">
    <a href="admin.php">Back</a>
        <h2>Manage Latest Updates</h2>
        
        <!-- Form to Add New Update -->
        <form action="admin_latest.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control-file" id="image" name="image" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Update</button>
        </form>

        <hr>

        <!-- List of Existing Updates -->
        <h3>Existing Updates</h3>
        <?php foreach ($updates as $update): ?>
        <div class="card mb-3">
            <img src="<?php echo htmlspecialchars($update['image']); ?>" class="card-img-top" alt="Image">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($update['title']); ?></h5>
                <p class="card-text"><?php echo htmlspecialchars($update['description']); ?></p>
                <button class="btn btn-info" data-toggle="modal" data-target="#editModal<?php echo $update['id']; ?>">Edit</button>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal<?php echo $update['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Update</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="admin_latest.php" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <input type="hidden" name="id" value="<?php echo $update['id']; ?>">
                            <div class="form-group">
                                <label for="editTitle">Title</label>
                                <input type="text" class="form-control" id="editTitle" name="title" value="<?php echo htmlspecialchars($update['title']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="editDescription">Description</label>
                                <textarea class="form-control" id="editDescription" name="description" rows="3" required><?php echo htmlspecialchars($update['description']); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="editImage">Image (Optional)</label>
                                <input type="file" class="form-control-file" id="editImage" name="image">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="update" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
<?php
include 'db.php';

// Handle Add Update Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['update'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Define upload directory
    $uploadDir = 'uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $imageName;
        
        // Move the uploaded image to the server
        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            // Insert data into the database
            $stmt = $pdo->prepare("INSERT INTO latestupdates (image, title, description) VALUES (?, ?, ?)");
            if ($stmt->execute([$imagePath, $title, $description])) {
                echo "Update added successfully!";
            } else {
                echo "Failed to add update.";
            }
        } else {
            echo "Failed to upload image.";
        }
    } else {
        // Handle cases where no image is uploaded
        $stmt = $pdo->prepare("INSERT INTO latestupdates (title, description) VALUES (?, ?)");
        if ($stmt->execute([$title, $description])) {
            echo "Update added successfully!";
        } else {
            echo "Failed to add update.";
        }
    }
}

// Handle Update Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = 'uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $imageName = basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $imageName;
        
        // Move the uploaded image to the server
        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            $stmt = $pdo->prepare("UPDATE latestupdates SET image = ?, title = ?, description = ? WHERE id = ?");
            $stmt->execute([$imagePath, $title, $description, $id]);
        } else {
            echo "Failed to upload image.";
            exit;
        }
    } else {
        $stmt = $pdo->prepare("UPDATE latestupdates SET title = ?, description = ? WHERE id = ?");
        $stmt->execute([$title, $description, $id]);
    }

    echo "Update edited successfully!";
}

// Fetch all updates
$updates = $pdo->query("SELECT * FROM latestupdates")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Updates</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <br><br>
 
    <div class="container mt-5">
    <a href="admin.php">Back</a>
        <h2>Manage Latest Updates</h2>
        
        <!-- Form to Add New Update -->
        <form action="admin_latest.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control-file" id="image" name="image" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Update</button>
        </form>

        <hr>

        <!-- List of Existing Updates -->
        <h3>Existing Updates</h3>
        <?php foreach ($updates as $update): ?>
        <div class="card mb-3">
            <img src="<?php echo htmlspecialchars($update['image']); ?>" class="card-img-top" alt="Image">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($update['title']); ?></h5>
                <p class="card-text"><?php echo htmlspecialchars($update['description']); ?></p>
                <button class="btn btn-info" data-toggle="modal" data-target="#editModal<?php echo $update['id']; ?>">Edit</button>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal<?php echo $update['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Update</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="admin_latest.php" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <input type="hidden" name="id" value="<?php echo $update['id']; ?>">
                            <div class="form-group">
                                <label for="editTitle">Title</label>
                                <input type="text" class="form-control" id="editTitle" name="title" value="<?php echo htmlspecialchars($update['title']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="editDescription">Description</label>
                                <textarea class="form-control" id="editDescription" name="description" rows="3" required><?php echo htmlspecialchars($update['description']); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="editImage">Image (Optional)</label>
                                <input type="file" class="form-control-file" id="editImage" name="image">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="update" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
<?php
include 'db.php';

// Handle Add Update Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['update'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Define upload directory
    $uploadDir = 'uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $imageName;
        
        // Move the uploaded image to the server
        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            // Insert data into the database
            $stmt = $pdo->prepare("INSERT INTO latestupdates (image, title, description) VALUES (?, ?, ?)");
            if ($stmt->execute([$imagePath, $title, $description])) {
                echo "Update added successfully!";
            } else {
                echo "Failed to add update.";
            }
        } else {
            echo "Failed to upload image.";
        }
    } else {
        // Handle cases where no image is uploaded
        $stmt = $pdo->prepare("INSERT INTO latestupdates (title, description) VALUES (?, ?)");
        if ($stmt->execute([$title, $description])) {
            echo "Update added successfully!";
        } else {
            echo "Failed to add update.";
        }
    }
}

// Handle Update Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = 'uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $imageName = basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $imageName;
        
        // Move the uploaded image to the server
        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            $stmt = $pdo->prepare("UPDATE latestupdates SET image = ?, title = ?, description = ? WHERE id = ?");
            $stmt->execute([$imagePath, $title, $description, $id]);
        } else {
            echo "Failed to upload image.";
            exit;
        }
    } else {
        $stmt = $pdo->prepare("UPDATE latestupdates SET title = ?, description = ? WHERE id = ?");
        $stmt->execute([$title, $description, $id]);
    }

    echo "Update edited successfully!";
}

// Fetch all updates
$updates = $pdo->query("SELECT * FROM latestupdates")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Updates</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <br><br>
 
    <div class="container mt-5">
    <a href="admin.php">Back</a>
        <h2>Manage Latest Updates</h2>
        
        <!-- Form to Add New Update -->
        <form action="admin_latest.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control-file" id="image" name="image" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Update</button>
        </form>

        <hr>

        <!-- List of Existing Updates -->
        <h3>Existing Updates</h3>
        <?php foreach ($updates as $update): ?>
        <div class="card mb-3">
            <img src="<?php echo htmlspecialchars($update['image']); ?>" class="card-img-top" alt="Image">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($update['title']); ?></h5>
                <p class="card-text"><?php echo htmlspecialchars($update['description']); ?></p>
                <button class="btn btn-info" data-toggle="modal" data-target="#editModal<?php echo $update['id']; ?>">Edit</button>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal<?php echo $update['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Update</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="admin_latest.php" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <input type="hidden" name="id" value="<?php echo $update['id']; ?>">
                            <div class="form-group">
                                <label for="editTitle">Title</label>
                                <input type="text" class="form-control" id="editTitle" name="title" value="<?php echo htmlspecialchars($update['title']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="editDescription">Description</label>
                                <textarea class="form-control" id="editDescription" name="description" rows="3" required><?php echo htmlspecialchars($update['description']); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="editImage">Image (Optional)</label>
                                <input type="file" class="form-control-file" id="editImage" name="image">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="update" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
