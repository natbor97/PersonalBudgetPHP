<?php

	session_start();

	if ((!isset($_POST['email'])) || (!isset($_POST['password']))) 
	{
		header('Location: index.php');
		exit();
	}

	require_once "connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

	if ($polaczenie->connect_errno != 0) 
	{
		echo "Error: " . $polaczenie->connect_errno;
	} 

	else 
	{
		$email = $_POST['email'];
		$password = $_POST['password'];

		$email = htmlentities($email, ENT_QUOTES, "UTF-8");

		if ($rezultat = @$polaczenie->query(
			sprintf("SELECT * FROM users WHERE email='%s'",
			mysqli_real_escape_string($polaczenie, $email)))) 
		{
			$ilu_userow = $rezultat->num_rows;
			if ($ilu_userow > 0) 
			{
				$wiersz = $rezultat->fetch_assoc();
				if (password_verify($password, $wiersz['password'])) 
				{
					$_SESSION['zalogowany'] = true;
					$_SESSION['id'] = $wiersz['id'];
					$_SESSION['username'] = $wiersz['username'];
					$_SESSION['email'] = $wiersz['email'];

					unset($_SESSION['blad']);
					$rezultat->free_result();
					header('Location: mainmenu.php');
				} 
				else 
				{
					$_SESSION['blad'] = '<div class="container-fluid text-center" style="color:darkred; font-weight:bolder">Nieprawidłowy login lub hasło!</div>';
					header('Location: index.php');
				}
			} 
			else 
			{
				$_SESSION['blad'] = '<div class="container-fluid text-center" style="color:darkred; font-weight:bolder">Nieprawidłowy login lub hasło!</div>';
				header('Location: index.php');
			}
		}
		$polaczenie->close();
	}
?>