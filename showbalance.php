<?php

session_start();

if (!isset($_SESSION['zalogowany'])) {

  header('Location: loginandsignup.php');
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Personal Budget</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Montserrat&amp;subset=latin-ext" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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

  <div class="container-fluid text-center">
    <button id="choice" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#myCollapse">Okres
    </button>
    <div class="collapse navbar-collapse container-fluid" id="myCollapse">
      <ul class="navbar-nav mx-auto">
        <li>
          <form action="showbalancefromcurrentmonth.php" method="post">
            <button>Bieżący miesiąc</button>
          </form>
        </li>
        <li>
          <form action="showbalancefrompreviousmonth.php" method="post">
            <button>Poprzedni miesiąc</button>
          </form>
        </li>
        <li>
          <form action="showbalancefromcurrentyear.php" method="post">
            <button>Bieżący rok</button>
          </form>
        </li>
        <li>
          <button type="button" data-bs-toggle="modal" data-bs-target="#myModal">Niestandardowe</button>
        </li>
        <li role="separator" class="divider"></li>
      </ul>
    </div>
  </div>
  <br>

  <div class="container-fluid text-center" id="window">
    <div><br>
      <h4 class="text-center">
        Bilans przychodów i wydatków z okresu od:
        <?php
        echo $_SESSION['start_date'];
        ?>
        do:
        <?php
        echo $_SESSION['end_date'];

        ?>
      </h4>
      <hr />
      <table class="table table-striped bg-white" id="table-incomes">
        <h3>PRZYCHODY</h3>
        <thead>
          <tr>
            <th>Kategoria</th>
            <th>Data</th>
            <th>Komentarz</th>
            <th>Kwota</th>
          </tr>
        </thead>
        <tbody>
          <?php
          require_once "getincomes.php";
          ?>
        </tbody>
      </table>

      <div id="piechartincomes"></div>

      <table class="table table-striped bg-white" id="table-expenses">
        <h3>WYDATKI</h3>
        <thead>
          <tr>
            <th>Kategoria</th>
            <th>Sposób płatności</th>
            <th>Data</th>
            <th>Komentarz</th>
            <th>Kwota</th>
          </tr>
        </thead>
        <tbody>
          <?php
          require_once "getexpenses.php";
          ?>
        </tbody>
      </table>
      <hr />
      <div id="piechartexpenses"></div>
      <div class="text-center" id="summary"></div><br>
      <div class="container-fluid" id="comment"></div><br>
    </div>
  </div>

  <!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <h4 class="modal-title">Wybierz okres</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form method="post">
            Data początkowa:
            <input type="date" name="start_date" class="form-control">

            Data końcowa:
            <input type="date" name="end_date" class="form-control">
            <p>

            <div class="text-center">
              <button type="submit" class="btn btn-primary">Zatwierdź</button>
          </form>
          <a href="showbalance.php"><button type="button" class="btn btn-danger">Anuluj</button></a>
        </div>
      </div>
    </div>
  </div>
  </div>

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

  <script type="text/javascript" src="js/balance.js"></script>
</body>

</html>