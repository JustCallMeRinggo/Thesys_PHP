<?php
  //database connection
  include ('dbconnect.php');

  //logic for adding new administrator
  if(isset($_POST['add_userAdmin']))
  {
    $userID = $_POST['add_txtUserID'];
    $password = $_POST['add_txtPassword'];
    $lastName = $_POST['add_txtLastName'];
    $firstName = $_POST['add_txtFirstName'];
    $middleInitial = $_POST['add_txtMiddleInitial'];
    $userType = 'ADMINISTRATOR';
    $status = 'ACTIVE';

    //query for adding new record in tblUsers
    $queryAddUserAdmin = "INSERT INTO tblUsers(user_id, last_name, first_name, middle_initial, user_type, status)
                          VALUES(upper('$userID'), upper('$lastName'), upper('$firstName'), upper('$middleInitial'), '$userType', '$status')";

    //query for adding new record in tblPasswords
    $queryAddUserPassword = "INSERT INTO tblPasswords(user_id, password) VALUES(upper('$userID'), '$password')";

    $queryAddUserAdminResult = mysqli_query($conn, $queryAddUserAdmin);
    $queryAddUserPasswordResult = mysqli_query($conn, $queryAddUserPassword);
  }

    $queryAdmins = "SELECT * FROM tblUsers WHERE user_type LIKE('%admin%') AND status LIKE('active')";
    $queryAdminsResult = mysqli_query($conn, $queryAdmins);
?>

<?php
  //start of session
  session_start();

  //variable for session
  $userID = $_SESSION['user_id'];

  //checks whether a user account is logged in or not
  if(!$userID)
  {
      header('location: index.html');
  }

  //query for retrieving records of the logged in user
  $queryLoggedUser = "SELECT * FROM tblUsers WHERE user_id = '$userID'";
  $queryLoggedUserResult = mysqli_query($conn, $queryLoggedUser);

  //fetching of result of queryUserResult
  $rowLoggedUser = mysqli_fetch_assoc($queryLoggedUserResult);
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
  <title>Thesys | Users (Admin)</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
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
    <a href="index2.html" class="logo">
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
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                <p>
                  
             </p>
              </li>
              <!-- Menu Body -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <!--<input type="submit" name="" class="btn btn-default btn-flat"></a>-->
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
              <?php echo $rowLoggedUser['first_name']; ?>
              <br>
              <?php echo " "; echo $rowLoggedUser['last_name'];?>
          </p>
        </div>
      </div>

      <!-- search form (Optional) -->
      
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li><a href="admin_dashboard.php"><i class="fa fa-th"></i> <span>Dashboard</span></a></li>
        <li class="treeview active">
          <a href="#"><i class="fa fa-users"></i> <span>Users</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="admin_users_admin.php"> <i class="fa fa-user-secret"></i> Administrators</a></li>
            <li><a href="admin_users_faculty.php"><i class="fa fa-user"></i> Faculty</a></li>
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
        </li>
        <li><a href="admin_requests.php"><i class="fa fa-th"></i> <span>Requests</span></a></li>
      </ul>

      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="input content-header">
      <h1>
        Users
        <small>Administrators</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Users (Administrator)</li>
      </ol>
    <!--ADD ADMIN MODAL-->
    <div class="modal fade" id="modal_addThesis">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    Add New Administrator
                </div>
                <div class="modal-body">
                <div class="box-body">
                  <form action="admin_users_admin.php" method="post">
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
                        <tr class="modal-footer">
                            <td>
                               <input type="submit" name="add_userAdmin" class="btn btn-default btn-flat" value="Add Admin">
                          
                            </td>
                        </tr>
                    </table>
                  </form>
                </div>
                </div>
            </div>
        </div>
      </div>
    <!--END ADD ADMIN MODAL-->
    <div class="row">
        <div class="col-lg-9">

        </div>
        <div class="col-lg-3text-right">
                <table>
                    <tr>
                      <td>
                         Status:&nbsp;&nbsp;
                      </td>
                      <td>
                            <select name="ddlStatus">
                              <option selected="selected">Active</option>
                              <option>Inactive</option>
                            </select>&nbsp;&nbsp;
                      </td>
                      <td>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_addThesis"> Add New Admin</button>
  
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
                //displaying of records retrieved from the database
                while( $rowAdmins = mysqli_fetch_array($queryAdminsResult))
                {
                  $i = 1;
              ?>

              <tr>
                <td ><?php echo $rowAdmins['user_id']; ?></td>
                <td><?php echo $rowAdmins['last_name']; ?></td>
                <td><?php echo $rowAdmins['first_name']; ?></td>
                <td><?php echo $rowAdmins['middle_initial']; ?></td>
                <td></td>
                <td>
                  <a href="admin_users_editAdmin.php?user_id=<?php echo $rowAdmins['user_id']?>" class="btn btn-sm btn-warning">Edit</a>
                  <a href="admin_users_deactivateAdmin.php?user_id=<?php echo $rowAdmins['user_id']?>" class="btn btn-sm btn-danger">Deactivate</a>
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


  <!-- Main Footer -->

  <!-- Control Sidebar -->
  
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