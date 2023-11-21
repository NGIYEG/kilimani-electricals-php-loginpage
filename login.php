<?php
session_start();
include_once 'header.php';

require_once "db.php";

if (isset($_SESSION['user_id']) != "") {
    // Check if the user is already logged in, you can handle this as needed.
    // redirect the user to index.php
    header("Location: index.php");
    exit();
}

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Please Enter Valid Email ID";
    }
    if (strlen($password) < 6) {
        $password_error = "Password must be a minimum of 6 characters";
    }

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '" . $email . "' and password = '" . md5($password) . "'");

    if ($result === false) {
        die(mysqli_error($conn)); // Output the error for debugging
    }

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $_SESSION['user_id'] = $row['uid'];
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['user_email'] = $row['email'];
        $_SESSION['user_mobile'] = $row['mobile'];
        header("Location: index.php");
        exit(); // Make sure to exit after index redirect
    } else {
        $error_message = "Incorrect Email or Password!!!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Untitled</title>
    <link rel="stylesheet" href="styles\signup.css">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>

    <div class="register-photo">
        <div class="form-container">
            <div class="image-holder"></div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h2 class="text-center">Log in</h2>
                <p>Please fill all fields in the form</p>

                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email..." value="" maxlength="30"
                        required="">
                    <span class="text-danger">
                        <?php if (isset($email_error)) echo $email_error; ?>
                    </span>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" value=""
                        maxlength="8" required="">
                    <span class="text-danger">
                        <?php if (isset($password_error)) echo $password_error; ?>
                    </span>
                </div>
                <div class="form-group"><button class="btn btn-primary btn-block" type="submit" name="login">Log in</button></div>
                <div class="already">
                    You don't have an account?<a href="signup.php" class=""> Sign up.</a>
                </div>
            </form>
        </div>
    </div>

    <?php
    include_once 'footer.php';
    ?>
</body>

</html>
