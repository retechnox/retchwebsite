<?php
// Function to delete a directory and its contents
function deleteDirectory($dir) {
    // Check if the directory exists
    if (!is_dir($dir)) {
        return false;
    }

    // Scan the directory
    $files = array_diff(scandir($dir), array('.', '..'));

    // Loop through each file/folder and delete it
    foreach ($files as $file) {
        $filePath = $dir . DIRECTORY_SEPARATOR . $file;

        // If it's a directory, call deleteDirectory recursively
        if (is_dir($filePath)) {
            deleteDirectory($filePath);
        } else {
            unlink($filePath); // Delete file
        }
    }

    // After deleting all contents, remove the directory itself
    return rmdir($dir);
}

// Check if the button is pressed and the action is "delete"
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_directory'])) {
    // Directory path to delete
    $directoryPath = 'uploads/screenshots';

    // Call the function to delete the directory
    if (deleteDirectory($directoryPath)) {
        echo '<div class="alert alert-success">Directory deleted successfully!</div>';
    } else {
        echo '<div class="alert alert-danger">Failed to delete directory.</div>';
    }
}
?>

<!-- Button to trigger the deletion -->
<form method="POST">
    <button type="submit" name="delete_directory" class="btn btn-danger">Delete Directory</button>
</form>
