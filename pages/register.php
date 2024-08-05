<?php  
$pageTitle = "Register";

require_once '../helpers/constants.php';
require_once BASE_PATH . "/includes/header.php";
require_once BASE_PATH . '/helpers/functions.php';
require_once BASE_PATH . '/classes/Connection.php';

$firstName = $lastName = $username = $email = $password = $cpassword = "";
$firstNameError = $lastNameError = $genderError = $emailError = $passwordError = $cPasswordError = "";

if (isPostRequested()) {
        if (!isset($_POST["first_name"]) || empty($_POST["first_name"])) {
            $firstNameError = "* Error! First Name field is empty.";
        } else {
            $firstName = sanitizeString($_POST["first_name"]);
        }
        if (!isset($_POST["last_name"]) || empty($_POST["last_name"])) {
            $lastNameError = "* Error! Last Name field is empty.";
        } else {
            $lastName = sanitizeString($_POST["last_name"]);
        }
        
        if (!isset($_POST["email"]) || empty($_POST["email"])) {
            $emailError = "* Error! Email Address field is empty.";
        } else {
            $email = sanitizeString($_POST["email"]);
        }
        if (!isset($_POST["password"]) || empty($_POST["password"])) {
            $passwordError = "* Error! Password field is empty.";
        } else {
            $password = md5(sanitizeString($_POST["password"]));
        }
        if (!isset($_POST["cpassword"]) || empty($_POST["cpassword"])) {
            $cPasswordError = "* Error! Confirm Passowrd field is empty.";
        } else {
            $cpassword = sanitizeString($_POST["cpassword"]);
        }

        $gender = isset($_POST["gender"]) ? $_POST["gender"] : "";
        $gender = sanitizeString($gender);

        $dateOfBirth = isset($_POST["birthday"]) ? $_POST["birthday"] : "";
        $dateOfBirth = sanitizeString($dateOfBirth);

        $phoneNumber = isset($_POST["phone"]) ? $_POST["phone"] : "";
        $phoneNumber = sanitizeString($phoneNumber);

        $address = isset($_POST["address"]) ? $_POST["address"] : "";
        $address = sanitizeString($address);

        $status = isset($_POST["status"]) ? $_POST["status"] : "";
        $status = sanitizeString($status);

        $type = isset($_POST["type"]) ? $_POST["type"] : "";
        $type = sanitizeString($type);

        if (empty($firstNameError) && empty($lastNameError) && empty($emailError) && empty($passwordError) && empty($cPasswordError)) {
            $username = $firstName . ' ' . $lastName;
            $connection = new Connection();
            $query = "INSERT INTO FARMER (FFIRSTNAME, FLASTNAME, FUSERNAME, FPASSWORD, FEMAIL, FDATEOFBIRTH, FGENDER, FPHONE, FADDRESS, FSTATUS, FTYPE) VALUES ('$firstName', '$lastName', '$username', '$password', '$email', '$dateOfBirth', '$gender', '$phoneNumber', '$address', '$status', '$type')";
            $result = $connection->executeQuery($query);
            
            $connection->close();
            redirectTo("/AgriRMS/index.php");
        }
    }

?>

<div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" method="post" action="">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control" id="first_name" name="first_name" 
                                            placeholder="First Name">
                                            <?php
                                            if ($firstNameError != "") {
                                                ?>
                                                <p>
                                                    <span class="alert alert-danger d-block"><?php echo $firstNameError; ?></span>
                                                </p>
                                                <?php
                                            }
                                            ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="last_name" name="last_name" 
                                            placeholder="Last Name">
                                            <?php
                                            if ($lastNameError != "") {
                                                ?>
                                                <p>
                                                    <span class="alert alert-danger d-block"><?php echo $lastNameError; ?></span>
                                                </p>
                                                <?php
                                            }
                                            ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" id="email" name="email" 
                                        placeholder="Email Address">
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

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                      <label for="birthday">Date of birth:</label>
                                      <input type="date" class="form-control" id="birthday" name="birthday">
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <label for="gender">Gender:</label>
                                        <select class="form-control" id="gender" name="gender">
                                            <option>Male</option>
                                            <option>Female</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- <div class="col-sm-6"> -->

                                <!-- here -->
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="phone">Phone Number:</label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone number">
                                    </div>

                                </div>

                                <div class="form-group">
                                    <textarea class="form-control" id="address" name="address" placeholder="sesame street, 10012"></textarea>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control"
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
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control"
                                            id="cpassword" name="cpassword" placeholder="Repeat Password">
                                            <?php if ($cPasswordError != "") {
                                            ?>
                                            <p>
                                                <span class="alert alert-danger d-block"><?php echo $cPasswordError; ?></span>
                                            </p>
                                            <?php
                                        } ?>
                                    </div>
                                </div>
                                 <input href="" class="btn btn-primary btn-user btn-block" type="submit" value="Register Account">
                                </input>
                                <hr>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="./login.php">Already have an account? Login!</a>
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

<?php 

?> - Profile page