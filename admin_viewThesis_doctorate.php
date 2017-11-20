<?php
  require 'dbconnect.php';

  if(isset($_POST['addThesisAuthor']))
  {

    $thesisID = $_POST['add_txtThesisID'];
    $authorLastName = $_POST['add_txtAuthorLastName'];
    $authorFirstName = $_POST['add_txtAuthorFirstName'];
    $authorMiddleInitial = $_POST['add_txtAuthorMiddleInitial'];

    $queryAddThesisAuthor = "INSERT INTO tblProponents(thesis_id, last_name, first_name, middle_initial)
                             VALUES(upper('$thesisID'), '$authorLastName', '$authorFirstName', '$authorMiddleInitial')";
    $queryAddThesisAuthorResult = mysqli_query($conn, $queryAddThesisAuthor);

    header('location: admin_viewThesis_doctorate.php?thesis_id='.$thesisID.'');
  }
  elseif (isset($_POST['addThesisEvaluator'])) {
    $thesisID = $_POST['add_txtThesisID'];
    $evaluatorID = $_POST['add_txtEvaluatorID'];
    $evaluatorLastName = $_POST['add_txtEvaluatorLastName'];
    $evaluatorFirstName = $_POST['add_txtEvaluatorFirstName'];
    $evaluatorMiddleInitial = $_POST['add_txtEvaluatorMiddleInitial'];

    $queryAddEvaluator = "INSERT INTO tblEvaluators(evaluator_id, last_name, first_name, middle_initial)
                             VALUES('$evaluatorID', '$evaluatorLastName', '$evaluatorFirstName', '$evaluatorMiddleInitial')";
    $queryAddEvaluatorResult = mysqli_query($conn, $queryAddEvaluator);

    $queryAddThesisEvaluator = "INSERT INTO tblThesis_Evaluators(evaluator_id, thesis_id)
                                VALUES('$evaluatorID','$thesisID')";
    $queryAddThesisEvaluatorResult = mysqli_query($conn, $queryAddThesisEvaluator);


    header('location: admin_viewThesis_doctorate.php?thesis_id='.$thesisID.'');
  }
   
   $thesisID = $_GET['thesis_id'];

   $queryThesis = "SELECT * FROM tblThesis WHERE thesis_id = '$thesisID'";
   $queryThesisResult =  mysqli_query($conn, $queryThesis);

   $queryThesisAbstract = "SELECT * FROM tblThesis_abstract WHERE thesis_id = '$thesisID'";
   $queryThesisAbstractResult =  mysqli_query($conn, $queryThesisAbstract);

   $queryThesisAuthor = "SELECT * FROM tblProponents WHERE thesis_id='$thesisID'";
   $queryThesisAuthorResult = mysqli_query($conn, $queryThesisAuthor);

   $queryThesisEvaluator = "SELECT * FROM tblThesis_Evaluators WHERE thesis_id = '$thesisID'";
   $queryThesisEvaluatorResult = mysqli_query($conn, $queryThesisEvaluator);

  session_start();

  $userID = $_SESSION['user_id'];

  if(!$userID){
    header("location:index.html");
  }

  $queryLoggedUser = "SELECT * FROM tblUsers WHERE user_id = '$userID'";

  $queryLoggedUserResult = mysqli_query($conn,$queryLoggedUser);

  $rowLoggedUser = mysqli_fetch_array($queryLoggedUserResult);

  $_SESSION['user_id'] = $userID;

  $rowThesis = mysqli_fetch_assoc($queryThesisResult);
  $rowThesisAbstract = mysqli_fetch_assoc($queryThesisAbstractResult);

  function AutoGenerateEvaluatorID() { 

            $s = strtoupper(md5(uniqid(rand(),true)));
 
            $guidText = str_pad('E',8,substr($s,0,9));
     
            return $guidText;
        }
        // End Generate Guid 
        $Guid = AutoGenerateEvaluatorID();

?>

<!DOCTYPE html>
<html>
<script type="text/javascript">

function alphaOnly(e) {
  var code;
  if (!e) var e = window.event;
  if (e.keyCode) code = e.keyCode;
  else if (e.which) code = e.which;
  if ((code >= 48) && (code <= 57)) { return false; }
  return true;
}

</script>
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
           <p style="font-size: 20px;">
            <?php echo $rowLoggedUser['first_name']; echo " "; echo $rowLoggedUser['last_name'];?>
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
        <li class="treeview active">
          <a href="#"><i class="fa fa-book"></i> <span>Theses</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="admin_thesis_undergraduate.php"><i class="fa fa-graduation-cap"></i> Undergraduate</a></li>
            <li><a href="admin_thesis_masteral.php"><i class="fa fa-industry"></i> Masteral</a></li>
            <li class="active"><a href="admin_thesis_doctorate.php"><i class="fa fa-institution"></i> Doctorate</a></li>
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
        <small>Thesis</small>
      </h1>
      <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> Home</li>
        <li class="active">Theses (Masteral)</li>
      </ol>
       <!--ADD THESIS AUTHOR MODAL-->
      <div class="modal fade" id="modal_addAuthor" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    Add a Thesis Author
                </div>
                <div class="modal-body">
                <div class="box-body">
                  <form action="admin_viewThesis_doctorate.php" method="post" enctype="multipart/form-data">
                    <table class="table table-bordered">
                        <tr>
                            <td>Thesis ID</td>
                            <td> 
                              <input type="text" name="add_txtThesisID" class="form-control" value="<?php echo $rowThesis['thesis_id']?>" readonly="readonly">
                            </td>
                        </tr>
                        <tr>
                            <td>Last Name</td>
                            <td>
                                <input type="text" name="add_txtAuthorLastName" class="form-control" required="" onkeypress="return alphaOnly(event);">
                            </td>
                        </tr>
                        <tr>
                            <td>First Name</td>
                            <td>
                              <input type="text" name="add_txtAuthorFirstName" class="form-control" required="" onkeypress="return alphaOnly(event);">
                            </td>
                        </tr>
                        <tr>
                            <td>Middle Initial</td>
                            <td>
                              <input type="text" name="add_txtAuthorMiddleInitial" class="form-control" onkeypress="return alphaOnly(event);">
                            </td>
                        </tr>
                    </table>
                </div>
                </div>
                <div class="modal-footer">
                  <input type="submit" name="addThesisAuthor" value="Add Thesis Author" class=" btn btn-success"> 
                </form>
                </div>
            </div>
        </div>
      </div>
    <!--END ADD THESIS AUTHOR MODAL-->
    <!--ADD THESIS EVALUATOR MODAL-->
    <div class="modal fade" id="modal_addEvaluator" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    Add a Thesis Evaluator
                </div>
                <div class="modal-body">
                <div class="box-body">
                  <form action="admin_viewThesis_doctorate.php" method="post" enctype="multipart/form-data">
                    <table class="table table-bordered">
                        <tr>
                            <td>Thesis ID</td>
                            <td> 
                              <input type="text" name="add_txtThesisID" class="form-control" value="<?php echo $rowThesis['thesis_id']?>" readonly="readonly">
                            </td>
                        </tr>
                        <tr>
                        <tr>
                            <td>Evaluator ID</td>
                            <td> 
                              <input type="text" name="add_txtEvaluatorID" class="form-control" value="<?php echo $Guid?>" readonly="readonly">
                            </td>
                        </tr>
                        <tr>
                            <td>Last Name</td>
                            <td>
                                <input type="text" name="add_txtEvaluatorLastName" class="form-control" required="" onkeypress="return alphaOnly(event);">
                            </td>
                        </tr>
                        <tr>
                            <td>First Name</td>
                            <td>
                              <input type="text" name="add_txtEvaluatorFirstName" class="form-control" required="" onkeypress="return alphaOnly(event);">
                            </td>
                        </tr>
                        <tr>
                            <td>Middle Initial</td>
                            <td>
                              <input type="text" name="add_txtEvaluatorMiddleInitial" class="form-control" onkeypress="return alphaOnly(event);">
                            </td>
                        </tr>
                    </table>
                </div>
                </div>
                <div class="modal-footer">
                  <input type="submit" name="addThesisEvaluator" value="Add Thesis Evaluator" class=" btn btn-success"> 
                </form>
                </div>
            </div>
        </div>
      </div>
    <!--END ADD THESIS EVALUATOR MODAL-->
    <div class="row">
        <div class="col-lg-3">

        </div>
        <div class="col-lg-3">

        </div>
        <div class="col-lg-3 text-right">
                <table>
                    <tr>
                        <td class="text-right">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_addAuthor">Add Thesis Author</button>
                        </td>
                        <td>
                        &nbsp;&nbsp;&nbsp;
                        </td>
                        <td>
                          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_addEvaluator">Add Thesis Evaluator</button>
                        </td>
                    </tr>
                </table>
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
                  Authors:
                  <br>
                  <?php
                    while($rowThesisAuthor = mysqli_fetch_assoc($queryThesisAuthorResult))
                    {
                      echo "<br>".$rowThesisAuthor['last_name'].", ".$rowThesisAuthor['first_name']." ".$rowThesisAuthor['middle_initial'].".";
                    }
                  ?>
                </td>
                <td>
                  Evaluators:
                  <br>
                  <br>
                  <?php
                  while($rowThesisEvaluators = mysqli_fetch_assoc($queryThesisEvaluatorResult))
                  {

                    $queryEvalutors = "SELECT * FROM tblEvaluators WHERE evaluator_id = '".$rowThesisEvaluators['evaluator_id']."'";
                    $queryEvaluatorsResult = mysqli_query($conn, $queryEvalutors);

                    while($rowEvaluators = mysqli_fetch_assoc($queryEvaluatorsResult))
                    {
                      echo $rowEvaluators['first_name']." ".$rowEvaluators['middle_initial'].". ".$rowEvaluators['last_name']."<br>";
                    }
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
