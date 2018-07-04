<?php 
    session_start();

    if(!$_SESSION['is_auth']){
        //redirect to login page

        /* Redirect browser */
        header("Location: index.php");
                
        /* Make sure that code below does not get executed when we redirect. */
        exit;
    }

    // Include the database class:
    include("./include/connection.php");

    // create new database connection and fetch observations:
    try {
 
        $conec = new Connection();
        $con   = $conec->Open();
        if ($con) {
            //verify if a delete action is requested
            if(isset($_GET['action']) && $_GET['action'] === "delete"){

                if(isset($_GET['id'])){
                    //retrive observation id from request parameter
                    $observation_id = $_GET['id'];

                    //delete observation with id $observation_id from database
                    $sql = "DELETE FROM observations WHERE observations.id=".$observation_id;
                    $con->exec($sql);

                    /* Redirect browser */
                    header("Location: observations.php");
                    
                    /* Make sure that code below does not get executed when we redirect. */
                    exit;
                }else{
                    //NO OBSERVATION ID: redirect to observation page

                    /* Redirect browser */
                    header("Location: observations.php");
                    
                    /* Make sure that code below does not get executed when we redirect. */
                    exit;
                }

            }else{
                //NO DELETE ACTION: continue to retrive observations

                $sql = "SELECT observations.id AS id, observations.observation AS observation, observations.specie AS specie, observations.gps_coord1 AS gps_coord1, observations.gps_coord2 AS gps_coord2, observations.created_on AS created_on, users.id AS observer_id, users.username AS observer FROM observations, users WHERE observations.user_id=users.id";
                $q  = $con->query($sql);
                $q->setFetchMode(PDO::FETCH_ASSOC);
            }
     
        } else {
            echo $con;
        }
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }

?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title>Observation App</title>
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="assets/extra-libs/multicheck/multicheck.css">
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="assets/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="observations.php" role="button">
                             OBSERVATIONS 
                            </a>
                            
                        </li>
                        
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">
                        
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['username']; ?></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated">
                                
                                <a class="dropdown-item" href="index.php?action=logout"><i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
                                
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Observations</h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active" aria-current="page"><a href="observaions.php">Observations</a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    List of Observations
                                    <a href="add-observation.php" class="btn btn-xs btn-info pull-right">
                                    Add Observation
                                    </a>
                                </h5>
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>OBSERVATION</th>
                                                <th>GPS COORDINATE 1</th>
                                                <th>GPS COORDINATE 2</th>
                                                <th>SPECIE</th>
                                                <th>OBSERVER</th>
                                                <th>POSTED ON</th>
                                                <th>ACTION </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             <?php while ($observation = $q->fetch()):?>
                                            <tr>
                                                <td><?php echo $observation['observation']; ?></td>
                                                <td><?php echo $observation['gps_coord1']; ?></td>
                                                <td><?php echo $observation['gps_coord2']; ?></td>
                                                <td><?php echo $observation['specie']; ?></td>
                                                <td><?php echo $observation['observer']; ?></td>
                                                <td><?php echo $observation['created_on']; ?></td>
                                                <td>
                                                    <!-- SHOW ACTION BUTTONS ONLY FOR USER'S OBSERVATIONS -->
                                                    <?php if($observation['observer_id'] === $_SESSION['user_id']):?>
                                                        <!-- Edit button-->
                                                        <a href="<?php echo 'edit-observation.php?action=edit&id='. $observation['id']; ?>" class="btn btn-info">
                                                            Edit
                                                        </a>

                                                        <!-- Delete Button -->
                                                        <a href="<?php echo 'observations.php?action=delete&id='. $observation['id']; ?>" class="btn btn-danger">
                                                            Delete
                                                        </a>
                                                    <?php endif;?>
                                                </td>
                                            </tr>
                                            <?php endwhile;?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>OBSERVATION</th>
                                                <th>GPS COORDINATE 1</th>
                                                <th>GPS COORDINATE 2</th>
                                                <th>SPECIE</th>
                                                <th>OBSERVER</th>
                                                <th>POSTED ON</th>
                                                <th>ACTION </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                OBSERVATIONS App.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="assets/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="assets/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="assets/js/custom.min.js"></script>
    <!-- this page js -->
    <script src="assets/extra-libs/multicheck/datatable-checkbox-init.js"></script>
    <script src="assets/extra-libs/multicheck/jquery.multicheck.js"></script>
    <script src="assets/extra-libs/DataTables/datatables.min.js"></script>
    <script>
        /****************************************
         *       Basic Table                   *
         ****************************************/
        $('#zero_config').DataTable();
    </script>

</body>

</html>