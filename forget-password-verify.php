    <!DOCTYPE html>
    <html>
        <head>
            <title>CebuaKnows | Email Verification</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta charset="UTF-8">
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
            <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="css/style/style2.css">
            <link rel="stylesheet" type="text/css" href="css/style/style4.css">
			<script src="js/custom/sweetalert2.js"></script>
			<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
			<!--<script src="js/custom/script.js" defer></script>-->
        </head>
        <body class="bg-light" style="font-family: sans-serif, sans-serif; font-size: 18px;">
           
                <?php
				include "connection.php";
				
				
				if(!empty($_SESSION["id"])){
					header("Location: index.php");
				}
				
				if(isset($_POST['verify'])){
					if(!isset($_SESSION['randomNumber'])){
						echo '<div class="alert alert-info" role="alert">No OTP sent</div>';
					}else{
						if($_POST['otp'] == $_SESSION['randomNumber']){
							header("location: change-password.php");
						}else{
							echo '<div class="alert alert-danger" role="alert">Incorrect Verification Number, please try again</div>';
						}
					}
					
					
				}
				
				
				
							?>
            
        <div class="container mt-5">
            <div class="row justify-content-center align-items-center h-100">
                    <!-- Circular logo container on the left side -->
					<div class="col-lg-6 d-flex flex-column align-items-center text-center mb-4 mb-md-0">
						<div class="logo-container">
								<img src="img/loginp.jpg" alt="Logo" class="img-fluid">
							</div>
							<div class="logo-text mt-3">
								<img src="img/cebu_b.png" alt="Logo" class="img-fluid">
							</div>
							<div class="logo-text mt-3">
								Educational platform for Cebu’s Historical Places.
							</div>
					</div>
                    <!-- Registration card on the right side -->
					<div class="col-lg-6 col-md-8 col-sm-10 col-12 mx-auto">
						<div class="forgot_verify_card text-dark p-4 shadow">
							<form action="forget-password-verify.php" method="POST">
								
								<img src="img/assets/passVer.png" alt="verPass" class="img-fluid d-block mx-auto mb-3" style="max-width: 150px;">
								<h1 class="text-center">Verify Code</h1>
								<p class="text-center">CebuaKnows have sent a OTP in your email.</p>
								<div class="form-group mb-3">
									<label for="otp"></label>
									<input class="form-control" type="number" name="otp" placeholder="Enter OTP" required>
								</div>
								<div class="d-flex justify-content-center">
									<input class="btn btn-primary" type="submit" name="verify" value="Verify">
								</div>		
							</form>
						</div>
					</div>
            </div>
        </div>	
		
			
	
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
	
    </body>
</html>