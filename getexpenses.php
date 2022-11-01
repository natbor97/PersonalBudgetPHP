<?php
  if (!isset($_SESSION['zalogowany'])) {
    header('Location: loginandsignup.php');
		exit();
  }

  require_once "connect.php";
  mysqli_report(MYSQLI_REPORT_STRICT);
                           
  try {
    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
                            
    if ($polaczenie->connect_errno!=0) {
      throw new Exception(mysqli_connect_errno());
    }
    else {
      $get_expenses = "SELECT e.expense_comment, ( SELECT c.name FROM expenses_category_assigned_to_users AS c WHERE c.id = e.expense_category_assigned_to_user_id ) AS category, ( SELECT p.name FROM payment_methods_assigned_to_users AS p WHERE p.id = e.payment_method_assigned_to_user_id ) AS payment, e.date_of_expense, e.amount FROM expenses AS e WHERE (e.date_of_expense BETWEEN '$start_date' AND '$end_date') AND user_id = '$loggedUserId' ";
                    
      if ($query_result = $polaczenie->query("$get_expenses")) {
        $number_of_expenses = $query_result->num_rows;
        if($number_of_expenses > 0) {
          while($expenses = $query_result->fetch_assoc()) {
            echo '<tr><td>'.$expenses["category"].'</td><td>'.$expenses["payment"].'</td><td>'.$expenses["date_of_expense"].'</td><td>'.$expenses["expense_comment"].'</td><td>'.$expenses["amount"];
          }
        }
      }
      else {
        throw new Exception($polaczenie->error);
      }

      $get_sum_of_expenses = "SELECT SUM(amount) AS sum_of_expenses FROM expenses WHERE (date_of_expense BETWEEN '$start_date' AND '$end_date') AND user_id = '$loggedUserId'";

      if ($query_result = $polaczenie->query("$get_sum_of_expenses")) {
        $sum_of_expenses = $query_result->fetch_assoc();
        echo '<tr><td colspan="3"><td><b>RAZEM</b></td><td id="totalexpenses">'.$sum_of_expenses["sum_of_expenses"].'</td></tr>';
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