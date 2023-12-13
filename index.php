<?php 
session_start();
include("inc/header.php");
include_once("inc/db_connect.php");
$errorMessage = '';
if(!empty($_POST["login"]) && $_POST["email"]!=''&& $_POST["loginPass"]!='') {	
	$email = $_POST['email'];
	$password = $_POST['loginPass'];
	$password = md5($password);
	$sqlQuery = "SELECT username FROM members WHERE email='".$email."' AND password='".$password."'";
	$resultSet = mysqli_query($conn, $sqlQuery) or die("database error:". mysqli_error($conn));
	$isValidLogin = mysqli_num_rows($resultSet);	
	if($isValidLogin){
		$userDetails = mysqli_fetch_assoc($resultSet);
		$_SESSION["user"] = $userDetails['username'];
		$otp = rand(100000, 999999);
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: support@webdamn.com' . "\r\n";
		$messageBody = "One Time Password for login authentication is:<br/><br/>" . $otp;
		$messageBody = wordwrap($messageBody,70);
		$subject = "OTP to Login";
		$mailStatus = mail($email, $subject, $messageBody, $headers);		
		if($mailStatus == 1) {
			$insertQuery = "INSERT INTO authentication(otp,	expired, created) VALUES ('".$otp."', 0, '".date("Y-m-d H:i:s")."')";
			$result = mysqli_query($conn, $insertQuery);
			$insertID = mysqli_insert_id($conn);
			if(!empty($insertID)) {
				header("Location:verify.php");
			}
		}				
	} else {		
		$errorMessage = "Invalid login!";		 
	}
} else if(!empty($_POST["email"])){
	$errorMessage = "Enter Both user and password!";	
}	
?>
<title>webdamn.com : Demo Login System with OTP using PHP & MySQL</title>
<?php include('inc/container.php');?>
<div class="container">	
	<div class="col-md-12">   
	<h2>Example: Login System with OTP using PHP & MySQL</h2>	
	</div>
	<div class="col-md-6">                    
		<div class="panel panel-info" >
			<div class="panel-heading">
				<div class="panel-title">Sign In</div>                        
			</div> 
			<div style="padding-top:30px" class="panel-body" >
				<?php if ($errorMessage != '') { ?>
					<div id="login-alert" class="alert alert-danger col-sm-12"><?php echo $errorMessage; ?></div>                            
				<?php } ?>
				<form id="loginform" class="form-horizontal" role="form" method="POST" action="">                                    
					<div style="margin-bottom: 25px" class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input type="text" class="form-control" id="email" name="email" placeholder="email">                                
					</div>                                
					<div style="margin-bottom: 25px" class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						<input type="password" class="form-control" id="loginPass" name="loginPass" placeholder="password">
					</div>            
					<div style="margin-top:10px" class="form-group">                               
						<div class="col-sm-12 controls">
						  <input type="submit" name="login" value="Login" class="btn btn-success">						  
						</div>
					</div>                                
				</form>   
			</div>                     
		</div>  
	</div>
</div>	
<?php include('inc/footer.php');?>




  