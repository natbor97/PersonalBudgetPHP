<?php

session_start();

if (!isset($_SESSION['zalogowany'])) {

    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budżet Osobisty-Dodaj Wydatek</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <nav class="navbar nav-light navbar-expand-md">
        <div class="container-fluid">
            <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#mainmenu" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span> BUDŻET OSOBISTY
            </button>
            <div class="collapse navbar-collapse" id="mainmenu">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="mainmenu.php">Menu główne</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="addincome.php">Dodaj przychód</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="addexpense.php">Dodaj wydatek</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="showbalancefromcurrentmonth.php">Przeglądaj bilans</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="setting.php">Ustawienia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">WYLOGUJ SIĘ</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="text-center">
            <form method="post" action="addingexpense.php">
                <div class="row justify-content-around">
                    <div class="block" id="window">
                        <div class="form-group">
                            <div class="form-group">
                                <h3> DODAJ WYDATEK</h3>
                            </div>
                            <div class="form-group"><br>
                                <label for="expense"><b>KWOTA</b></label>
                                <input type="number" min="0.00" max="100000.00" step="0.01" id="expense" name="expenseAmount" placeholder="0.00" required>
                            </div>
                            <p>

                            <div class="form-group">
                                <label for="date"><b>DATA</b></label>
                                <input type="date" id="date" name="expenseDate">
                            </div>
                            <p>
                                <script>
                                    document.getElementById('date').valueAsDate = new Date();
                                </script>
                            <div class="form-group"><b>SPOSÓB PŁATNOŚCI</b>
                                <select aria-describedby="payment" name="payment">

                                    <?php
                                    require_once "connect.php";
                                    mysqli_report(MYSQLI_REPORT_STRICT);

                                    try {
                                        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

                                        if ($polaczenie->connect_errno != 0) {
                                            throw new Exception(mysqli_connect_errno());
                                        } else {
                                            if ($query_result = $polaczenie->query(sprintf("SELECT * FROM payment_methods_assigned_to_users WHERE user_id='%s'", mysqli_real_escape_string($polaczenie, $_SESSION['id'])))) {
                                                $number_of_payment = $query_result->num_rows;
                                                if ($number_of_payment > 0) {
                                                    while ($payment = $query_result->fetch_assoc()) {
                                                        echo '<option value="' . $payment["id"] . '">' . $payment["name"] . '</option>';
                                                    }
                                                } else {
                                                    $successful_validation = false;
                                                    $_SESSION['e_payment'] = "Nie udało się pobrać sposobów płatności z bazy danych";
                                                }
                                            } else {
                                                throw new Exception($polaczenie->error);
                                            }

                                            $polaczenie->close();
                                        }
                                    } catch (Exception $e) {
                                        echo '<div class="alert alert-danger" role="alert">Błąd serwera! Spróbuj ponownie później!</div>';
                                    }
                                    ?>
                                </select>
                                <p>
                            </div>
                            <p>

                            <div class="form-group">
                                <b>KATEGORIA</b>
                                <select id="cat" name="expenseCategory">

                                    <?php
                                    require_once "connect.php";
                                    mysqli_report(MYSQLI_REPORT_STRICT);

                                    try {
                                        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

                                        if ($polaczenie->connect_errno != 0) {
                                            throw new Exception(mysqli_connect_errno());
                                        } else {
                                            if ($query_result = $polaczenie->query(sprintf("SELECT * FROM expenses_category_assigned_to_users WHERE user_id='%s'", mysqli_real_escape_string($polaczenie, $_SESSION['id'])))) {
                                                $number_of_category = $query_result->num_rows;
                                                if ($number_of_category > 0) {
                                                    while ($expenseCategory = $query_result->fetch_assoc()) {
                                                        echo '<option value="' . $expenseCategory["id"] . '">' . $expenseCategory["name"] . '</option>';
                                                    }
                                                } else {
                                                    $successful_validation = false;
                                                    $_SESSION['e_expenseCategory'] = "Nie udało się pobrać kategorii z bazy danych";
                                                }
                                            } else {
                                                throw new Exception($polaczenie->error);
                                            }

                                            $polaczenie->close();
                                        }
                                    } catch (Exception $e) {
                                        echo '<div class="alert alert-danger" role="alert">Błąd serwera! Spróbuj ponownie później!</div>';
                                    }
                                    ?>
                                </select>
                                <p>

                            </div>

                            <div class="form-group"><b>KOMENTARZ (OPCJONALNIE)</b><br>
                                <textarea id="comment" name="expenseComment" style="resize:both" rows="4"></textarea>
                            </div>
                            <p>
                            <div>
                                <button class="btn btn-primary" id="addExpense">DODAJ WYDATEK</button>
                                <p>
            </form>

            <form method="post" action="mainmenu.php">
                <button class="btn btn-danger">ANULUJ</button>
            </form>
        </div>
        <p>
    </div>
    </div>
    </div>
    </div>

    <?php
    if (isset($_SESSION['blad']))    echo $_SESSION['blad'];
    if (isset($_SESSION['success'])) {
        echo $_SESSION['success'];
        $_SESSION['success']=false;
    }
    ?>
    <script>
        function myFunction() {
            document.getElementById("info").style.display = "none";
        }
    </script>
</body>

</html>