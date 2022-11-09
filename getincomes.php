<?php
  if (!isset($_SESSION['zalogowany'])) {
    header('Location: index.php');
		exit();
  }

  require_once "connect.php";
  mysqli_report(MYSQLI_REPORT_STRICT);
    
  if (!isset($_SESSION['start_date'])) {
    $_SESSION['start_date'] = "1970-01-01";
    $_SESSION['end_date'] = $currentdate = date('Y-m-d');
  }
                        
  try {
    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
                      
    if ($polaczenie->connect_errno!=0) {
      throw new Exception(mysqli_connect_errno());
    }
    else {
      $start_date = mysqli_real_escape_string($polaczenie, $_SESSION['start_date']);
      $end_date = mysqli_real_escape_string($polaczenie, $_SESSION['end_date']);
      $loggedUserId = mysqli_real_escape_string($polaczenie, $_SESSION['id']);
      $get_incomes = "SELECT i.income_comment, ( SELECT c.name FROM incomes_category_assigned_to_users AS c WHERE c.id = i.income_category_assigned_to_user_id ) AS category, i.date_of_income, i.amount FROM incomes AS i WHERE (i.date_of_income BETWEEN '$start_date' AND '$end_date') AND user_id = '$loggedUserId' ";
                        
      if ($query_result = $polaczenie->query("$get_incomes")) {
        $number_of_incomes = $query_result->num_rows;
        if($number_of_incomes > 0) {
          while($incomes = $query_result->fetch_assoc()) {
            echo '<tr><td>'.$incomes["category"].'</td><td>'.$incomes["date_of_income"].'</td><td>'.$incomes["income_comment"].'</td><td>'.$incomes["amount"];
          }
        }
      }
      else {
        throw new Exception($polaczenie->error);
      }
      
      $get_sum_of_incomes = "SELECT SUM(amount) AS sum_of_incomes FROM incomes WHERE (date_of_income BETWEEN '$start_date' AND '$end_date') AND user_id = '$loggedUserId'";
        
      if ($query_result = $polaczenie->query("$get_sum_of_incomes")) {
        $sum_of_incomes = $query_result->fetch_assoc();
        echo '<tr><td colspan="2"><td><b>RAZEM</b></td><td id="totalincomes">'.$sum_of_incomes["sum_of_incomes"].'</td></tr>';
      }
      else {                  
        throw new Exception($polaczenie->error);
      }

      $polaczenie->close();
    }
  }                
  catch(Exception $e) {
    echo '<div class="error text-center">Błąd serwera! Spróbuj ponownie później!</div>';
  }
?>