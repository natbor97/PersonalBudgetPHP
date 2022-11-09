<?php
    session_start();

    if (!isset($_SESSION['zalogowany'])) {
		header('Location: index.php');
		exit();
    }

    $_SESSION['start_date'] = $_POST['start_date'];
    $_SESSION['end_date'] = $_POST['end_date'];
   
    header('Location: showbalance.php');
?>