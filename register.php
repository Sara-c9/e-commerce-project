<?php

//Include Nav bar

include('nav.php');

//Check if form is submitted
if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
{

//Connent to mysql database
require ('connection_db.php');

// Create array $errors to store errors
$errors = array();

//If field first name is empty, display error message 
if ( empty($_POST['first_name'])) {
    $errors [] = 'Enter your name'; 
}

//If not empty, use POST method to sent value to database
else
{
    $fn = mysqli_real_escape_string($link, trim( $_POST['first_name']));
}

//If field last name is empty, display error message 
if ( empty($_POST['last_name'])) {
    $errors [] = 'Enter your last name'; 
}
else
{
    $ln = mysqli_real_escape_string($link, trim( $_POST['last_name']));
}

//If field email is empty, display error message 
if ( empty($_POST['email'])) {
    $errors [] = 'Enter your email address'; 
}
else
{
    $e = mysqli_real_escape_string($link, trim( $_POST['email']));
}

//Check that password field is not empty
if (!empty ($_POST['password'])) {

//Check that password and confirm_password fields are the same, if not store error message
    if ($_POST['password'] != $_POST ['confirm_password']) {
        $errors[] = 'Password do not match'; 
    }
    else {
        $p = mysqli_real_escape_string ($link, trim ($_POST['password']));
    }
}
    else {
        $errors [] = 'Enter password' ;
    }

//Check that email inserted is not present in the datbase
if ( empty ($errors)) {
    $q = "SELECT user_id FROM users WHERE email = '$e'";
    $r = mysqli_query ($link, $q);
    if (mysqli_num_rows ($r) != 0)

    $errors [] = 'Email address already registered. <br> 
    <a class = "alert-link" href="login.php">Sign In Now</a>';
}

//If no errors are stored, insert the data inputted on the field in the database
if (empty($errors)) {
    $q = "INSERT INTO users (first_name, last_name, email, pass, reg_date)
    VALUES ('$fn', '$ln', '$e', '$p', NOW())";
    $r = mysqli_query ($link, $q);

    if ($r) {
        echo '<div class="text-center mt-5 text-success">
        <h3> You are now registered!</h3>
        <a class="alert-link" href="login.php">Login</a>
        </div>';
    }

//Close database connection
    mysqli_close ($link);
    exit();
}

//Report error if any
else {
echo '<div class="text-center mt-5 text-danger">
<h4 class="alert-heading" id"err_msg">The following error(s) occured:</h4>
</div>';
foreach ($errors as $msg) {
    echo '<div class="text-center mt-2 text-danger"> -' . $msg. '<br></div>';
}
echo '<div class="text-center mt-2 text-danger"> <p> Please try again</p> </div>';
mysqli_close ($link);
 }
}
?>
<section id="registration">
    <div class="container-lg">
        <div class="text-center mt-5 text-success-emphasis">
            <h2>Registration Form</h2>
            <p class="lead mt-3 mb-5">Fill out the form below to register</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form action="register.php" method="post">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="first_name" class="form-label">Name*</label>
                            <input type="text" class="form-control" name="first_name" placeholder="John" aria-label="Name" >
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="last_name" class="form-label">Last Name*</label>
                            <input type="text" class="form-control" name="last_name" placeholder="Smith" aria-label="Last Name" >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <label for="email" class="form-label">Email*</label>
                            <div class="input-group">
                                <span class="input-group-text" id="email-addon">
                                    <i class="far fa-envelope"></i>
                                </span>
                                <input type="email" class="form-control" name="email" placeholder="name.lastname@email.com" aria-label="Email" aria-describedby="email-addon" >
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <label for="password" class="form-label">Password*</label>
                            <input type="password" class="form-control" name="password" placeholder="Password" aria-label="Password">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <label for="confirm_password" class="form-label">Confirm Password*</label>
                            <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" aria-label="Confirm Password" >
                        </div>
                    </div>
                    <div class="text-center mt-5 mb-4">
                        <input class="btn btn-outline-success" type="submit" value="Register">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include ('footer.php');
?>


