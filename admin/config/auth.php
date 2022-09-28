<?php 

session_start();

if (empty($_SESSION['user_id']) and empty($_SESSION['user_name']) and empty($_SESSION['user_role']) and empty($_SESSION['logged_in'])) {
  header("Location: login.php");

}

if ($_SESSION['user_role'] != 1) {
	header("Location: login.php");
}