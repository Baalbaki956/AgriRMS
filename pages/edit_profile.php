<?php  
$pageTitle = "Edit Profile";
ob_start();

require_once '../helpers/constants.php';
require_once BASE_PATH . "/includes/header.php";
require_once BASE_PATH . "/includes/sidebar.php";
require_once BASE_PATH . "/includes/topbar.php";
require_once BASE_PATH . '/helpers/functions.php';
require_once BASE_PATH . '/classes/Connection.php';

if (!isset($_SESSION['user'])) {
    redirectPage('../index.php', 3);
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["first_name"]) || empty($_POST["first_name"])) {
        echo "Please fill in the first name field.";
    } else {
        $firstName = sanitizeString($_POST["first_name"]);
    }
    if (!isset($_POST["last_name"]) || empty($_POST["last_name"])) {
        echo "Please fill in the last name field.";
    } else {
        $lastName = sanitizeString($_POST["last_name"]);
    }
    if (!isset($_POST["email"]) || empty($_POST["email"])) {
        echo "Please fill in the email field.";
    } else {
        $email = sanitizeString($_POST["email"]);
    }
    if (!isset($_POST["phone"]) || empty($_POST["phone"])) {
        echo "Please fill in the phone field.";
    } else {
        $phone = sanitizeString($_POST["phone"]);
    }
    if (!isset($_POST["address"]) || empty($_POST["address"])) {
        echo "Please fill in the phone field.";
    } else {
        $address = sanitizeString($_POST["address"]);
    }

    if (!empty($firstName) && !empty($lastName) && !empty($email) && !empty($phone) && !empty($address)) {
        $username = $firstName . ' ' . $lastName;
        $connection = new Connection();

        $userId = $_SESSION['user']['FID'];
        $query = "UPDATE FARMER SET FFIRSTNAME = '$firstName', FLASTNAME = '$lastName', FUSERNAME = '$username' , FEMAIL = '$email', FPHONE = '$phone', FADDRESS = '$address' WHERE FID = $userId";
        $result = $connection->executeQuery($query);
        
        if ($result) {
            $_SESSION['user']['FFIRSTNAME'] = $firstName;
            $_SESSION['user']['FLASTNAME'] = $lastName;
            $_SESSION['user']['FUSERNAME'] = $username;
            $_SESSION['user']['FEMAIL'] = $email;
            $_SESSION['user']['FPHONE'] = $phone;
            $_SESSION['user']['FADDRESS'] = $address;

            redirectTo("view_profile.php");
        } else {
            echo "Update failed.";
        }
    }
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
                                <h1 class="h4 text-gray-900 mb-4">
                                    <?php  
                                    if (isset($_SESSION['user'])) {
                                        echo $_SESSION['user']['FUSERNAME'];
                                    }
                                    ?> - Edit Page
                                </h1>
                            </div>
                            <form class="user" method="post" action="">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control" id="first_name" name="first_name" 
                                            placeholder="First Name" value="<?php echo $_SESSION['user']['FFIRSTNAME']; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="last_name" name="last_name" 
                                            placeholder="Last Name" value="<?php echo $_SESSION['user']['FLASTNAME']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" id="email" name="email" 
                                        placeholder="Email Address" value="<?php echo $_SESSION['user']['FEMAIL']; ?>">
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="phone">Phone Number:</label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone number" value="<?php echo $_SESSION['user']['FPHONE']; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="address">Address:</label>
                                    <textarea class="form-control" id="address" name="address" placeholder="sesame street, 10012" value="asdasdasd"><?php echo $_SESSION['user']['FADDRESS']; ?></textarea>
                                </div>

                                 <input href="" class="btn btn-primary btn-user btn-block" type="submit" value="Save">
                                </input>
                                <hr>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php  
require_once "../includes/footer.php";
ob_end_flush();
?>