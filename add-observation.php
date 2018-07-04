<?php 
    session_start();
    //TODO: verify logIn user
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
            //verify if a POST action is requested from form submission
            if(isset($_POST['user_id']) && $_POST['user_id'] > 0){
                $observer = $_POST['user_id'];
                $specie = $_POST['specie'];
                $observation = $_POST['observation'];
                $gps_coord1 = $_POST['gps_coord1'];
                $gps_coord2 = $_POST['gps_coord2'];

                $sql = "INSERT INTO `observations`(`observation`, `specie`, `gps_coord1`, `gps_coord2`, `created_on`, `user_id`) VALUES (:ob, :sp, :gps1, :gps2, :co, :us)";
                // prepare statement for execution
                $q = $con->prepare($sql);

                // pass values to the query and execute it
                $q->execute([
                    'ob' => $observation,
                    'sp' => $specie,
                    'gps1' => $gps_coord1,
                    'gps2' => $gps_coord2,
                    'co' => date('Y-m-d H:i:s'),
                    'us' => $observer
                ]);

                
                /* Redirect browser */
                header("Location: observations.php");
                
                /* Make sure that code below does not get executed when we redirect. */
                exit;
            }else{
                //NO DELETE ACTION: continue to display the form
            }
     
        } else {
            echo "CONNECTION REFUSED . . .";
            echo $con;
        }
    } catch (PDOException $ex) {
        echo "CATICHING . . .";
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
    <link rel="stylesheet" type="text/css" href="assets/libs/select2/dist/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="assets/libs/jquery-minicolors/jquery.minicolors.css">
    <link rel="stylesheet" type="text/css" href="assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" type="text/css" href="assets/libs/quill/dist/quill.snow.css">
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
                                <li class="breadcrumb-item"><a href="observations.php">Observations</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Add New</li>
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
                    <div class="col-md-12">
                        <div class="card">
                            <form action="add-observation.php" method="POST" class="form-horizontal">
                                <div class="card-body">
                                    <h5 class="card-title">Add New Observation</h5>
                                    <div class="form-group row">
                                        <label class="col-sm-3 text-right control-label col-form-label">Select Specie</label>
                                        <div class="col-md-9">
                                            <select class="select2 form-control custom-select" name="specie" style="width: 100%; height:36px;">
                                                <option>Select</option>
                                                <optgroup label="Zone 1">
                                                    <option value="Abalone">Abalone</option>
                                                    <option value="Barnacle">Barnacle</option>
                                                    <option value="Cuttlefish">Cuttlefish</option>
                                                </optgroup>
                                                <optgroup label="Zone 2">
													<option value="Abalone">Abalone</option>
                                                    <option value="Barnacle">Barnacle</option>
                                                    <option value="Cuttlefish">Cuttlefish</option>
                                                </optgroup>
                                                <optgroup label="Zone 3">
                                                
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="cono1" class="col-sm-3 text-right control-label col-form-label">Your Observation: </label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="observation"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="cono1" class="col-sm-3 text-right control-label col-form-label">GPS Coordinate 1:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="gps_coord1" id="gps_coord1" placeholder="Enter coordinate here">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="cono1" class="col-sm-3 text-right control-label col-form-label">GPS Coordinate 2:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="gps_coord2" id="gps_coord2" placeholder="Enter coordinate here">
                                        </div>
                                    </div>
                                    
                                    <!-- embed LOGIN USER ID as hidden field -->
                                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']?$_SESSION['user_id']:1; ?>">

                                </div>
                                <div class="border-top">
                                    <div class="card-body">
                                        <button type="submit" class="btn btn-primary"> <i class="fa fa-plus"></i> Submit</button>
                                    </div>
                                </div>
                            </form>
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
    <!-- This Page JS -->
    <script src="assets/libs/inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
    <script src="assets/js/pages/mask/mask.init.js"></script>
    <script src="assets/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="assets/libs/select2/dist/js/select2.min.js"></script>
    <script src="assets/libs/jquery-asColor/dist/jquery-asColor.min.js"></script>
    <script src="assets/libs/jquery-asGradient/dist/jquery-asGradient.js"></script>
    <script src="assets/libs/jquery-asColorPicker/dist/jquery-asColorPicker.min.js"></script>
    <script src="assets/libs/jquery-minicolors/jquery.minicolors.min.js"></script>
    <script src="assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="assets/libs/quill/dist/quill.min.js"></script>
    <script>
        //***********************************//
        // For select 2
        //***********************************//
        $(".select2").select2();

        /*colorpicker*/
        $('.demo').each(function() {
        //
        // Dear reader, it's actually very easy to initialize MiniColors. For example:
        //
        //  $(selector).minicolors();
        //
        // The way I've done it below is just for the demo, so don't get confused
        // by it. Also, data- attributes aren't supported at this time...they're
        // only used for this demo.
        //
        $(this).minicolors({
                control: $(this).attr('data-control') || 'hue',
                position: $(this).attr('data-position') || 'bottom left',

                change: function(value, opacity) {
                    if (!value) return;
                    if (opacity) value += ', ' + opacity;
                    if (typeof console === 'object') {
                        console.log(value);
                    }
                },
                theme: 'bootstrap'
            });

        });
        /*datwpicker*/
        jQuery('.mydatepicker').datepicker();
        jQuery('#datepicker-autoclose').datepicker({
            autoclose: true,
            todayHighlight: true
        });
        var quill = new Quill('#editor', {
            theme: 'snow'
        });

    </script>
</body>

</html>