<?php include("phytodb_head.php") ?>
<?php
    // Send to log if no session..
	if(!isset($_SESSION['SugarAuth'])){
		?>
        <script language="javascript" type="text/javascript">
			window.location = "log.php";
		</script>
        <?php
	}
?>

<?php
$success = false;
$usrlist = $_POST["usrlist"];
$haspost = $_POST["haspost"];

if( isset($haspost) && $haspost == "commit" ){
    file_put_contents("app/app_member.txt",$usrlist);
    $success = true;
}

?>

</head>
<body>

<div class="pdb_fixedw">
        
        
    <div class="memberspane">
        <h3>Phyto DB Members</h3>
        <p>Enter member accounts below, as [ USERNAME;PASSWORD ], separated a semi-colon ";". <br><em>Each line represents a new member account.</em></p>
        <?php if( $success == true ){ echo '<p class="success">Your changes have been saved.</p>'; } ?>
        <hr>
        <form class="uk-form" action="members.php" name="memberEdit" id="memberEdit" method="post">
        	
            <p>
            <textarea name="usrlist" id="usrlist"><?php echo file_get_contents("app/app_member.txt"); ?></textarea>
            </p>
            
           <p>
            <input type="hidden" name="haspost" id="haspost" value="commit"/>
            </p>
            
            <p><button class="uk-button"><i class="uk-icon-save"></i> Save Updates</button></p>
        </form>
    </div>

</div>

<!-- .end body inc -->
        <footer></footer>

    </body>
</html>
