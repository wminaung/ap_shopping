 <?php
    if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in']) && empty($_SESSION['role'])) {
        header("location: login.php");
        exit();
    }
    if ($_SESSION['role'] != 1) {
        header("Location: ../login.php");
        exit();
    }
    ?>

 <!DOCTYPE html>
 <!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
 <html lang="en">

 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <meta http-equiv="x-ua-compatible" content="ie=edge">

     <title>Some | stater</title>

     <!-- Font Awesome Icons -->
     <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
     <!-- Theme style -->
     <link rel="stylesheet" href="dist/css/adminlte.min.css">
     <!-- Google Font: Source Sans Pro -->
     <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
 </head>

 <body class="hold-transition sidebar-mini">
     <div class="wrapper">

         <!-- Navbar -->
         <nav class="main-header navbar navbar-expand navbar-white navbar-light">
             <!-- Left navbar links -->
             <ul class="navbar-nav">
                 <li class="nav-item">
                     <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                 </li>

             </ul>

             <!-- SEARCH FORM -->
             <?php
                $link = $_SERVER['PHP_SELF'];
                $link_array = explode('/', $link);
                $page = end($link_array);
                ?>
             <?php
                if ($page == 'index.php' || $page == 'category.php' || $page == 'user_list.php') {
                ?>
                 <?php
                    if ($page != 'order_list.php' and $page != 'order_detail.php') {
                    ?>
                     <form class="form-inline ml-3" method="post" <?php if ($page == 'index.php') : ?> action="index.php" <?php elseif ($page == 'category.php') : ?> action="category.php" <?php elseif ($page == 'user_list.php') : ?> action="user_list.php" <?php endif; ?>>
                         <input type="hidden" name="_token" value="<?php echo !empty($_SESSION['_token']) ? $_SESSION['_token'] : '' ?>">
                         <div class="input-group input-group-sm">
                             <input name="search" class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                             <div class="input-group-append">
                                 <button class="btn btn-navbar" type="submit">
                                     <i class="fas fa-search"></i>
                                 </button>
                             </div>
                         </div>
                     </form>
                 <?php
                    }
                    ?>
             <?php
                }
                ?>


             <!-- Right navbar links -->
             <ul class="navbar-nav ml-auto">



             </ul>
         </nav>
         <!-- /.navbar -->

         <!-- Main Sidebar Container -->
         <aside class="main-sidebar sidebar-dark-primary elevation-4">
             <!-- Brand Logo -->
             <a href="index3.html" class="brand-link">
                 <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                 <span class="brand-text font-weight-light">Ap Shop Panel</span>
             </a>

             <!-- Sidebar -->
             <div class="sidebar">
                 <!-- Sidebar user panel (optional) -->
                 <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                     <div class="image">
                         <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                     </div>
                     <div class="info">
                         <a href="#" class="d-block"><?php echo $_SESSION['user_name'] ?></a>
                     </div>
                 </div>

                 <!-- Sidebar Menu -->
                 <nav class="mt-2">
                     <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                         <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                         <li class="nav-item">
                             <a href="index.php" class="nav-link">
                                 <i class="nav-icon fas fa-th"></i>
                                 <p>
                                     Product
                                 </p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="category.php" class="nav-link">
                                 <i class="nav-icon fas fa-list"></i>
                                 <p>
                                     Category
                                 </p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="user_list.php" class="nav-link">
                                 <i class="nav-icon fas fa-user"></i>
                                 <p>
                                     User
                                 </p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="order_list.php" class="nav-link">
                                 <i class="nav-icon fas fa-table"></i>
                                 <p>
                                     Order
                                 </p>
                             </a>
                         </li>
                     </ul>
                 </nav>
                 <!-- /.sidebar-menu -->
             </div>
             <!-- /.sidebar -->
         </aside>

         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
             <!-- Content Header (Page header) -->
             <div class="content-header">
                 <div class="container-fluid">

                 </div><!-- /.container-fluid -->
             </div>
             <!-- /.content-header -->