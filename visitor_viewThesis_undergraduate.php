<?php
  require('dbconnect.php');
  
   $thesisID = $_GET['thesis_id'];

   $queryThesis = "SELECT * FROM tblThesis WHERE thesis_id = '$thesisID'";
   $queryThesisResult =  mysqli_query($conn, $queryThesis);

   $queryThesisAbstract = "SELECT * FROM tblThesis_abstract WHERE thesis_id = '$thesisID'";
   $queryThesisAbstractResult =  mysqli_query($conn, $queryThesisAbstract);

   $queryThesisAuthor = "SELECT * FROM tblProponents WHERE thesis_id='$thesisID'";
   $queryThesisAuthorResult = mysqli_query($conn, $queryThesisAuthor);

   $queryThesisEvaluator = "SELECT * FROM tblEvaluators WHERE thesis_id = '$thesisID'";
   $queryThesisEvaluatorResult = mysqli_query($conn, $queryThesisEvaluator);

  session_start();

  $userID = $_SESSION['user_id'];
  if(!$userID){
    header("location:index.html");
  }
  $queryUser = "SELECT * FROM tblUsers WHERE user_id = '$userID'";

  $queryResult = mysqli_query($conn,$queryUser);

  $rowLoggedUser = mysqli_fetch_array($queryResult);

  $_SESSION['user_id'] = $userID;

  $rowThesis = mysqli_fetch_assoc($queryThesisResult);
  $rowThesisAbstract = mysqli_fetch_assoc($queryThesisAbstractResult);

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Thesys | Theses (Undergraduate)</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  
  <link rel="stylesheet" href="dist/css/skins/skin-green-light.min.css">


  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-green-light sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="visitor_dashboard.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
       <span class="logo-mini"><b>T</b>SYS</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>THE</b>SYS</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
  
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
             
              <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $rowLoggedUser['user_type'];?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                <p>
                  <?php echo $rowLoggedUser['last_name'].", ";?>
                  <?php echo $rowLoggedUser['first_name']." ";?>
                  <?php echo $rowLoggedUser['middle_initial'].".";?>
             </p>
              </li>
              <!-- Menu Body -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <!--<input type="submit" name="" class="btn btn-default btn-flat"></a>-->
                </div>
                <div class="pull-right">
                  <a href="logout.php" class="btn btn-default btn-flat" >Sign Out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>
            <br>
            <?php echo $rowLoggedUser['first_name']."<br>".$rowLoggedUser['last_name'];?>
          </p>
          <!-- Status -->
         
        </div>
      </div>

      <!-- search form (Optional) -->
      
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
      
        <!-- Optionally, you can add icons to the links -->
        <li><a href="visitor_dashboard.php"><i class="fa fa-th"></i> <span>Dashboard</span></a></li>
        <li class="treeview active">

          <a href="#"><i class="fa fa-book"></i> <span>Theses</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
           <li class="active"><a href="visitor_thesis_undergraduate.php"><i class="fa fa-graduation-cap"></i> Undergraduate</a></li>
            <li><a href="visitor_thesis_masteral.php"><i class="fa fa-industry"></i> Masteral</a></li>
            <li><a href="visitor_thesis_doctorate.php"><i class="fa fa-institution"></i> Doctorate</a></li>
          </ul>

          <li><a href="faculty_requests.php"><i class="fa fa-th"></i> <span>Requests</span></a></li>
        </li>
      </ul>

      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Theses
        <small>Undergraduate</small>
      </h1>
      <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i>Level</li>
        <li class="active">Faculty</li>
      </ol>
      <div class="row">
        <div class="col-lg-9">
          
        </div>
        <div class="col-lg-6">
          
        </div>
      </div>
    </section>


    <!-- Main content -->
     <div class="box-body">
     <table class="table table-bordered">
              <tr>
                <th colspan="4"><center><h3>Thesis Details</h3></center></th>
              </tr>
              <tr>
                <td rowspan="5" align="center"><img src="data:image/jpeg;base64,<?php echo base64_encode($rowThesisAbstract['image']) ?>" height="400" width="300">
                </td>
                <th>Title:</th>
                <td>
                  <?php echo $rowThesis['thesis_title']; ?>
                </td>
              </tr>
              <tr>
                <th>
                  Year Accomplished:
                </th>
                <td>
                   <?php echo $rowThesis['year_accomplished']?>
                </td>
              </tr>
              <tr>
                <td>
                  <b>Authors:</b>
                  <br>
                  <?php
                    while($rowThesisAuthor = mysqli_fetch_assoc($queryThesisAuthorResult))
                    {
                      echo "<br>".$rowThesisAuthor['last_name'].", ".$rowThesisAuthor['first_name']." ".$rowThesisAuthor['middle_initial'].".";
                    }
                  ?>
                </td>
                <td>
                  <b>Evaluators:</b>
                  <br>
                  <?php
                  while($rowThesisEvaluators = mysqli_fetch_assoc($queryThesisEvaluatorResult))
                  {
                    echo "<br>".$rowThesisEvaluators['last_name'].", ".$rowThesisEvaluators['first_name']." ".$rowThesisEvaluators['middle_initial'].".";
                  }

                  ?>
                </td>
              </tr>
              <tr>
              </tr>
          </table>
   </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>