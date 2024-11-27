<?php
    include 'connection.php';
	
	if(!empty($_SESSION["id"])){
			$id = $_SESSION["id"];
			$result = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$id' ");
			$row = mysqli_fetch_assoc($result);
		}else{
			header("Location: login.php");
			exit();
		}
	

    if (isset($_POST['submit'])) {
		
		
        // Retrieve form inputs
        $contentTitle = $_POST['contentTitle'] ?? null;
        $description = $_POST['description'] ?? null;
        $location = $_POST['locationDropdown'] ?? null; // Assume this is the LOCATION_ID
        $url = $_POST['url'] ?? null;
		
		$user_id = $id;
		$video = $_FILES['video']['name'];
		$videoPath = 'uploads/vid/' . basename($video);
		
		$image = $_FILES['image']['name'];
		$imagePath = 'uploads/img/' . basename($image);
		
		move_uploaded_file($_FILES['video']['tmp_name'], $videoPath);
		
		move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
		
       /*  if (isset($_FILES['video'])) {
            $video = $_FILES['video'];
			echo "yes";
        } else {
            $video = null;
			echo "no";
        }

        if (isset($_FILES['image'])) {
            $image = $_FILES['image'];
			echo "yes";
        } else {
            $image = null;
			echo "no";
        } */

        // Move uploaded files to the server (adjust the path as needed)
        /* if (isset($_FILES['video']['tmp_name']) && $_FILES['video']['error'] === UPLOAD_ERR_OK) {
            move_uploaded_file($_FILES['video']['tmp_name'], "uploads/vid/" . $video);
        }

        if (isset($_FILES['image']['tmp_name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            move_uploaded_file($_FILES['image']['tmp_name'], "uploads/img/" . $image);
        } */

        // Insert into location table
        $location_sql = "INSERT INTO `location` (location) VALUES ('$location')";
        if (mysqli_query($conn, $location_sql)) {
            $location_id = mysqli_insert_id($conn);
        }

        // Insert into media table
        $media_sql = "INSERT INTO `media` (url, video, image)
                    VALUES ('$url', '$videoPath', '$imagePath')";
        if (mysqli_query($conn, $media_sql)) {
            $media_id = mysqli_insert_id($conn); // Get the newly inserted media ID
        }

        // Insert into quiz table
        /* $quiz_sql = "INSERT INTO `quiz` (quiz_title) VALUES ('$quizTitle')";
        if (mysqli_query($conn, $quiz_sql)) {
            $quiz_id = mysqli_insert_id($conn); 
        } */
		
		

        // Insert into content table
        /* $content_sql = "INSERT INTO `content` (content_title, description, location_id, quiz_id, media_id, user_id)
                        VALUES ('$contentTitle', '$description', '$location_id', '$quiz_id', '$media_id', '$user_id')"; */
						
		$stmt = $conn->prepare("INSERT INTO `content` (content_title, description, location_id, media_id, user_id) VALUES (?,?,?,?,?)");
		$stmt->bind_param('sssss', $contentTitle, $description, $location_id, /* $quiz_id, */ $media_id, $user_id);
		$result = $stmt->execute();

        if ($result) {
            $content_id = mysqli_insert_id($conn);
			$_SESSION['success_message'] = "Content Pending for Admin & Historian's approval";
			header("Location: dashboard-user.php");
			
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        // Close the connection
        //mysqli_close($conn);
    }
?>
