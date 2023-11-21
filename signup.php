<?php
session_start();

include_once 'header.php';

require_once "db.php";




if (isset($_SESSION['user_id']) != "") {
    // Redirect the user if already logged in
    header("Location: index.php");
}

$name_error = $email_error = $mobile_error = $password_error = $cpassword_error = '';
$name = $email = $mobile = $password = $cpassword = '';

if (isset($_POST['signup'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);

    if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
        $name_error = "Name must contain only alphabets and space";
    }

    // Additional validation checks for email and password if needed

    if (strlen($mobile) < 10) {
        $mobile_error = "Mobile number must be a minimum of 10 characters";
    }

    if ($password != $cpassword) {
        $cpassword_error = "Password and Confirm Password don't match";
    }

    

    // Initialize $error variable
    $error = false;

    if (!$error) {
        $hashed_password = md5($password);
        $sql = "INSERT INTO users(name, email, mobile, password) VALUES ('$name', '$email', '$mobile', '$hashed_password')";

        if (mysqli_query($conn, $sql)) {
            // Redirect to login page after successful registration
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $sql . "" . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles\signup.css">

    <title>Sign Up</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="register-photo">
        <div class="form-container">
            <div class="image-holder"></div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h2 class="text-center">Sign up</h2>
                <p>Please fill all fields in the form</p>
                <div class="form-group">
                    <input type="text" name="name" placeholder="Name" class="form-control" value="<?php echo $name; ?>"
                        maxlength="50" required="">
                    <span class="text-danger">
                        <?php if (isset($name_error))
                            echo $name_error; ?>
                    </span>
                </div>

                <div class="form-group">
                    <input type="email" name="email" placeholder="Email" class="form-control"
                        value="<?php echo $email; ?>" maxlength="30" required="">
                    <span class="text-danger">
                        <?php if (isset($email_error))
                            echo $email_error; ?>
                    </span>
                </div>

                <div class="form-group">
                    <input type="text" name="mobile" placeholder="Mobile" class="form-control"
                        value="<?php echo $mobile; ?>" maxlength="12" required="">
                    <span class="text-danger">
                        <?php if (isset($mobile_error))
                            echo $mobile_error; ?>
                    </span>
                </div>

                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" class="form-control" value=""
                        maxlength="8" required="">
                    <span class="text-danger">
                        <?php if (isset($password_error))
                            echo $password_error; ?>
                    </span>
                </div>

                <div class="form-group">
                    <input type="password" name="cpassword" placeholder="Confirm password" class="form-control" value=""
                        maxlength="8" required="">
                    <span class="text-danger">
                        <?php if (isset($cpassword_error))
                            echo $cpassword_error; ?>
                    </span>
                </div>
                <div class="form-group">
                    <div class="form-check"><label class="form-check-label"><input class="form-check-input"
                                type="checkbox">I agree to the license terms.</label></div>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" name="signup" value="Submit">

                </div>
                <div class="already">You already have an account?<a href="login.php" class=""> Login here.</a></div>
            </form>


        </div>
    </div>

</body>
<?php
include_once 'footer.php';
?>

</html>