<?php
  include ('dbconnect.php');
   //logic for adding new administrator
  if(isset($_POST['add_userStudent']))
  {
    $userID = $_POST['add_txtUserID'];
    $password = md5($_POST['add_txtPassword']);
    $lastName = $_POST['add_txtLastName'];
    $firstName = $_POST['add_txtFirstName'];
    $middleInitial = $_POST['add_txtMiddleInitial'];
    $expDate = 'date_sub(date(now()), INTERVAL -1 MONTH)';
    $userType = 'STUDENT';
    $status = 'ACTIVE';

    //query for adding new record in tblUsers
    $queryAddUserStudent = "INSERT INTO tblUsers(user_id, last_name, first_name, middle_initial, exp_date, user_type, status)
                          VALUES(upper('$userID'), upper('$lastName'), upper('$firstName'), upper('$middleInitial'), $expDate,'$userType', '$status')";

    //query for adding new record in tblPasswords
    $queryAddUserStudentPassword = "INSERT INTO tblPasswords(user_id, password) VALUES(upper('$userID'), '$password')";

    $queryAddUserStudentResult = mysqli_query($conn, $queryAddUserStudent);
    $queryAddUserStudentPasswordResult = mysqli_query($conn, $queryAddUserStudentPassword);
  }

    $queryStudents = "SELECT * FROM tblUsers WHERE user_type LIKE('STUDENT') AND status LIKE('active')";
    $queryStudentsResult = mysqli_query($conn, $queryStudents);
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
  <title>Thesys | Users (Student)</title>
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
            <li><a href="admin_users_faculty.php"><i class="fa fa-user"></i> Faculty</a></li>
            <li class="active"><a href="admin_users_student.php"><i class="fa fa-users"></i> Students</a></li>
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
        <small>Students</small>
      </h1>
      <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i>Home</li>
        <li class="active">Users (Students)</li>
      </ol>
      <!--ADD ADMIN MODAL-->
      <div class="modal fade" id="modal_addStudent" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    Add New Student Record
                </div>
                <div class="modal-body">
                <div class="box-body">
                  <form action="admin_users_student.php" method="post">
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
                        </tr>
                    </table>
                </div>
                </div>
                <div class="modal-footer">
                  <input type="submit" name="add_userStudent" value="Add Student" class="btn btn-default btn-flat">
              </form>
                </div>
            </div>
        </div>
      </div>
    <!--END ADD ADMIN MODAL-->
    <div class="row">
        <div class="col-lg-8">

        </div>
        <div class="col-lg-3">
                <table style="width:100%;">
                    <tr>
                      <td>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      </td>
                      <td>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      </td>
                      <td>
                         Status
                      </td>
                      <td>&nbsp;&nbsp;&nbsp;</td>
                      <td>

                            <select name="ddlStatus">
                              <option selected="selected">Active</option>
                              <option>Inactive</option>
                            </select>
                      </td>
                      <td>&nbsp;&nbsp;&nbsp;</td>
                      <td>
                          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_addStudent">Add New Student</button>
                      </td>
                    </tr>
                </table>
        </div>
    </div>
    </section>
    <!-- Main content -->
   <div class="box-body">
     <table class="table table-bordered" style="width:100%;">
              <tr>
                <th>User ID</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Middle Initial</th>
                <th>Actions</th>
              </tr>

              <?php

                while($rowStudents = mysqli_fetch_array($queryStudentsResult))
                {
                  $i = 1;
              ?>

              <tr>
                <td><?php echo $rowStudents['user_id']; ?></td>
                <td><?php echo $rowStudents['last_name']; ?></td>
                <td><?php echo $rowStudents['first_name']; ?></td>
                <td><?php echo $rowStudents['middle_initial']; ?></td>
                <td><?php echo $rowStudents['exp_date']?></td>
                <td>
                  <a href="admin_users_editStudent.php?user_id=<?php echo$rowStudents['user_id']?>" class="btn btn-sm btn-warning">EDIT</a>
                  <a href="admin_users_deactivateStudent.php?user_id=<?php echo$rowStudents['user_id']?>" class="btn btn-sm btn-danger">DEACTIVATE</a>
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