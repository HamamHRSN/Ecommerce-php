<?php

// if (!isset($noNavbar)) { include $tpl . 'navbar.php'; }

  session_start();  // Starts The Session

  session_unset(); // Unset The Data 

  session_destroy(); // Destroy the Session 

  header('Location: indexAdmin.php');

  exit();