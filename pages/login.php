<?php  
$pageTitle = "Login";

require_once '../helpers/constants.php';
require_once BASE_PATH . "/includes/header.php";
require_once BASE_PATH . '/helpers/functions.php';
require_once BASE_PATH . '/classes/Connection.php';

$email = $emailError = "";
$password = $passwordError = "";

if (isPostRequested()) {
    if (!isset($_POST["email"]) || empty($_POST["email"])) {
        $emailError = "* Error! Email address is empty.";
    } else {
        $email = sanitizeString($_POST["email"]);
    }

    if (!isset($_POST["password"]) && empty($_POST["password"])) {
        $passwordError = "* Error! Password is empty.";
    } else {
        $password = md5(sanitizeString($_POST["password"]));
    }

    if (empty($emailError) && empty($passwordError)) {
        $connection = new Connection();
        $query = "SELECT * FROM FARMER WHERE FEMAIL = '$email' AND FPASSWORD = '$password'";
        $result = $connection->executeQuery($query);
        
        if ($connection->getNumRows($result) == 1) {
            $row = $connection->fetchRow($result);
            $_SESSION['user'] = $row;
            if ($email === $row["FEMAIL"] && $password === $row["FPASSWORD"]) {
                redirectTo("../pages/dashboard.php");
            }
        }
    }
}
?>

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form class="user" method="post" action="">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="email" name="email" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address...">
                                                <?php
                                                if ($emailError != "") {
                                                    ?>
                                                    <p>
                                                        <span class="alert alert-danger d-block"><?php echo $emailError; ?></span>
                                                    </p>
                                                    <?php
                                                }
                                                ?>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="password" name="password" placeholder="Password">
                                                <?php
                                                if ($passwordError != "") {
                                                    ?>
                                                    <p>
                                                        <span class="alert alert-danger d-block"><?php echo $passwordError; ?></span>
                                                    </p>
                                                    <?php
                                                }
                                                ?>
                                        </div>
                                        
                                        <input class="btn btn-primary btn-user btn-block" type="submit" value="Login">
                                        </input>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="<?php echo HOST; ?>/pages/register.php">Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
<?php 
require_once "../includes/footer.php";
?>