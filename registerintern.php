<?php
include 'db.php';

// Get Internship ID from the URL
$internshipId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$internshipStmt = $pdo->prepare("SELECT * FROM internships WHERE id = ?");
$internshipStmt->execute([$internshipId]);
$internship = $internshipStmt->fetch();

if (!$internship) {
    echo "Internship not found!";
    exit;
}

// Handle Student Registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $studentName = $_POST['student_name'];
    $phoneNumber = $_POST['phone_number'];
    $email = $_POST['email'];
    $collegeName = $_POST['college_name'];
    $departmentYear = $_POST['department_year'];
    $referralCode = $_POST['referral_code'] ?? null;
    $remarks = $_POST['remarks'] ?? null;
    $id=$_GET['id']?? null;

    // Check if the student already exists
    $studentCheckStmt = $pdo->prepare("SELECT * FROM internship_registrations WHERE phone_number = ? OR email = ?");
    $studentCheckStmt->execute([$phoneNumber, $email]);
    $student = $studentCheckStmt->fetch();

    if (!$student) {
        $insertStudentStmt = $pdo->prepare("INSERT INTO internship_registrations (name, phone_number, email) VALUES (?, ?, ?)");
        $insertStudentStmt->execute([$studentName, $phoneNumber, $email]);
    }

    // Handle Screenshot Upload
    $uploadDir = 'uploads/screenshots/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $screenshotName = basename($_FILES['screenshot']['name']);
    $screenshotExt = pathinfo($screenshotName, PATHINFO_EXTENSION);
    $newScreenshotName = uniqid() . '.' . $screenshotExt;
    $screenshotPath = $uploadDir . $newScreenshotName;

    $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($screenshotExt, $allowedFileTypes)) {
        echo "Invalid file type. Only JPG, PNG, and GIF files are allowed.";
        exit;
    }

    if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $screenshotPath)) {
        $stmt = $pdo->prepare("
            INSERT INTO internship_registrations (
                internship_id, student_name, phone_number, email, 
                college_name, department_year, referral_code, remarks, screenshot_image
            ) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        if (
            $stmt->execute([
                $internshipId,
                $studentName,
                $phoneNumber,
                $email,
                $collegeName,
                $departmentYear,
                $referralCode,
                $remarks,
                $screenshotPath
            ])
        ) {
            header('Location: success.php');
            exit();
        } else {
            echo "Failed to register. Please try again.";
        }
    } else {
        echo "Failed to upload screenshot.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register for <?php echo htmlspecialchars($internship['title']); ?></title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        /* Existing styles you provided */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #FAACA8;
            background-image: linear-gradient(19deg, #FAACA8 0%, #DDD6F3 100%);
        }

        .container {
            display: flex;
            padding: 50px;
        }

        .card-style {
            width: 100%;
            max-width: 600px;
            margin: auto;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            background-color: white;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            background: linear-gradient(90deg, #4CAF50, #2E7D32);
            color: white;
            font-size: 16px;
            border: 1px black solid;
            border-radius: 8px;
            text-decoration: none;
        }

        .form-control,
        .form-control-file {
            font-family: poppins;
            border-radius: 6px;
            background-color: #e3f2fd;
            border: 1px solid #90caf9;
            width: 100%;
            height: 40px;
            padding: 5px;
        }

        .form-control,
        p {
            color: purple;
        }

        #remarks {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .styled-textarea {
            background-color: #e3f2fd;
            border: 1px solid #90caf9;
            border-radius: 6px;
            padding: 10px;
        }

        .upload-label {
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            color: #555;
        }

        .upload-label i {
            font-size: 1.2em;
        }

        .payment-details {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            text-align: left;
        }

        .payment-details .column {
            flex: 1 1 48%;
        }

        @media (max-width: 768px) {
            .payment-details .column {
                flex: 1 1 100%;
            }

            .form-control,
            .form-control-file {
                width: 70vw;
                height: 5vh;
                padding: 10px;
            }

            .card-style {
                width: 80vw;
            }
        }

        h3 {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card card-style">
            <h2 class="text-center">Register for <?php echo htmlspecialchars($internship['title']); ?></h2>
            <form action="registerintern.php?id=<?php echo $internshipId; ?>" method="post" enctype="multipart/form-data">
                <!-- Form Fields -->
                <div class="form-group">
                    <label for="student_name">Name</label>
                    <input type="text" class="form-control" id="student_name" name="student_name"
                        placeholder="Enter your name" required>
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="tel" class="form-control" id="phone_number" name="phone_number"
                        placeholder="Enter your Phone Number" required>
                </div>
                <div class="form-group">
                    <label for="email">Email-id</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your Email-id"
                        required>
                </div>
                <div class="form-group">
                    <label for="college_name">College Name</label>
                    <input type="text" class="form-control" id="college_name" name="college_name"
                        placeholder="Enter your college name" required>
                </div>
                <div class="form-group">
                    <label for="department_year">Department and Year</label>
                    <input type="text" class="form-control" id="department_year" name="department_year"
                        placeholder="Enter your department and year" required>
                </div>
                <div class="form-group">
                    <label for="referral_code">Referral Code (optional)</label>
                    <input type="text" class="form-control" id="referral_code" name="referral_code"
                        placeholder="Enter referral code if any">
                </div>
                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <textarea class="form-control styled-textarea" id="remarks" name="remarks" rows="3"
                        placeholder="Enter your remarks"></textarea>
                </div>

                <h3 class="text-center">Payment Details</h3>
                <div class="payment-details">
                    <div class="column text-center">
                        <p>Amount: ₹ <?php echo htmlspecialchars($internship['amount']); ?></p>
                        <a href="<?php echo htmlspecialchars($internship['gpay_link'] ?? '#'); ?>" target="_blank"
                            class="btn btn-simple">
                            <span style="color:white"> <i class="fas fa-credit-card"></i> </span> <span
                                style="color:white">Pay Now</span> </a></button>
                    </div><br>
                    <div class="column text-center">
                        <img src="<?php echo htmlspecialchars($internship['qr_code_image']); ?>" class="img-fluid"
                            width="200" alt="QR Code">
                    </div>
                    <br>
                    <div class="form-group"><br>
                        <label class="upload-label" for="screenshot">
                            <i class="fas fa-upload"></i> Upload Payment Screenshot
                        </label>
                        <input type="file" class="form-control-file" id="screenshot" name="screenshot" accept="image/*"
                            required> <br>
                        <button class="btn">
                            <a
                                href="https://api.whatsapp.com/send?phone=918848656908&text=Screenshot for payment of,<?php echo htmlspecialchars($internship['title']); ?>">
                                <span style="color:white"> <i class="fab fa-whatsapp"></i> Send on Whatsapp</span>
                            </a> </button>
                    </div>
                </div>
                <button class="btn btn-primary mt-4" type="submit" name="register">Register Now</button>
            </form>
        </div>
    </div>
</body>

</html>