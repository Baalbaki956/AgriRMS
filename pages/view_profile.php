<?php  
$pageTitle = "View Profile";

require_once '../helpers/constants.php';
require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . "/includes/sidebar.php";
require_once BASE_PATH . "/includes/topbar.php";
require_once BASE_PATH . "/helpers/functions.php";
require_once BASE_PATH . '/classes/Connection.php';

if (!isset($_SESSION['user'])) {
    redirectPage('../index.php', 3);
} else {
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
                                    } else {
                                        echo "";
                                    }
                                    ?> - Profile Page
                                </h1>
                            </div>
                            <form class="user" method="post" action="">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input readonly type="text" class="form-control" id="first_name" name="first_name" 
                                        placeholder="First Name" value="<?php 
                                        if (isset($_SESSION['user'])) {
                                            echo $_SESSION['user']['FFIRSTNAME']; 
                                        } else {
                                            echo "";
                                        }
                                    ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input readonly type="text" class="form-control" id="last_name" name="last_name" 
                                            placeholder="Last Name" value="<?php 
                                            if (isset($_SESSION['user'])) {
                                                echo $_SESSION['user']['FLASTNAME']; 
                                            } else {
                                                echo "";
                                            }
                                            ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input readonly type="email" class="form-control" id="email" name="email" 
                                        placeholder="Email Address" value="<?php 
                                         if (isset($_SESSION['user'])) {
                                            echo $_SESSION['user']['FEMAIL']; 
                                        } else {
                                            echo "";
                                        }
                                        ?>">
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="phone">Phone Number:</label>
                                        <input readonly type="text" class="form-control" id="phone" name="phone" placeholder="Phone number" value="<?php 
                                        if (isset($_SESSION['user'])) {
                                            echo $_SESSION['user']['FPHONE']; 
                                        } else {
                                            echo "";
                                        }
                                        
                                    ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="address">Address:</label>
                                    <textarea readonly class="form-control" id="address" name="address" placeholder="sesame street, 10012" value="asdasdasd"><?php 
                                        if (isset($_SESSION['user'])) {
                                            echo $_SESSION['user']['FADDRESS']; 
                                        } else {
                                            echo "";
                                        }
                                    ?></textarea>
                                </div>

                                 <a href="/AgriRMS/pages/edit_profile.php" class="btn btn-primary btn-user btn-block" type="submit">Edit
                                </a>
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
?>