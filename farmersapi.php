				<?php 
				include("config.php");
				//declaring array for JSON response
				  $response = array();

				  try {
				  	$conn=new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
				  	$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				  }
				  catch (PDOException $e){
				  	die("Cannot Connect!! Something went wrong");
				  }
				  $cnic=$_POST['cnic'];
				  $data1= ['nic' => $cnic];

				  $sql1= "SELECT * FROM Farmer where nic= :nic";
				  $stmt1= $conn->prepare($sql1);
				  $stmt1->execute($data1);

				  if($stmt1 -> rowcount()){
				  	$response["success"]=1;
				  	$response["Profile_Details"]=array();

				  	foreach($stmt1 as $Profile_Details){
				  		$Prof_Details=array();
				  		$Prof_Details['name']=$Profile_Details['name'];
				  		$Prof_Details['cnic']=$Profile_Details['cnic'];
				  		$Prof_Details['address']=$Profile_Details['address'];
				  		$Prof_Details['phnum']=$Profile_Details['phone'];
				  		$Prof_Details['district']=$Profile_Details['district'];
				  		$Prof_Details['tehsil']=$Profile_Details['tehsil'];
				  		array_push($reponse["Profile_Details"],$Prof_Details);
				  	}
				  }
				  else{
				  	$response["success"]=0;
				  	$response["message"]= "Service Recipient's CNIC is not registered";
				  }
				  echo json_encode($response);

				?>