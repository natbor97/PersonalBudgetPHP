<?php
    session_start();

    if (!isset($_SESSION['zalogowany'])) {
		header('Location: loginandsignup.php');
		exit();
    }

    $currentdate = date('Y-m');

    $_SESSION['start_date'] = $currentdate."-01";
    $_SESSION['end_date'] = $currentdate."-31";

    header('Location: showbalance.php');
?>