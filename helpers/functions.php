<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

function redirectTo($url) {
    header("Location: " . $url);
    exit;
}

function sanitizeString($var) {
    $var = stripslashes($var);
    $var = htmlentities($var);
    $var = strip_tags($var);
    
    return $var;
}

function isPostRequested() {
    return $_SERVER["REQUEST_METHOD"] == "POST";
}

function isGetRequested() {
    return $_SERVER["REQUEST_METHOD"] == "GET";
}

function redirectPage($destinationURL, $delaySeconds) {
    echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="refresh" content="' . $delaySeconds . ';url=' . $destinationURL . '">
            <title>Redirecting...</title>
        </head>
        <body>
            <div class="container">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                        <!-- Go back (index) -->
                                <div class="float-left mt-4 ml-4">
                                    <p>Redirecting...</p>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        </html>';
}

?>
