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
        <title>Home</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
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
                        <h2 class="mb-2 title-color">Book appoinment</h2>
                        <p class="mb-4">
                            Now you can get an online appointment, We will get back to you and fix a meeting with a doctor.
                        </p>

                        <?php
                        if (isset($_POST['submit'])) {

                            if (isset($_POST['doctor']) && !empty($_POST['date']) && !empty($_POST['time']) && !empty($_POST['name'])) {
                                $statement = $DB->prepare('INSERT INTO appointment (doctor,app_date,app_time,patient_name) VALUES (:doctor,:app_date,:app_time,:patient_name)');

                                $is_done = $statement->execute([
                                    'doctor' => $_POST['doctor'],
                                    'app_date' => $_POST['date'],
                                    'app_time' => $_POST['time'],
                                    'patient_name' => $_POST['name'],
                                ]);

                                if ($is_done) {
                                    echo "<p class='success'>Your appointment has been taken!</p>";
                                    header("Refresh:1;url= success.php");
                                }
                            } else {
                                echo "<p class='error'>Fill out the all form data!</p>";
                            }
                        }
                        ?>

                        <form id="#" class="appoinment-form" method="post" action="#">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                     </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <select class="form-control" id="doctors" name="doctors"></select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input name="date" id="date" type="text" class="form-control" placeholder="dd/mm/yyyy">
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
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#department').change(function () {

                    var path = "doctors_list.php";
                    var department = $("#department").val();
                    $.ajax({
                        type: "POST",
                        url: path,
                        data: {
                            department: department
                        },
                        success: function (data) {
                            $('#doctors').html(data);
                        }
                    });
                    return false;
                });

                //jquery datepicker
                $("#date").datepicker({
                    dateFormat: 'dd/mm/yy',
                    minDate: 0
                });

                //timepicker
                $('#time').timepicker({

                });
            });
        </script>
</body>
</html>
