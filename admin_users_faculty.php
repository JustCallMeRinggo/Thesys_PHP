<?php
  include ('dbconnect.php');
  //logic for adding new administrator
  if(isset($_POST['add_userFaculty']))
  {
    $userID = $_POST['add_txtUserID'];
    $password = $_POST['add_txtPassword'];
    $lastName = $_POST['add_txtLastName'];
    $firstName = $_POST['add_txtFirstName'];
    $middleInitial = $_POST['add_txtMiddleInitial'];
    $userType = 'FACULTY';
    $status = 'ACTIVE';

    //query for adding new record in tblUsers
    $queryAddUserFaculty = "INSERT INTO tblUsers(user_id, last_name, first_name, middle_initial, user_type, status)
                          VALUES(upper('$userID'), upper('$lastName'), upper('$firstName'), upper('$middleInitial'), '$userType', '$status')";

    //query for adding new record in tblPasswords
    $queryAddUserFacultyPassword = "INSERT INTO tblPasswords(user_id, password) VALUES(upper('$userID'), '$password')";

    $queryAddUserFacultyResult = mysqli_query($conn, $queryAddUserFaculty);
    $queryAddUserFacultyPasswordResult = mysqli_query($conn, $queryAddUserFacultyPassword);
  }

     $queryFaculty = "SELECT * FROM tblUsers WHERE user_type LIKE('%faculty%') AND status LIKE('active')";
     $queryFacultyResult = mysqli_query($conn, $queryFaculty);
?>

<?php
  session_start();

  $userID = $_SESSION['user_id'];


  //checks whether a user account is logged in or not
  if(!$userID)
  {
      header('location: index.html');
  }

  $queryLoggedUser = "SELECT * FROM tblUsers WHERE user_id = '$userID'";
  $queryLoggedUserResult = mysqli_query($conn, $queryLoggedUser);

  //fetching of result of queryUserResult

  $rowLoggedUser = mysqli_fetch_assoc($queryLoggedUserResult);

  //preparation of session ID for next landing page

  $_SESSION['user_id'] = $userID;
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
  <title>Thesys | Users (Faculty)</title>
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
    <a href="admin_dashboard.php" class="logo">
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
              <!-- The user image in the navbar-->
              <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"><?php echo $rowLoggedUser['user_type'];?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                   <?php echo $rowLoggedUser['last_name']; echo ", "; echo $rowLoggedUser['first_name']; echo" "; echo $rowLoggedUser['middle_initial']; echo ".";?>
                </p>
              </li>

              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  
                </div>
                <div class="pull-right">
                  <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
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
          <br>
          <p>
            <?php echo $rowLoggedUser['first_name']."<br>".$rowLoggedUser['last_name'];?>
          </p>
        </div>
      </div>

      <!-- search form (Optional) -->
      
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
      
        <!-- Optionally, you can add icons to the links -->
        <li><a href="admin_dashboard.php"><i class="fa fa-th"></i> <span>Dashboard</span></a></li>
        <li class="treeview active">
          <a href="#"><i class="fa fa-users"></i> <span>Users</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="admin_users_admin.php"> <i class="fa fa-user-secret"></i> Administrators</a></li>
            <li class="active"><a href="admin_users_faculty.php"><i class="fa fa-user"></i> Faculty</a></li>
            <li><a href="admin_users_student.php"><i class="fa fa-users"></i> Students</a></li>
            <li><a href="admin_users_visitors.php"><i class="fa fa-question-circle"></i> Visitors</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-book"></i> <span>Theses</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
           <li><a href="admin_thesis_undergraduate.php"><i class="fa fa-graduation-cap"></i> Undergraduate</a></li>
            <li><a href="admin_thesis_masteral.php"><i class="fa fa-industry"></i> Masteral</a></li>
            <li><a href="admin_thesis_doctorate.php"><i class="fa fa-institution"></i> Doctorate</a></li>
          </ul>

          <li><a href="admin_requests.php"><i class="fa fa-th"></i> <span>Requests</span></a></li>
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
        Users
        <small>Faculty</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Users (Faculty)</li>
      </ol>
    <!--ADD ADMIN MODAL-->
    <div class="modal fade" id="modal_addFaculty" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    Add New Faculty
                </div>
                <div class="modal-body">
                <div class="box-body">
                  <form action="admin_users_faculty.php" method="post">
                    <table class="table table-bordered">
                        <tr>
                            <td>User ID</td>
                            <td> 
                              <input type="text" name="add_txtUserID" class="form-control" required="" style="text-transform: uppercase;">
                            </td>
                        </tr>
                        <tr>
                          <td>Password</td>
                          <td>
                            <input type="text" name="add_txtPassword" class="form-control" required="">
                          </td>
                        </tr>
                        <tr>
                            <td>Last Name</td>
                            <td>
                                <input type="text" name="add_txtLastName" class="form-control" onkeypress="return alphaOnly(event);" required="" style="text-transform: uppercase;">
                            </td>
                        </tr>
                        <tr>
                            <td>First Name</td>
                            <td>
                              <input type="text" name="add_txtFirstName" class="form-control" onkeypress="return alphaOnly(event);" required="" style="text-transform: uppercase;">
                            </td>
                        </tr>
                        <tr>
                            <td>Middle Initial</td>
                            <td>
                                <input type="text" name="add_txtMiddleInitial" class="form-control" onkeypress="return alphaOnly(event);" style="text-transform: uppercase;">
                            </td>
                        </tr>
                    </table>
                </div>
                </div>
                <div class="modal-footer">
                  <input type="submit" name="add_userFaculty" class="btn btn-default btn btn-flat" value="Add Faculty">
              </form>
                </div>
            </div>
        </div>
      </div>
    <!--END ADD ADMIN MODAL-->
    <div class="row">
        <div class="col-lg-12">

        </div>
        <div class="col-lg-6">
          
        </div>
        <div class="col-lg-6 text-right">
                <table>
                    <tr>
                      <td>
                         Status:&nbsp
                      </td>
                      <td>
                            <select name="ddlStatus">
                              <option selected="selected">Active</option>
                              <option>Inactive</option>
                            </select>&nbsp;&nbsp;
                      </td>
                      <td>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_addFaculty">Add New Faculty</button>
                      </td>
                    </tr>
                </table>
        </div>
    </div>
    </section>
    <div class="box-body">
            <table class="table table-bordered" style="width:100%;">
              <tr>
                <th>User ID</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Middle Initial</th>
                <th>Expiry Date</th>
                <th>Actions</th>
              </tr>

              <?php

                while( $rowFaculty = mysqli_fetch_array($queryFacultyResult))
                {
                  $i = 1;
              ?>

              <tr>
                <td><?php echo $rowFaculty['user_id']; ?></td>
                <td><?php echo $rowFaculty['last_name']; ?></td>
                <td><?php echo $rowFaculty['first_name']; ?></td>
                <td><?php echo $rowFaculty['middle_initial']; ?></td>
                <td><?php echo $rowFaculty['exp_date']?></td>
              <!--
                Ang mga button sa ibaba ay isama sa loob ng loop kapag nag-retrieve na ng records galing database
              -->
                <td>
                  <a href="admin_users_editFaculty.php?user_id=<?php echo $rowFaculty['user_id']; ?>" class="btn btn-sm btn-warning">EDIT</a>
                  <a href="admin_users_deactivateFaculty.php?user_id=<?php echo $rowFaculty['user_id']; ?>" class="btn btn-sm btn-danger">DEACTIVATE</a>
               </td>
               <?php
                $i++;
                }
               ?>
              </tr>
          </table>
    </div>
  
    <!-- /.content -->
    </div>
  <!-- /.content-wrapper -->

   <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>