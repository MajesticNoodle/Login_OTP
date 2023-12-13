<?php 
session_start();
include("inc/header.php");
if(!isset($_SESSION["user"])){
 header("location:index.php");
}
?>
<title>webdamn.com : Demo Login System with OTP using PHP & MySQL</title>
<?php include('inc/container.php');?>
<div class="container">	
	<div class="col-md-12">   
	<h2>Example: Login System with OTP using PHP & MySQL</h2>	
	</div>
	<div class="col-md-6">                    
	<h3>Welcome - <?php echo $_SESSION["user"]; ?></h3>
	<br />
	<p><a href="logout.php">Logout</a></p>	                    
	</div> 	
</div>	
<?php include('inc/footer.php');?>




  