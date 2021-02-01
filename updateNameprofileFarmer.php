<?php
	include ("config.php");
	// declaring array for JSON response 
	$response = array();
	if (isset($_GET['name']) && isset($_GET['cnic']) )
	{
		try {
			$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (PDOException $e){
			die("Cannot Connect!!Something went wrong");
		}

		$cnic = $_GET['cnic'];
		$name = $_GET['name'];

		$sql = "SELECT * FROM Farmer where nic = :cnic";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':cnic', $cnic, PDO::PARAM_STR);
		$stmt->execute();

		if($stmt->rowCount())
		{
			foreach($stmt as $Farmer)
			{
				$nam = $Farmer['name'];
			}
			if($name == $nam)
			{
				$response["success"] = 1;
				$response["message"] = "This is already your name";
				echo json_encode($response);
			}
			else
			{
				$sql1 = "UPDATE Farmer SET name = :name where nic = :cnic";
				$stmt1 = $conn->prepare($sql1);
				$stmt1->bindParam(':cnic', $cnic, PDO::PARAM_STR);
    			$stmt1->bindParam(':name', $name, PDO::PARAM_STR);
				$stmt1->execute();

				if($stmt1 -> rowCount()){
					$response["success"] = 1;
					$response["message"] = "Name updated";
					echo json_encode($response);
				}
				else{
					// no row found
					$response["success"] = 0;
					$response["message"] = "Can't update the name";
					// echo no users JSON
				}
			}
		}
		else{
					// no row found
					$response["success"] = 0;
					$response["message"] = "Service Recipient's CNIC is not registered";
					// echo no users JSON
		}

	}
	else{
		$response["success"] = 0;
		$response["message"] = "Required fields missing.";
		echo json_encode($response);
	}

?>

