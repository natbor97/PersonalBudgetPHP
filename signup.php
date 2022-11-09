<?php

session_start();

if (isset($_POST['email'])) 
{
    $validation = true;

    $username = $_POST['username'];

    $email = $_POST['email'];
    $emailGood = filter_var($email, FILTER_SANITIZE_EMAIL);

    if ((filter_var($emailGood, FILTER_VALIDATE_EMAIL) == false) || ($emailGood != $email)) 
    {
        $validation = false;
        $_SESSION['e_email'] = "Podaj poprawny adres e-mail!";
    }

    $password = $_POST['password'];
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $_SESSION['fr_username'] = $username;
    $_SESSION['fr_email'] = $email;
    $_SESSION['fr_password'] = $password;

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try 
    {
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
        if ($polaczenie->connect_errno != 0) 
        {
            throw new Exception(mysqli_connect_errno());
        } 
        
        else 
        {
            $rezultat = $polaczenie->query("SELECT id FROM users WHERE email='$email'");

            if (!$rezultat) throw new Exception($polaczenie->error);

            $ile_maili = $rezultat->num_rows;

            if ($ile_maili > 0) 
            {
                $validation = false;
                $_SESSION['e_email'] = '<span style="color:darkred; font-weight:bolder">Istnieje już konto przypisane do tego adresu email</span>';
            }

            if ($validation == true) 
            {
                if ($polaczenie->query("INSERT INTO users VALUES (NULL, '$username', '$password_hash', '$email')"))
                { 
                    $_SESSION['udanarejestracja'] = true;
                    header('Location: good.php');

                    $idQuery = "SELECT id FROM users WHERE email = '$email'";
						$idQueryResult = mysqli_query($polaczenie, $idQuery);
						$rowRegisteredUserId = mysqli_fetch_assoc($idQueryResult);
						$registeredUserId = $rowRegisteredUserId['id'];


						$incomeCategoryQuery = "SELECT name FROM incomes_category_default";
						$incomeCategoryResult = mysqli_query($polaczenie, $incomeCategoryQuery);
						$incomeCategoryRecords = mysqli_num_rows($incomeCategoryResult);
						
						for ($i = 1; $i <= $incomeCategoryRecords; $i++) {
                
							$rowIncomeCategory = mysqli_fetch_assoc($incomeCategoryResult);
							$incomeCategoryName = $rowIncomeCategory['name'];
							$polaczenie->query("INSERT INTO incomes_category_assigned_to_users VALUES (NULL,'$registeredUserId','$incomeCategoryName')");
						}


						$expenseCategoryQuery = "SELECT name FROM expenses_category_default";
						$expenseCategoryResult = mysqli_query($polaczenie, $expenseCategoryQuery);
						$expenseCategoryRecords = mysqli_num_rows($expenseCategoryResult);
						
						for ($i = 1; $i <= $expenseCategoryRecords; $i++) {
                
							$rowExpenseCategory = mysqli_fetch_assoc($expenseCategoryResult);
							$expenseCategoryName = $rowExpenseCategory['name'];
							$polaczenie->query("INSERT INTO expenses_category_assigned_to_users VALUES (NULL,'$registeredUserId','$expenseCategoryName')");
						}


						$paymentMethodQuery = "SELECT name FROM payment_methods_default";
						$paymentMethodResult = mysqli_query($polaczenie, $paymentMethodQuery);
						$paymentMethodRecords = mysqli_num_rows($paymentMethodResult);
						
						for ($i = 1; $i <= $paymentMethodRecords; $i++) {
                
							$rowPaymentMethod = mysqli_fetch_assoc($paymentMethodResult);
							$paymentMethodName = $rowPaymentMethod['name'];
							$polaczenie->query("INSERT INTO payment_methods_assigned_to_users VALUES (NULL,'$registeredUserId','$paymentMethodName')");
						}
                }
                
                else 
                {
                    throw new Exception($polaczenie->error);
                }

            }
            $polaczenie->close();
        }
    }
    
    catch (Exception $e) 
    {
        echo '<span style="color:red;"> Błąd serwera </span>';
    }
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Budżet Osobisty-Rejestracja</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form method="post">
        <div class="container-fluid text-center">
            <div class="form-group">
                <h1>Twój<br>budżet<br>osobisty</h1>
            </div>
            <div class="form-group">
                <div class="row align-items-stretch">

                    <h2>REJESTRACJA</h2>
                    <div>
                        <p><label for="name"><b>Imię</b></label>
                        <input type="text" name="username" id="name" placeholder="Jan" required>
                    </div>
                    <div>
                        <p><label for="email"><b>Email</b></label>
                        <input type="email" id="email" placeholder="user@gmail.com" value="
                        <?php
                            if (isset($_SESSION['fr_email'])) {
                                echo $_SESSION['fr_email'];
                                unset($_SESSION['fr_email']);
                            }
                            ?>" name="email" /><br />
                        <?php
                        if (isset($_SESSION['e_email'])) {
                            echo '<div class="error">' . $_SESSION['e_email'] . '</div>';
                            unset($_SESSION['e_email']);
                        }
                        ?>
                    </div>

                    <div>
                        <p><label for="password"><b>Hasło</b></label>
                        <input type="password" id="password" placeholder="qwerty123" value="<?php
                            if (isset($_SESSION['fr_password'])) {
                                echo $_SESSION['fr_password'];
                                unset($_SESSION['fr_password']);
                            } 
                            ?>" name="password" />

                        <?php
                        if (isset($_SESSION['e_password'])) {
                            echo '<div class="error">' . $_SESSION['e_password'].'</div>';
                            unset($_SESSION['e_password']);
                        }
                        ?>
                        <input type="checkbox" onclick="myFunction()"/>
                    </div>
                    <div>
                        <input type="submit" value="Zarejestruj się" />
                    </div>
                    <b><a href="index.php">Masz już konto?- ZALOGUJ SIĘ!</a></b>
                </div>
            </div>
        </div>
        </form>
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