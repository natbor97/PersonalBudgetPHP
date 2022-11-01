<?php

session_start();

if (isset($_POST['incomeAmount'])) {
    $validation = true;

    $amount = $_POST['incomeAmount'];
    $incomeCategoryId = $_POST['incomeCategory'];
    $date = $_POST['incomeDate'];
    $comment = $_POST['incomeComment'];

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try {
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
        if ($polaczenie->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        } else {
            $loggedUserId = $_SESSION['id'];
            
            $polaczenie->query("INSERT INTO incomes VALUES (NULL,'$loggedUserId', '$incomeCategoryId','$amount','$date','$comment')");
            $_SESSION['success'] = '<div class="container-fluid text-center" id="info" style="color:darkred; font-weight:bolder">Przychód dodano pomyślnie <button onclick="myFunction()">X</button></div>';
            header('Location: addincome.php');
        }

        $polaczenie->close();
    } catch (Exception $e) {
        echo '<span style="color:red;"> Błąd serwera </span>';
    }
}
?>