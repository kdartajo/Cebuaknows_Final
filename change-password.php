<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
        <title>User Registration | WIP</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style/style2.css">
        <link rel="stylesheet" type="text/css" href="css/style/style4.css">
		<script src="js/custom/sweetalert2.js"></script>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<!--<script src="js/custom/script.js" defer></script>-->
    </head>
    <body class="bg-light" style="font-family: sans-serif, sans-serif; font-size: 18px;">
        <div>
            <?php
				include "connection.php";
				
				if(!empty($_SESSION["id"])){
					header("Location: index.php");
				}
				
				
				if(isset($_POST['change'])){
				
					if($_POST['password'] == $_POST['confirm_password']){
						$hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
						
						$stmt = $conn->prepare("update users set password = ?, confirm_password = ? where email = ?");
						$stmt->bind_param('sss',$hashed_password, $_POST['confirm_password'], $_SESSION['email']);
						$result = $stmt->execute();
						
						if($result){
							echo '<div class="alert alert-info" role="alert">Password Changed, please proceed to Log in page</div>';
							session_destroy();
							
						}else{
							echo 'did not work';
						}
					}else{
						echo '<div class="alert alert-info" role="alert">Password did not match</div>';
							
					}
				}
				
                
			?>
		</div>
        <div class="container mt-5">
            <div class="row justify-content-center align-items-center h-100">
                <!-- Circular logo container on the left side -->
				<div class="col-lg-6 col-md-6 d-flex flex-column align-items-center text-center mb-4 mb-md-0">
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
				<div class="col-lg-6 col-md-6">
					<form action="change-password.php" method="POST">
						<div class="card p-4 shadow tile-card text-dark">
							<img src="img/assets/resetpass.png" alt="verPass" class="img-fluid d-block mx-auto mb-3" style="max-width: 150px;">
							<p class="text-center mt-3">Fill up this form with your new created password.</p>
							
							<div class="form-group mb-3">
								<label for="email">Email Address</label>
								<input class="form-control" type="email" name="email" placeholder="Enter your email address" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" readonly>
							</div>
							<div class="form-group mb-3">
								<label for="password">Password <span class="text-danger">*</span></label>
								<div class="password-container">
									<input class="form-control" type="password" name="password" id="password" onkeyup="check();" placeholder="Create new password" required>
									<span id="toggle-password" class="position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
										<i class="fas fa-eye" id="toggleIconPassword"></i>
									</span>
								</div>
							</div>
							<div class="form-group mb-3">
								<label for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
								<div class="password-container">
									<input class="form-control" type="password" name="confirm_password" id="confirm_password" onkeyup="check();" placeholder="Re-type your new password" required>
									<span id="toggle-confirm-password" class="position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
										<i class="fas fa-eye" id="toggleIconConfirm"></i>
									</span>
								</div>
							</div>
							<div class="d-flex justify-content-center">
								<input class="btn btn-custom" type="submit" name="change" value="Change">
							</div>
							<p class="text-center mt-3">
								Already have an account? <a href="login.php" class="login-link">Login</a>
							</p>
						</div>
					</form>
				</div>
            </div>
        </div>
		<script>
            // Toggle password visibility for the password field
			const togglePassword = document.querySelector('#toggle-password');
			const passwordInput = document.querySelector('#password');
			const toggleIconPassword = document.querySelector('#toggleIconPassword');

			togglePassword.addEventListener('click', function () {
				// Toggle the type attribute
				const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
				passwordInput.setAttribute('type', type);
				
				// Toggle the icon
				toggleIconPassword.classList.toggle('fa-eye');
				toggleIconPassword.classList.toggle('fa-eye-slash');
			});

			// Toggle password visibility for the confirm password field
			const toggleConfirmPassword = document.querySelector('#toggle-confirm-password');
			const confirmPasswordInput = document.querySelector('#confirm_password');
			const toggleIconConfirm = document.querySelector('#toggleIconConfirm');

			toggleConfirmPassword.addEventListener('click', function () {
				// Toggle the type attribute
				const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
				confirmPasswordInput.setAttribute('type', type);
				
				// Toggle the icon
				toggleIconConfirm.classList.toggle('fa-eye');
				toggleIconConfirm.classList.toggle('fa-eye-slash');
			});
        </script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    </body>
</html>