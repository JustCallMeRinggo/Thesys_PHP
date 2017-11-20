<?php
  //database connection
  include ('dbconnect.php');


  //logic for adding new administrator
  if(isset($_POST['edit_thesisMasteral']))
  {
    $thesisIDtoEdit = $_POST['edit_txtThesisID'];
    $thesisTitleToEdit = $_POST['edit_txtThesisTitle'];
    $thesisFileToEdit = $_FILES['edit_flThesisFile'];
    $thesisYearToEdit = $_POST['edit_txtThesisYear'];
    $thesisAbstractToEdit = $_FILES['edit_flThesisAbstract'];

    $thesisFileName = $thesisFileToEdit['name'];
    $thesisFileTempName = $thesisFileToEdit['tmp_name'];
    $thesisFileSize = $thesisFileToEdit['size'];
    $thesisFileError =$thesisFileToEdit['error'];

    $thesisAbstractName = addslashes(($thesisAbstractToEdit['name']));
    $thesisAbstractTempName = $thesisAbstractToEdit['tmp_name'];
    $thesisAbstractData = addslashes(file_get_contents($thesisAbstractTempName));
    $thesisAbstractSize = $thesisAbstractToEdit['size'];
    $thesisAbstractError =$thesisAbstractToEdit['error'];

    $thesisFileExt = explode('.', $thesisFileName);
    $thesisFileActualExt = strtolower(end($thesisFileExt));

    $thesisAbstractExt = explode('.', $thesisAbstractName);
    $thesisAbstractActualExt = strtolower(end($thesisAbstractExt));

    $allowedThesisFileExt = array('zip','docx','pdf');
    $allowedThesisAbstractExt = array('jpg','jpeg','png');

    if(is_null($thesisFileToEdit) && is_null($thesisAbstractToEdit))
    {
      $queryUpdateThesisMasteral = "UPDATE tblThesis SET thesis_title = '$thesisTitleToEdit', year_accomplished = '$thesisYearToEdit' WHERE thesis_id = '$thesisIDtoEdit'";
      $queryUpdateThesisMasteralResult = mysqli_query($conn, $queryUpdateThesisMasteral);

      header('location: admin_thesis_masteral.php');
    }
    elseif (!is_null($thesisFileToEdit) && is_null($thesisAbstractToEdit)) {

      if(in_array($thesisFileActualExt, $allowedThesisFileExt))
      {
        if($thesisFileError === 0)
        {
          if($thesisFileSize < 100000000)
          {
            $newThesisFileName = $thesisID."file.".$thesisFileActualExt;
            $thesisFileDestination = 'uploadedPictures/'.$newThesisFileName;
            $queryUpdateThesisMasteral = "UPDATE tblThesis SET thesis_title = '$thesisTitleToEdit', year_accomplished = '$thesisYearToEdit', file = '$thesisFileDestination' WHERE thesis_id = '$thesisIDtoEdit'";
            $queryUpdateThesisMasteralResult = mysqli_query($conn, $queryUpdateThesisMasteral);
            move_uploaded_file($thesisFileTempName, $thesisFileDestination);

            header('location: admmin_thesis_masteral.php');
          }
          else
            ?>
        <script type="text/javascript">
          alert('Your File is Too Big!');

        </script>
      <?php
      echo"<script>location.assign('admin_editThesis_masteral.php')</script>";
        }
        else
          ?>
        <script type="text/javascript">
          alert('You Have an Error!');

        </script>
      <?php
      echo"<script>location.assign('admin_editThesis_masteral.php')</script>";
      }
      else
        ?>
        <script type="text/javascript">
          alert('Invalid File Extension!');

        </script>
      <?php
      echo"<script>location.assign('admin_editThesis_masteral.php')</script>";
    }
    elseif (is_null($thesisFileToEdit) && !is_null($thesisAbstractToEdit)) {
      if(in_array($thesisAbstractActualExt, $allowedThesisAbstractExt))
      {
        if($thesisAbstractError === 0)
        {
          if($thesisAbstractSize < 100000000)
          {
            $queryUpdateThesisMasteral = "UPDATE tblThesis SET thesis_title = '$thesisTitleToEdit', year_accomplished = '$thesisYearToEdit' WHERE thesis_id = '$thesisIDtoEdit'";
            $queryUpdateThesisMasteralResult = mysqli_query($conn, $queryUpdateThesisMasteral);

            $queryUpdateThesisAbstract = "UPDATE tblThesis_abstract SET image = '$thesisAbstractData' WHERE thesis_id = '$thesisIDtoEdit'";
            $queryUpdateThesisAbstractResult = mysqli_query($conn, $queryUpdatedThesisAbstract);

            header('location: admmin_thesis_masteral.php');
          }
          else
            ?>
        <script type="text/javascript">
          alert('Your File is Too Big!');

        </script>
      <?php
      echo"<script>location.assign('admin_editThesis_masteral.php')</script>";
        }
        else
          ?>
        <script type="text/javascript">
          alert('You Have an Error!');

        </script>
      <?php
      echo"<script>location.assign('admin_editThesis_masteral.php')</script>";
      }
      else
        ?>
        <script type="text/javascript">
          alert('Invalid File Extension!');

        </script>
      <?php
      echo"<script>location.assign('admin_editThesis_masteral.php')</script>";
    }

  }
    $thesisIDtoBeEdited = $_GET['thesis_id'];
    $queryThesisToEdit = "SELECT * FROM tblThesis WHERE thesis_id = '$thesisIDtoBeEdited'";
    $queryThesisToEditResult = mysqli_query($conn, $queryThesisToEdit);

    $queryThesisAbstractToEdit = "SELECT * FROM tblThesis_abstract WHERE thesis_id = '$thesisIDtoBeEdited'";
    $queryThesisAbstractToEditResult = mysqli_query($conn, $queryThesisAbstractToEdit);

    $rowThesisToEdit = mysqli_fetch_array($queryThesisToEditResult);
    $rowThesisAbstractToEdit = mysqli_fetch_array($queryThesisAbstractToEditResult);

  session_start();

  $userID = $_SESSION['user_id'];
  if(!$userID){
    header("location:index.html");
  }
  $queryLoggedUser = "SELECT * FROM tblUsers WHERE user_id = '$userID'";

  $queryLoggedUserResult = mysqli_query($conn,$queryLoggedUser);

  $rowLoggedUser = mysqli_fetch_array($queryLoggedUserResult);

  $_SESSION['user_id'] = $userID;


?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Thesys | Dashboard (Admin)</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-green-light sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="admin_dashboard.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>T</b>SYS</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>THE</b>SYS</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
             
              <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $rowLoggedUser['user_type'];?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                <p>
                  <?php echo $rowLoggedUser['last_name']; echo ", "; echo $rowLoggedUser['first_name']; echo " "; echo $rowLoggedUser['middle_initial']; echo "."; ?>
                </p>
              </li>
              <!-- Menu Body -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                 
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
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <br>
           <p>
            <?php echo $rowLoggedUser['first_name']."<br>".$rowLoggedUser['last_name'];?>
          </p>
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
       <li><a href="admin_dashboard.php"><i class="fa fa-th"></i> <span>Dashboard</span></a></li>
        <li class="treeview">
          <a href="#"><i class="fa fa-users"></i> <span>Users</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
        
          <ul class="treeview-menu">
            <li><a href="admin_users_admin.php"> <i class="fa fa-user-secret"></i> Administrators</a></li>
            <li><a href="admin_users_faculty.php"><i class="fa fa-user"></i> Faculty</a></li>
            <li><a href="admin_users_student.php"><i class="fa fa-users"></i> Students</a></li>
            <li><a href="admin_users_visitors.php"><i class="fa fa-question-circle"></i> Visitors</a></li>
          </ul>
        </li>
        <li class="treeview active active">
          <a href="#"><i class="fa fa-book"></i> <span>Theses</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="admin_thesis_undergraduate.php"><i class="fa fa-graduation-cap"></i> Undergraduate</a></li>
            <li class="active"><a href="admin_thesis_masteral.php"><i class="fa fa-industry"></i> Masteral</a></li>
            <li><a href="admin_thesis_doctorate.php"><i class="fa fa-institution"></i> Doctorate</a></li>
          </ul>

          <li><a href="admin_requests.php"><i class="fa fa-th"></i> <span>Requests</span></a></li>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administrator
        <small>Edit Thesis</small>
      </h1>
      <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> Home</li>
        <li class="active">Theses (Masteral)</li>
      </ol>
    </section>
 <!-- Main content -->
   <br>
    <br>
    <div class="col-lg-6">
      <form action="admin_editThesis_masteral.php" method="post">
            <table class="table table-bordered" align="center">
              <tr>
                <td>Thesis ID</td>
                <td>
                  <input type="text" name="edit_txThesisID" class="form-control" value="<?php echo $rowThesisToEdit['thesis_id']; ?>" readonly="readonly">
                </td>
              </tr>
              <tr>
                <td>Thesis Title</td>
                <td>
                  <input type="text" name="edit_txtThesisTitle" class="form-control" required="" value="<?php echo $rowThesisToEdit['thesis_title']; ?>">
                </td>
              </tr>
              <tr>
                <td>Thesis File (.pdf/.docx/.zip)</td>
                <td>
                  <input type="file" name="edit_flThesisFile" required="">
                </td>
              </tr>
              <tr>
                <td>Year Accomplished</td>
                <td>
                  <input type="text" name="edit_txtThesisYear" class="form-control" required="" value="<?php echo $rowThesisToEdit['year_accomplished']; ?>">
                </td>
              </tr>
              <tr>
                <td>Thesis Abstract (.jpg/.jpeg/.png)</td>
                <td>
                  <input type="file" name="edit_flThesisAbstract" required="">
                </td>
                <td>
                  <img src="data:image/jpeg;base64,<?php echo base64_encode($rowThesisAbstractToEdit['image']) ?>" height="100" width="100">
                </td>
              </tr>
              <tr>
              </tr>
              <tr>
                <td colspan="2">
                  
                </td>
                <td class="text-right" colspan="3">
                  <input type="submit" name="edit_thesisMasteral" value="Edit Thesis Record" class="btn btn-default btn-flat">
                </td>
              </tr>
          </table>
        </form>
    </div>
    <!-- /.content -->
  </div>

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="bower_components/raphael/raphael.min.js"></script>
<script src="bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
