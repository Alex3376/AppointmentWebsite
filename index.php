<?php
session_start();

if (isset($_SESSION["user_id"])) {

    require_once('database.php');

    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Book Appointment</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    </head>
    <body>

        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 ">
                    <div class="appoinment-content">
                    </div>
                </div>
                <div class="col-lg-6 col-md-10 ">
                    <div class="appoinment-wrap mt-5 mt-lg-0">
                        <h2 class="mb-2 title-color">Book appointment</h2>
                        <p class="mb-4">
                            Now you can get an online appointment.
                        </p>
                        <?php
                        if (isset($_POST['submit'])) { //doctor,date,time,name

                            var_dump($_POST);
                            
                            if (isset($_POST['doctor']) && !empty($_POST['date']) && !empty($_POST['time']) && !empty($_POST['name'])) {
                                /*$statement = $mysqli->prepare("INSERT INTO appointment (doctor, app_date, app_time, patient_name) VALUES (?, ?, ?, ?, ?)");
                                
                                $is_done = $statement->execute([
                                    'doctor' => $_POST['doctor'],
                                    'app_date' => $_POST['date'],
                                    'app_time' => $_POST['time'],
                                    'patient_name' => $_POST['name'],
                                ]);*/
                        
                                require_once('database.php');

                                $sql = "INSERT INTO appointment (doctor, app_date, app_time, patient_name)
                                        values (?,?,?,?)";
                                
                                //$stmt = mysqli_stmt_intit($conn);
                                $stmt = $mysqli->prepare($sql);
                                
                                $doctor = $_POST['doctor'];
                                $app_date = $_POST['date'];
                                $app_time = $_POST['time'];
                                $patient_name = $_POST['name'];
                                mysqli_stmt_bind_param($stmt, "ssss",
                                                       $doctor,
                                                       $app_date,
                                                       $app_time,
                                                       $patient_name);
                                
                                mysqli_stmt_execute($stmt);
                                $is_done1 = mysqli_stmt_execute($stmt);
                                
                                if ($is_done1) {
                                    echo "<p class='success'>Your appointment has been taken!</p>";
                                    //header("Refresh:1;url= success.php");
                                }
                            } else {
                                echo "<p class='error'>Fill out all of the form data!</p>";
                            }
                        }
                        ?>
                        <form id="#" class="appoinment-form" method="post" action="#">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <select class="form-control" id="doctor" name="doctor">
                                            <option>Choose Doctor</option>
                                            <?php
                                            //Doctors drop down list
                                            $sql = "SELECT name,doctor_id FROM doctors order by name";
                                            foreach ($mysqli->query($sql) as $row) {//Array or records stored in $row
                                                echo "<option value=$row[doctor_id]>$row[name]</option>";
                                            }
                                            echo "</select>";
                                            ?>
                                        </select>                                        
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input name="date" id="date" type="text" class="form-control" placeholder="yy-mm-dd">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input name="time" id="time" type="text" class="form-control" placeholder="Time">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input name="name" id="name" type="text" class="form-control" placeholder="Full Name">
                                    </div>
                                </div>
                            </div>
                            <input type="submit" name="submit" class="btn btn-main btn-round-full" value="Make Appoinment">
                        </form>
                        <p><a href="home.php">Home</a>
                        <p><a href="logout.php">Log out</a></p>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
        <script>

            //jquery datepicker
            $("#date").datepicker({
                dateFormat: 'yy-mm-dd',
                minDate: 0
            });

            //timepicker
            $('#time').timepicker({

            });
        </script>
    </body>
</html>
