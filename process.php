<?php
session_start();

include "header.php";
?>

<?php
// REGISTER USER
if (isset($_POST['save_user'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $confirm_pass = $_POST['confirm_pass'];
    $user_name = $_POST['user_name'];
    $day = $_POST['day'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $gender = $_POST['gender'];



    // confirming pass & confrirm pass matches.
    if ($pass !== $confirm_pass) {
        exit("<p>password do not match</p><a href='signup.php'>Go back</a</p>");
    }

    // checking if email already exist
    $email_exist = mysqli_query($connect, "SELECT * FROM users WHERE email = '$email'");
    if (mysqli_num_rows($email_exist) > 0) {
        exit("<p>email already exist</p><a href='login.php'>login</a>");

    }

    //   checking if username already exist
    $username_exist = mysqli_query($connect, "SELECT * FROM users WHERE user_name = '$user_name'");
    if (mysqli_num_rows($username_exist) > 0) {
        exit("<p>User name already exist</p><a href='signup.php'>Go back</a>");

    }

    // encrypting password
    $cryptic_pass = md5($pass);


    // inserting data into database.
    $insert_user = mysqli_query($connect, "INSERT INTO users(  email, password, user_name, day, month, year, gender) VALUES(  '$email', '$cryptic_pass', '$user_name', '$day', '$month', '$year', '$gender')");
    if ($insert_user) {
        header("location: login.php");
    }

}




// Login User
if(isset($_POST['login_user'])){
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $user_exist = mysqli_query($connect, "SELECT * FROM users WHERE email = '$email'");


    // if user does not exist
    if(!mysqli_num_rows($user_exist)){
        exit("<p>User not found</p> <p><a href='signup.php'>Sign Up</a></p> <p><a href='login.php'>Go back</a></p>");        
    }
  
    $user_details = mysqli_fetch_assoc($user_exist);

    $cryptic_pass = md5($pass);

    if($cryptic_pass !== $user_details['password']){
        exit("<p>Incorrect Password</p><a href='login.php'>Go back</a>");
    }

    // creates a session array 
    $_SESSION["login"] = true;
    $_SESSION["id"] = $user_details['id'];

    
    header("Location: account.php");

    
}


?>