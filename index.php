<?php

session_start();

if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == true)) {

    header('Location: mainmenu.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Budżet Osobisty-Logowanie</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container-fluid text-center">
        <div class="form-group">
            <h1>Twój<br>budżet<br>osobisty</h1>
        </div>
        <div class="form-group">
            <div class="row align-items-center">
                <form action="login.php" method="post">
                    <h2>LOGOWANIE</h2>
                    <div>
                        <p><label for="email"><b>Email</b></label>
                        <input type="email" name="email" id="email" placeholder="user@gmail.com" required>
                    </div>
                    <div>
                        <p><label for="password"><b>Hasło</b></label>
                        <input type="password" name="password" id="password" placeholder="qwerty123" required>
                        <input type="checkbox" onclick="myFunction()" />
                    </div>
                    <input type="submit" value="Zaloguj się" />
                </form>
            </div>
            <b><a href="signup.php">REJESTRACJA - załóż darmowe konto</a></b>
        </div>
    </div>

    <?php
    if (isset($_SESSION['blad']))    echo $_SESSION['blad'];
    $_SESSION['blad']=false;
    ?>

    <script>
            function myFunction() {
                var x = document.getElementById("password");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            }
     </script>
</body>

</html>