<?php
$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'POST') {
    include 'partials/_dbconnect.php';
    // making full name attacker proof
    $fullName = $_POST['fname'];
    $fullName_safe1 = str_replace("<", "&lt", "$fullName");
    $fullName_safe2 = str_replace("<", "&lt", "$fullName_safe1");
    $fullName_safe = str_replace("'", "&#39", "$fullName_safe2");

    // making email attacker proof

    $signup_email = $_POST['signup_email'];
    $signup_email_safe1 = str_replace("<", "&lt", "$signup_email");
    $signup_email_safe2 = str_replace("<", "&lt", "$signup_email_safe1");
    $signup_email_safe = str_replace("'", "&#39", "$signup_email_safe2");

    $signup_password = $_POST['signup_password'];
    $signup_cpassword = $_POST['signup_cpassword'];

    $age = $_POST['age'];
    $mobile = $_POST['mobile'];


    // check whether some one has already has account with email that user has entered 
    $exists_email_code = "SELECT * FROM `users_forum` WHERE Email = '$signup_email'";
    $result_exists_email_code = mysqli_query($conn, $exists_email_code);
    $numRows = mysqli_num_rows($result_exists_email_code);
    if ($numRows > 0) {
        echo '<h3>Someone is already using this email try with new one</h3>
        <a href="/index.php" class="btn btn-success mx-2">Go to home</a>';
        exit();
    } else {
        // Now i will check whether password matches with confirm password
        if ($signup_password == $signup_cpassword) {
            $hash_password = password_hash($signup_password, PASSWORD_DEFAULT);
            $Sql_code_insert_user_data = "INSERT INTO `users_forum` (`Full Name`, `Email`, `Password`, `Age`, `Mobile`, `TimeStamp`) VALUES ('$fullName_safe', '$signup_email_safe', '$hash_password', '$age', '$mobile', current_timestamp());";
            $result_Sql_code_insert_user_data = mysqli_query($conn, $Sql_code_insert_user_data);
            if ($result_Sql_code_insert_user_data) {


                header("Location:/index.php?signupSuccess=true");
                exit();
            }
        } else {

            echo '<h3>Your password does not matches with confirm password</h3>
            <a href="/index.php" class="btn btn-success mx-2">Go to home</a>';

            exit();
        }
    }
}
