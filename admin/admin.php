<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">  
<head>     
    <meta charset="UTF-8">     
    <meta name="viewport" content="width=device-width, initial-scale=1.0">     
    <title>Admin Panel - KTU Magic</title>     
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">     
    <style>         
        body { background-color: #f8f9fa; }         
        .navbar { margin-bottom: 20px; }         
        .btn-custom { margin: 5px; }         
        .container { margin-top: 20px; }         
        .btn-home { background-color: #007bff; color: white; }         
        .btn-home:hover { background-color: #0056b3; }         
        .btn-admin { background-color: #28a745; color: white; }         
        .btn-admin:hover { background-color: #218838; }         
        .btn-view { background-color: #ffc107; color: black; }         
        .btn-view:hover { background-color: #e0a800; }         
        .btn-delete { background-color: #dc3545; color: white; }         
        .btn-delete:hover { background-color: #c82333; }         
        .btn-add { background-color: #17a2b8; color: white; }         
        .btn-add:hover { background-color: #138496; }     
    </style> 
</head>  


<body>      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">KTU Magic Admin</a>
        <a href="logout.php" class="btn btn-danger ml-auto">Logout</a>
    </nav>
 
       
    
    <div class="container">         
        <h2 class="mb-4">Admin Dashboard</h2>         
        <p>Welcome to the KTU Magic admin panel.</p>         
        <hr><br>         
        <div class="row">             
            <div class="col-md-12">                 
                <a href="/" class="btn btn-custom btn-home">Home</a>                 
                <a href="admin_updates.php" class="btn btn-custom btn-admin">Admin Updates</a>                 
                <a href="admin_latest.php" class="btn btn-custom btn-view">Admin Latest Updates</a><hr><br> 
                <h3>Internships</h3>                 
                <a href="intern/admin_internship.php" class="btn btn-custom btn-add">Add Internships and Approve</a>                 
                <a href="intern/view_internships.php" class="btn btn-custom btn-view">View Active Internships</a>                 
                <a href="intern/viewanddown.php" class="btn btn-custom btn-view">View And Download Internship</a>                 
                <a href="intern/delete_internship.php" class="btn btn-custom btn-delete">Close Internships</a> 
                <a href="intern/delscreen.php" class="btn btn-custom btn-delete">deelete screenshots</a> 

                <hr><br>                 
                <a href="admin_notes.php" class="btn btn-custom btn-view">Notes</a>
                <hr><br>
                <h3>Tuitions</h3>                 
                <a href="tut/admin_tuitions.php" class="btn btn-custom btn-add">Add Tuitions and Approve</a>                 
                <a href="tut/viewtut.php" class="btn btn-custom btn-view">View Active Tuitions</a>                 
                <a href="tut/viewanddowntut.php" class="btn btn-custom btn-view">View And Download Tuition</a>                 
                <a href="tut/deletetut.php" class="btn btn-custom btn-delete">Close Tuitions</a>
                <hr><br>
                <h3>workshops</h3>   
                <a href="workshop/admin_workshop.php" class="btn btn-custom btn-add">Add workshop and Approve</a>                 
                <a href="workshop/viewtut.php" class="btn btn-custom btn-view">View Active workshop</a>                 
                <a href="workshop/viewanddown.php" class="btn btn-custom btn-view">View And Download workshop</a>                 
                <a href="workshop/delete_workshop.php" class="btn btn-custom btn-delete">Close workshop</a>
            </div>         
        </div>     
    </div>          
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>     
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>     
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> 
</body>  
</html>
