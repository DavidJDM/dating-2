<?php

session_start();

//Turn on error reporting

ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require autoload
require_once ('vendor/autoload.php');


//Create an instance of the Base class
$f3 = Base::instance();
$f3->set('states', array("Alabama", "Alaska", "Arizona", "Arkansas",
    "California", "Colorado", "Connecticut", "Delaware", "Florida",
    "Georgia", "Hawaii", "Idaho", "Illinois", "Indiana", "Iowa", "Kansas",
    "Kentucky", "Louisiana", "Maine", "Maryland", "Massachusetts",
    "Michigan", "Minnesota", "Mississippi", "Missouri", "Montana",
    "Nebraska", "Nevada", "New Hampshire", "New Jersey", "New Mexico",
    "New York", "North Carolina", "North Dakota", "Ohio", "Oklahoma",
    "Oregon", "Pennsylvania", "Rhode Island", "South Carolina",
    "South Dakota", "Tennessee", "Texas", "Utah", "Vermont", "Virginia",
    "Washington", "West Virginia", "Wisconsin", "Wyoming"));

//Turn of Fat-Free error reporting
$f3->set('DEBUG', 3);

//Validation file
require_once('model/validation-functions.php');


//Define a default route
$f3->route('GET /', function() {

    $_SESSION = array();
    $view = new View;
    echo $view->render('views/home.html');
});

//register route
$f3->route('GET|POST /register', function($f3) {
    $_SESSION['firstName'] = $_POST['firstName'];
    $_SESSION['lastName'] = $_POST['lastName'];
    $_SESSION['age'] = $_POST['age'];
    $_SESSION['gender'] = $_POST['gender'];
    $_SESSION['phone'] = $_POST['phone'];

    if (($_SESSION['firstName']) != "" )
    {
        $f3->reroute('/profile');
    }

    $template = new Template();
    echo $template->render('views/personal-information.html');
});

//profile route
$f3->route('GET|POST /profile', function($f3) {

    $_SESSION['email'] = $_POST['email'];
    $_SESSION['bib'] = $_POST['bib'];
    $_SESSION['state'] = $_POST['state'];
    $_SESSION['seeking'] = $_POST['seeking'];



    if (isset($_SESSION['email']))
    {
        $f3->reroute('/interests');
    }

    $template = new Template();
    echo $template->render('views/profile.html');
});

//interests route
$f3->route('GET|POST /interests', function($f3) {
    $_SESSION['inDoor'] = $_POST['inDoor'];
    $_SESSION['outDoor'] = $_POST['outDoor'];


    if (isset($_SESSION['inDoor']) and isset($_SESSION['outDoor']))
    {
        $f3->reroute('/summary');
    }

    $template = new Template();
    echo $template->render('views/interests.html');
});

//summary route
$f3->route('GET|POST /summary', function($f3) {

    $template = new Template();
    echo $template->render('views/summary.html');


});

//Run fat free
$f3->run();