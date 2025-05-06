<?php
include 'db.php'; // Include your database connection file

// Handle form submission for adding/updating schemes, branches, courses, and links
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'save_links') {
        // Save links for a course
        $course_id = $_POST['course_id'];
        $links = $_POST['links'] ?? [];

        // Encode links as JSON
        $links_json = json_encode($links);

        // Update the links in the database
        $update_query = $pdo->prepare('UPDATE courses SET links = ? WHERE id = ?');
        $update_query->execute([$links_json, $course_id]);

        echo "<div class='alert alert-success'>Links updated successfully!</div>";
    } elseif (isset($_POST['action']) && $_POST['action'] == 'add_scheme') {
        // Add new scheme
        $name = $_POST['scheme_name'];
        $insert_query = $pdo->prepare('INSERT INTO schemes (name) VALUES (?)');
        $insert_query->execute([$name]);

        echo "<div class='alert alert-success'>Scheme added successfully!</div>";
    } elseif (isset($_POST['action']) && $_POST['action'] == 'add_branch') {
        // Add new branch
        $scheme_id = $_POST['scheme_id'];
        $name = $_POST['branch_name'];
        $insert_query = $pdo->prepare('INSERT INTO branches (scheme_id, name) VALUES (?, ?)');
        $insert_query->execute([$scheme_id, $name]);

        echo "<div class='alert alert-success'>Branch added successfully!</div>";
    } elseif (isset($_POST['action']) && $_POST['action'] == 'add_course') {
        // Add new course
        $branch_id = $_POST['branch_id'];
        $scheme_id = $_POST['scheme_id'];
        $name = $_POST['course_name'];
        $links = $_POST['links'] ?? [];

        // Insert the course into the database
        $insert_query = $pdo->prepare('INSERT INTO courses (branch_id, scheme_id, name, links) VALUES (?, ?, ?, ?)');
        $insert_query->execute([$branch_id, $scheme_id, $name, json_encode($links)]);

        echo "<div class='alert alert-success'>Course added successfully!</div>";
    }
}

// Fetch schemes, branches, and courses for display
$schemes = $pdo->query('SELECT * FROM schemes')->fetchAll();
$branches = $pdo->query('SELECT * FROM branches')->fetchAll();
$courses = $pdo->query('SELECT * FROM courses')->fetchAll();

// Handle course selection for updating links
$selected_course = null;
$links = [];
if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];
    $selected_course_query = $pdo->prepare('SELECT * FROM courses WHERE id = ?');
    $selected_course_query->execute([$course_id]);
    $selected_course = $selected_course_query->fetch();
    if ($selected_course) {
        $links_json = $selected_course['links'];
        $links = json_decode($links_json, true) ?? [];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Schemes, Branches, Courses, and Links</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-group, .input-group {
            margin-bottom: 1rem;
        }

        .input-group input {
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Admin Management</h2>

        <!-- Add Scheme -->
        <h3>Add Scheme</h3>
        <form method="POST" action="">
            <input type="hidden" name="action" value="add_scheme">
            <div class="form-group">
                <label for="scheme_name">Scheme Name</label>
                <input type="text" id="scheme_name" name="scheme_name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Scheme</button>
        </form>

        <!-- Add Branch -->
        <h3 class="mt-5">Add Branch</h3>
        <form method="POST" action="">
            <input type="hidden" name="action" value="add_branch">
            <div class="form-group">
                <label for="scheme_id">Select Scheme</label>
                <select id="scheme_id_branch" name="scheme_id" class="form-control" required>
                    <option value="">Select a scheme</option>
                    <?php foreach ($schemes as $scheme): ?>
                        <option value="<?= $scheme['id'] ?>"><?= htmlspecialchars($scheme['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="branch_name">Branch Name</label>
                <input type="text" id="branch_name" name="branch_name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Branch</button>
        </form>

        <!-- Add Course -->
        <h3 class="mt-5">Add Course</h3>
        <form method="POST" action="">
            <input type="hidden" name="action" value="add_course">
            <div class="form-group">
                <label for="scheme_id">Select Scheme</label>
                <select id="scheme_id_course" name="scheme_id" class="form-control" required>
                    <option value="">Select a scheme</option>
                    <?php foreach ($schemes as $scheme): ?>
                        <option value="<?= $scheme['id'] ?>"><?= htmlspecialchars($scheme['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="branch_id">Select Branch</label>
                <select id="branch_id_course" name="branch_id" class="form-control" required>
                    <option value="">Select a branch</option>
                    <?php foreach ($branches as $branch): ?>
                        <option value="<?= $branch['id'] ?>"><?= htmlspecialchars($branch['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="course_name">Course Name</label>
                <input type="text" id="course_name" name="course_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="links">Course Links</label>
                <div id="links-list-course">
                    <div class="input-group mb-2">
                        <input type="text" name="links[0][link_name]" class="form-control" placeholder="Link Name" required>
                        <input type="url" name="links[0][url]" class="form-control" placeholder="Link URL" required>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary mb-3" onclick="addLinkField('course')">Add More Links</button>
            </div>
            <button type="submit" class="btn btn-primary">Add Course</button>
        </form>

        <!-- Filter and Update Course Links -->
        <h3 class="mt-5">Update Course Links</h3>
        <form method="GET" action="">
            <div class="form-group">
                <label for="filter_course">Select Course</label>
                <select id="filter_course" name="course_id" class="form-control" onchange="this.form.submit()">
                    <option value="">Select a course</option>
                    <?php foreach ($courses as $course): ?>
                        <option value="<?= $course['id'] ?>" <?= (isset($_GET['course_id']) && $_GET['course_id'] == $course['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($course['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>

        <?php if ($selected_course): ?>
            <form method="POST" action="">
                <input type="hidden" name="action" value="save_links">
                <input type="hidden" name="course_id" value="<?= $selected_course['id'] ?>">

                <div class="form-group">
                    <label for="course_name">Course</label>
                    <input type="text" id="course_name" class="form-control" value="<?= htmlspecialchars($selected_course['name']) ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="links">Course Links</label>
                    <div id="links-list-update">
                        <?php if (!empty($links)): ?>
                            <?php foreach ($links as $index => $link): ?>
                                <div class="input-group mb-2">
                                    <input type="text" name="links[<?= $index ?>][link_name]" class="form-control" placeholder="Link Name" value="<?= htmlspecialchars($link['link_name']) ?>" required>
                                    <input type="url" name="links[<?= $index ?>][url]" class="form-control" placeholder="Link URL" value="<?= htmlspecialchars($link['url']) ?>" required>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="input-group mb-2">
                                <input type="text" name="links[0][link_name]" class="form-control" placeholder="Link Name" required>
                                <input type="url" name="links[0][url]" class="form-control" placeholder="Link URL" required>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button type="button" class="btn btn-secondary mb-3" onclick="addLinkField('update')">Add More Links</button>
                </div>

                <button type="submit" class="btn btn-primary">Save Links</button>
            </form>
        <?php else: ?>
            <p class="text-muted">Select a course to update links.</p>
        <?php endif; ?>
    </div>

    <script>
        let linkCountCourse = 1;
        let linkCountUpdate = <?= !empty($links) ? count($links) : 1 ?>;

        function addLinkField(section) {
            const linksList = section === 'course' ? document.getElementById('links-list-course') : document.getElementById('links-list-update');
            const count = section === 'course' ? linkCountCourse : linkCountUpdate;
            const newLinkField = `
                <div class="input-group mb-2">
                    <input type="text" name="links[${count}][link_name]" class="form-control" placeholder="Link Name" required>
                    <input type="url" name="links[${count}][url]" class="form-control" placeholder="Link URL" required>
                </div>
            `;
            linksList.insertAdjacentHTML('beforeend', newLinkField);
            if (section === 'course') {
                linkCountCourse++;
            } else {
                linkCountUpdate++;
            }
        }
    </script>
</body>
</html>
