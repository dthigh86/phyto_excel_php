<?php include("phytodb_head.php") ?>
<!-- .end head inc -->

<?php
// ------------------------------------------------------------------
// LOGOUT 
// ------------------------------------------------------------------
	$logOutDo = $_GET["logout"];
	if($logOutDo){
		session_destroy();
	}
	
	// Send to index if logged..
	if(isset($_SESSION['SugarAuth'])){
		?>
        <script language="javascript" type="text/javascript">
			window.location = "index.php";
		</script>
        <?php
	}

// ------------------------------------------------------------------
// LOGIN
// ------------------------------------------------------------------
$usrname = trim($_POST["uname"]);
$usrpass = trim($_POST["upass"]);
$hasPost = $_POST["haspost"];
$logPass = false;

if( isset($usrname) && isset($usrpass) ){
	//$Logerror = true;	// Error true by default
    $logErrMsg = "Your User Name or Password is incorrect. Please try again.";
    $isMaster = false;

    /** IS Master User **/
    if( $usrname == $masterDBUser && $usrpass == $masterDBPass ){
        // Is Master
        $logPass = true;
        //$Logerror = false;
        $isMaster = true;
        //$logPass = verify_member($usrname, $usrpass);
        
    } elseif( $usrname == $roDBUser && $usrpass == $roDBPass ) {
        //Is Read Only
        $logPass = true;
        $isReadOnly = true;
        
    } else {
        // Verify On User List
        $logPass = verify_member($usrname, $usrpass);
        
    }
    
	if($logPass == true){
		
		// Session Role
            if( $isMaster == true ){
                $usrRoleAuth = 'master';
            } elseif( $isReadOnly == true ) {
                $usrRoleAuth = 'readonly';
            } else {
			    $usrRoleAuth = 'member';
            }
			$_SESSION['SugarAuth'] = $usrRoleAuth;
        
			
        // Redirect to index
			?>
			<script language="javascript" type="text/javascript">
				window.location = "index.php";
			</script>
			<?php
	
	}
	
}

?>

</head>
<body>

<div class="pdb_fixedw">    
        
    <div class="loginpane">
        <h3>User Log In</h3>

        <?php if( $logPass==false && isset($hasPost) ){ ?>
        <p class="error_alert" ><?= $logErrMsg; ?></p>
        <?php } ?>
        
        <form class="uk-form" action="log.php" name="logIn" id="logIn" method="post">
        	
            <p><label for="uname">User Name<br />
            <input type="text" id="uname" name="uname" style="width:248px;"/>
            </label></p>
            
            <p><label for="upass">Password<br />
            <input type="password" id="upass" name="upass" style="width:248px;"/>
                </label>
            
            <input type="hidden" name="haspost" id="haspost" value="commit"/>
            </p>
            
            <p><button class="uk-button"><i class="uk-icon-lock"></i> Log In</button></p>
        </form>
    </div>

</div>

<!-- .end body inc -->
        <footer></footer>

    </body>
</html>
