<?php

session_start();

if (isset($_POST['expenseAmount'])) {
    $validation = true;

    $amount = $_POST['expenseAmount'];
    $expenseCategoryId = $_POST['expenseCategory'];
    $date = $_POST['expenseDate'];
    $paymentCategoryId = $_POST['payment'];
    $comment = $_POST['expenseComment'];

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try {
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
        if ($polaczenie->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        } else {
            $loggedUserId = $_SESSION['id'];
            $polaczenie->query("INSERT INTO expenses VALUES (NULL,'$loggedUserId', '$expenseCategoryId','$paymentCategoryId','$amount','$date','$comment')");
            $_SESSION['success'] = '<div class="container-fluid text-center" id="info" style="color:darkred; font-weight:bolder">Wydatek dodano pomyślnie <button onclick="myFunction()">X</button></div>';
            header('Location: addexpense.php');
        }

        $polaczenie->close();
    } catch (Exception $e) {
        echo '<span style="color:red;"> Błąd serwera </span>';
    }
}
?>
