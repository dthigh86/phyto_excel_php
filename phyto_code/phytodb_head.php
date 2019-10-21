<?php include("app/app_config.php"); ?>
<?php
// Trigger Session
session_start();

?>
<html>
    <head>
        <title>ASTA Seed Pest Database</title>
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,500,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/phytodb.css" />
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <script src="js/min/phyto-core.js"></script>
    </head>
    <body>

        <!-- Navbar -->
        <nav class="tm-navbar uk-navbar uk-navbar-attached">
            <div class="uk-container uk-container-center pdb_fixedw">

                <a class="uk-navbar-brand" href="index.php">ASTA Seed Pest Database <span>v1.0</span></a>
                <div class="uk-navbar-flip">
                <ul class="uk-navbar-nav">
                    <?php if( @$_SESSION['SugarAuth'] == 'master' ){ ?>
                    <li><a href="members.php"><i class="uk-icon-users "></i> Members</a></li>
                    <li><a href="import.php"><i class="uk-icon-cloud-upload"></i> Import</a></li>
                    <?php } ?>
                    <?php if(isset($_SESSION['SugarAuth'])){ ?>
                    <li><a href="log.php?logout=do" class="logoutbtn"><i class="uk-icon-sign-out"></i> Log Out</a></li>
                    <?php } ?>
                </ul>
                </div>

            </div>
        </nav>