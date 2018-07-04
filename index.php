<?php 
    session_start();
    if(isset($_GET['action']) && $_GET['action']==="logout"){
        
        session_destroy();
    }
    //TODO: verify logIn user
    if($_SESSION['is_auth']){
        //redirect to login page

        /* Redirect browser */
        header("Location: observations.php");
                
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

            //verify if form data is submited
            if(isset($_POST['username']) && $_POST['username'] != ""){
                $username = $_POST['username'];
                $password = $_POST['passwd'];
                
            
                //get user data with username $username
                $sql = "SELECT * FROM users WHERE users.username=?";
                $q = $con->prepare($sql);
                $q->execute([$username]);

                $user = $q->fetch();

                if($user){
                    
                    //user with username $user existe!
                    //proceed to compare password

                    /*harshed password from database*/ 
                    $password_hashed = $user['password'];
                    
                    /* Compare password entered by user to hashed password from the database */
                    if(password_verify($password, $password_hashed)){
                        //voila! user have entered the correct password
                        
                        session_start();
                        $_SESSION = array();

                        //SET USER DATA TO SESSION
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['is_auth'] = true;

                        //redirect authenticated user to observations page
                        /* Redirect browser */
                        header("Location: observations.php");
                                
                        /* Make sure that code below does not get executed when we redirect. */
                        exit;

                    }else{
                        //Oops! user entered wrong password.
                        //redirect back to login form
                        echo "WRONG PASSWORD";
                    }
                }else{
                    //Oops! user with username $username does not exist!!!
                    //redirect to login form
                    echo "NO USER WITH USERNAME: ".$username;
                }

            

            }else{
                //NO FORM DATA SET: redirect to login page

            }
     
        }else{
            echo "CONNECTION REFUSED . . .";
            echo $con;
        }
    } catch (PDOException $ex) {
        echo "CATICHING . . .";
        echo $ex->getMessage();
    }

?>

<!DOCTYPE html>
<html dir="ltr">

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
    <link href="assets/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="main-wrapper">
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
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center bg-dark">
            <div class="auth-box bg-dark border-top border-secondary">
                <div id="loginform">
                    <div class="text-center p-t-20 p-b-20">
                        <h2>OBSERVATIONS APP</h2>
                    </div>
                    <!-- Form -->
                    <form class="form-horizontal m-t-20" id="loginform" action="index.php" method="POST">
                        <div class="row p-b-30">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white" id="basic-addon1"><i class="ti-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-lg" name="username" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" required="">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-warning text-white" id="basic-addon2"><i class="ti-pencil"></i></span>
                                    </div>
                                    <input type="password" class="form-control form-control-lg" name="passwd" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" required="">
                                </div>
                            </div>
                        </div>
                        <div class="row border-top border-secondary">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="p-t-20">
                                        <button class="btn btn-success float-right" type="submit">Login</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script>

    $('[data-toggle="tooltip"]').tooltip();
    $(".preloader").fadeOut();
    // ============================================================== 
    // Login and Recover Password 
    // ============================================================== 
    $('#to-recover').on("click", function() {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });
    $('#to-login').click(function(){
        
        $("#recoverform").hide();
        $("#loginform").fadeIn();
    });
    </script>

</body>

</html>