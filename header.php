<?php

$currentPage = basename($_SERVER['SCRIPT_NAME']);

?>
<!doctype html>
<html lang="en" class="h-100" data-bs-theme="auto">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.122.0">
  <title>GTP Wish</title>
  <link href="./assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./assets/libs/bootstrap-icons/font/bootstrap-icons.min.css">
  <link href="./assets/libs/datatables/datatables.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/custom.css">
  <script src="./assets/jquery.min.js"></script>
  <style>
   .navbar .nav-link.active {
      color: #007bff !important;
      font-weight: bold;
      background-color: #e9f5ff;
      border-radius: 5px;
    }
    .navbar .nav-link:hover {
      color: #0056b3 !important;
    }

    .nav-link.logout {
      color: #ff5722 !important;
    }
  </style>

</head>

<body class="d-flex flex-column h-100">
  
  <header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-light fixed-top bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="/index.php">
          <img src="./images/logo.png" alt="Logo" width="100%" height="50" class="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
          aria-controls="navbarCollapse" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">

            <li class="nav-item"  >
              <a class="nav-link <?=($currentPage=='index.php' || $currentPage=='login.php')?'active':'';?> " href="/index.php" >Home</a>
            </li>

            <?php if(isLoggedIn()){ ?>
              <li class="nav-item">
                <a class="nav-link <?=($currentPage=='give-wish.php')?'active':'';?> " href="/give-wish.php">Give Wish</a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?=($currentPage=='give-wishlist.php')?'active':'';?> " href="/give-wishlist.php">Wish List</a>
              </li>
              <?php if(isAdmin()){ ?>
              <li class="nav-item">
                <a class="nav-link <?=($currentPage=='users.php' || $currentPage=='user-wish.php')?'active':'';?>" href="/users.php">Users</a>
              </li>
              <?php } ?>
              <li class="nav-item">
                <a class="nav-link logout  <?=($currentPage=='logout.php')?'active':'';?>" href="/logout.php">Logout</a>
              </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <!-- Begin page content -->
  <main class="flex-shrink-0">
    <br><br><br><br><br>

    