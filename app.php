<!DOCTYPE html>
<!--

    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
<?php
$servername = "localhost";
$username = "";
$password = "_password";
$dbname = "appointment Doctors";

// Create a database connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check for connection errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to create a new patient account
function createPatientAccount($email, $password) {
    global $conn;
    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // Insert the account details into the patient table
    $sql = "INSERT INTO patient (email, password) VALUES ('$email', '$hashed_password')";
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        return false;
    }
}

// Function to check if a patient account already exists with a given email
function checkPatientEmail($email) {
    global $conn;
    // Query the patient table for a matching email
    $sql = "SELECT * FROM patient WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

// Function to authenticate a patient's login credentials
function authenticatePatient($email, $password) {
    global $conn;
    // Query the patient table for a matching email
    $sql = "SELECT * FROM patient WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Verify the password hash
        if (password_verify($password, $row['password'])) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

// Function to create a new appointment
function createAppointment($ap_time, $ap_date, $doctor_name, $patient_id) {
    global $conn;
    // Insert the appointment details into the appointment table
    $sql = "INSERT INTO appointment (ap_time, ap_date, doctor_name, patient_id) VALUES ('$ap_time', '$ap_date', '$doctor_name', '$patient_id')";
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        return false;
    }
}

// Function to cancel an existing appointment
function cancelAppointment($ap_id) {
    global $conn;
    // Delete the appointment from the appointment table
    $sql = "DELETE FROM appointment WHERE ap_id='$ap_id'";
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        return false;
    }
}

// Function to reschedule an existing appointment
function rescheduleAppointment($ap_id, $ap_time, $ap_date) {
    global $conn;
    // Update the appointment details in the appointment table
    $sql = "UPDATE appointment SET ap_time='$ap_time', ap_date='$ap_date' WHERE ap_id='$ap_id'";
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        return false;
    }
}
?>

        
    

