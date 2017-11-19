<?php
   include('dbconnect.php');
   if (isset($_POST['addThesis'])) {
    $thesisFile = $_FILES['add_flThesisFile'];
    $thesisAbstract = $_FILES['add_flThesisAbstract'];

    $thesisID = $_POST['add_txtThesisID'];
    $thesisTitle = $_POST['add_txtThesisTitle'];
    $thesisFileType = $_POST['add_thesisFileType'];
    $year = $_POST['add_txtYear'];

    if($year < 2017)
      $thesisStatus = 'ARCHIVED';
    else
      $thesisStatus = 'ACTIVE';

    $thesisFileName = $thesisFile['name'];
    $thesisAbstractName = addslashes(($thesisAbstract['name']));
    $thesisFileTempName = $thesisFile['tmp_name'];
    $thesisAbstractTempName = $thesisAbstract['tmp_name'];
    $thesisAbstractData = addslashes(file_get_contents($thesisAbstractTempName));
    $thesisFileSize = $thesisFile['size'];
    $thesisAbstractSize = $thesisAbstract['size'];
    $thesisFileError =$thesisFile['error'];
    $thesisAbstractError =$thesisAbstract['error'];

    $thesisFileExt = explode('.', $thesisFileName);
    $thesisFileActualExt = strtolower(end($thesisFileExt));
    $thesisAbstractExt = explode('.', $thesisAbstractName);
    $thesisAbstractActualExt = strtolower(end($thesisAbstractExt));

    $allowedThesisFileExt = array('zip','docx','pdf');
    $allowedThesisAbstractExt = array('jpg','jpeg','png');

    if((in_array($thesisFileActualExt, $allowedThesisFileExt)) && (in_array($thesisAbstractActualExt, $allowedThesisAbstractExt)))
    {
      if ($thesisFileError === 0 && $thesisAbstractError ===0) 
      {
        if ($thesisFileSize < 100000000 && $thesisAbstractSize < 100000000)
        {
          $newThesisFileName = $thesisID."file.".$thesisFileActualExt;
          $thesisFileDestination = 'uploadedPictures/'.$newThesisFileName;
          $queryUploadImage = "INSERT INTO tblThesis(thesis_id, thesis_title, year_accomplished, file, file_type,status ) VALUES ('$thesisID','$thesisTitle', $year, '$thesisFileDestination', '$thesisFileType', '$thesisStatus')";
          $uploadImageResult = mysqli_query($conn,$queryUploadImage);
          move_uploaded_file($thesisFileTempName, $thesisFileDestination);

          
          $queryUploadThesisAbstract = "INSERT INTO tblThesis_abstract(thesis_id, image) VALUES('$thesisID','$thesisAbstractData')";
          $uploadThesisAbstractResult = mysqli_query($conn, $queryUploadThesisAbstract);
          header('location: admin_thesis_undergraduate.php');
        }
        else{
        echo "Your file is too big!";
        }

      }
      else {
        echo "You have an Error!";
      }
    }
    else{
      echo "Invalid File Extension!";
    }
  }
  elseif(isset($_POST['search']))
    {
  
      $keyword = $_POST['thesis_titleKeyword'];
      $queryTheses = "SELECT * FROM tblThesis WHERE thesis_title LIKE('%$keyword%') AND status LIKE('ACTIVE')";
      $queryThesesResult = mysqli_query($conn, $queryTheses);

    }
  else
  {
      $queryTheses = "SELECT * FROM tblThesis WHERE status LIKE('ACTIVE')";
      $queryThesesResult = mysqli_query($conn, $queryTheses);
    }

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

  //$_SESSION['user_id'] = $userID;
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
                 <?php echo $rowLoggedUser['last_name']; echo ", "; echo $rowLoggedUser['first_name']; echo $rowLoggedUser['middle_initial']; echo ".";?>
                  <small>Member since December 16, 1991</small>
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
            <?php echo $rowLoggedUser['first_name']."<br>".$rowLoggedUser['last_name']; ?>
          </p>
        </div>
      </div>

      <!-- search form (Optional) -->
      
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
      
        <!-- Optionally, you can add icons to the links -->
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
            <li class="active"><a href="admin_thesis_undergraduate.php"><i class="fa fa-graduation-cap"></i> Undergraduate</a></li>
            <li><a href="admin_thesis_masteral.php"><i class="fa fa-industry"></i> Masteral</a></li>
            <li><a href="admin_thesis_doctorate.php"><i class="fa fa-institution"></i> Doctorate</a></li>
          </ul>
        </li>
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
        Theses
        <small>Undergraduate</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="admin_dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Theses (Undergraduate)</li>
      </ol>
       <!--ADD ADMIN MODAL-->
      <div class="modal fade" id="modal_addThesis" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    Add a Thesis
                </div>
                <div class="modal-body">
                <div class="box-body">
                  <form action="admin_thesis_undergraduate.php" method="post" enctype="multipart/form-data">
                    <table class="table table-bordered">
                        <tr>
                            <td>Thesis ID</td>
                            <td> 
                              <input type="text" name="add_txtThesisID" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td>Thesis Title</td>
                            <td>
                                <input type="text" name="add_txtThesisTitle" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td>Thesis File</td>
                            <td>
                              <input type="file" name="add_flThesisFile">
                            </td>
                        </tr>
                        <tr>
                            <td>Thesis File Type</td>
                            <td>
                              <select name="add_thesisFileType">
                                <option>Original Copy</option>
                                <option>Scanned</option>
                              </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Year Accomplished:</td>
                            <td>
                                <input type="text" name="add_txtYear" class="form-control">
                            </td>
                        </tr>
                        <tr>
                          <td>Thesis Abstract</td>
                          <td><input type="file" name="add_flThesisAbstract"></td>
                        </tr>
                    </table>
                </div>
                </div>
                <div class="modal-footer">
                  <input type="submit" name="addThesis" value="Add Thesis Record" class=" btn sbtn-success"> 
                </form>
                </div>
            </div>
        </div>
      </div>
    <!--END ADD ADMIN MODAL-->
    <div class="row">
        <div class="col-lg-9">

        </div>
        <div class="col-lg-3 text-right">
                <table style="width:100%;">
                    <tr>
                      <td class="text-right" valign="center">
                         Status: &nbsp;
                      </td>
                        <td class="text-right">
                            <select name="ddlStatus">
                              <option selected="selected">Active</option>
                              <option>Archived</option>
                            </select>
                        </td>
                        <td class="text-right">
                            &nbsp;
                            &nbsp;
                            &nbsp;
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_addThesis">Add Thesis</button>
                        </td>
                    </tr>
                </table>
        </div>
    </div>
    <div class="col-lg-6">
      
    </div>
    <div class="col-lg-6 text-right">
      <br>
            <form action="admin_thesis_undergraduate.php" method="post">
                <table style="width:100%;">
                    <tr>
                      <td class="text-right" valign="center" class="form-control">
                         <font style="font-family: sans-serif;">Search Thesis Title</font>&nbsp;&nbsp;
                      </td>
                        <td class="text-right">
                          <input type="text" name="thesis_titleKeyword" class="form-control">
                        </td>
                        <td class="text-right">
                          <input type="submit" name="search" value="Search" class="btn btn-default btn-flat">
                        </td>
                    </tr>
                </table>
              </form>
        </div>
    </section>
    <!-- Main content -->
   <div class="box-body">
      <table class="table table-bordered" style="width:100%;">
              <tr>
                <th>Thesis ID</th>
                <th>Thesis Title</th>
                <th>Year Accomplished</th>
                <th colspan="3">Actions</th>
              </tr>

              <?php
                
                while($rowTheses = mysqli_fetch_array($queryThesesResult))
                {
              ?>

              <tr>
                <td><?php echo $rowTheses['thesis_id']; ?></td>
                <td><?php echo $rowTheses['thesis_title']; ?></td>
                <td><?php echo $rowTheses['year_accomplished']; ?></td>
                <td>
                  <a href="admin_editThesis_undergraduate.php?thesis_id=<?php echo $rowTheses['thesis_id'];?>" class="btn btn-sm btn-warning">Edit</a>
                  <a href="admin_archiveThesis_undergraduate.php?thesis_id=<?php echo $rowTheses['thesis_id'];?>" class="btn btn-sm btn-danger">Archive</a>
                  <a href="admin_viewThesis_undergraduate.php?thesis_id=<?php echo $rowTheses['thesis_id'];?>" class="btn btn-sm btn-success">View</a>
               </td>
               <?php
                }
               ?>
              </tr>
          </table>
   </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
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