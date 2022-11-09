<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Budżet Osobisty-Menu Główne</title>
</head>

<body>
    <div class="container-fluid text-center">
        <div class="form-group">
            <h1>MENU<br>GŁÓWNE</h1>
        </div>
        <div class="form-group">
            <form action="addincome.php" method="post">
                <p><button class="menubutton">DODAJ PRZYCHÓD</button>
            </form>
        </div>

        <div class="form-group">
            <form action="addexpense.php" method="post">
                <p><button class="menubutton">DODAJ WYDATEK</button>
            </form>
        </div>

        <div class="form-group">
            <form action="showbalancefromcurrentmonth.php" method="post">
                <p><button class="menubutton">PRZEGLĄDAJ BILANS</button>
            </form>
        </div>

        <div class="form-group">
            <form action="setting.php" method="post">
                <p><button class="menubutton">USTAWIENIA</button>
            </form>
        </div>

        <div class="form-group">
            <form action="logout.php">
                <button class="menubutton">WYLOGUJ SIĘ</button>
            </form>
        </div>
    </div>

</body>
</html>