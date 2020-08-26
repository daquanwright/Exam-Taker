<?php
/* Daquan Wright - Front-end */
  session_start();
  $operation = $_POST['operation'];

  //echo $operation;

  switch ($operation)
  {
    case "Login":
      $_SESSION["user"] = $_POST['username'];
      $data->Username = $_POST['username'];
      $data->Password = $_POST['password'];
      $data->operation = 'Login';
      break;
    case "Add_Question":
      $data->Question = $_POST['Question'];
      $data->Function = $_POST['Function'];
      $data->Type = $_POST['Type'];
      $data->Difficulty = $_POST['Difficulty'];
      $data->Parameters = $_POST['Parameters'];
      $data->Test_Cases = $_POST['Test_Cases'];
      $data->Inputs = $_POST['Inputs'];
      $data->Outputs = $_POST['Outputs'];
      $data->Constraints = $_POST['Constraints'];
      $data->operation = 'Add_Question';
      break;
    case "Question_Search":
      $data->Type = $_POST['Type'];
      $data->Difficulty = $_POST['Difficulty'];
      $data->Constraints = $_POST['Constraints'];
      $data->Keyword = $_POST['Keyword'];
      $data->operation = 'Question_Search';
    case "Add_Exam":
      $data->Exam_Name = $_POST['Exam_Name'];
      $data->Question_IDs = $_POST['Question_IDs'];
      $data->Points = $_POST['Points'];
      $data->operation = 'Add_Exam';
      break;
    case "Exam_Search":
      $data->Exam_Name = $_POST['Exam_Name'];
      $data->operation = 'Exam_Search';
      break;
    case "Exam_Name_Search":
      $data->Exam_Name = $_POST['Exam_Name'];
      $data->operation = 'Exam_Name_Search';
      break;
    case "Exam_User_Search":
      $data->Username = $_POST['username'];
      $data->operation = 'Exam_User_Search';
      break;
    case "Retrieve_Questions":
      $data->Exam_Name = $_POST['Exam_Name'];
      $data->operation = 'Retrieve_Questions';
      break;
    case "Retrieve_Answers":
      $data->Exam_Name = $_POST['Exam_Name'];
      $data->Username = $_POST['username'];
      $data->operation = 'Retrieve_Answers';
      break;
    case "Student_Submit_Exam":
      $data->Exam_Name = $_POST['Exam_Name'];
      $data->Username = $_POST['username'];
      $data->Answers = $_POST['Answers'];
      $data->IDs = $_POST['IDs'];
      $data->operation = 'Student_Submit_Exam';
      break;
    case "Professor_Submit_Exam":
      $data->Exam_Name = $_POST['Exam_Name'];
      $data->Username = $_POST['username'];
      $data->Comments = $_POST['Comments'];
      $data->Test_Points = $_POST['Test_Points'];
      $data->Total_Points = $_POST['Total_Points'];
      $data->Function_Points = $_POST['Function_Points'];
      $data->Constraints_Points = $_POST['Constraints_Points'];
      $data->Parameters_Points = $_POST['Parameters_Points'];
      $data->Colon_Points = $_POST['Colon_Points'];
      $data->operation = 'Professor_Submit_Exam';
      break;
    case "Release_Exam":
      $data->Exam_Name = $_POST['Exam_Name'];
      $data->operation = 'Release_Exam';
      break;
    default:
    echo "Invalid Action Not Permitted!";
  }

	// Convert PHP array into JSON representation
	$transport_data = json_encode($data);
  //echo $transport_data;

  //to test middle
	$middle_end = 'https://web.njit.edu/~kjk42/CS490Test/sendToMiddleTest.php';

  //to functional middle
	//$middle_end = 'https://web.njit.edu/~ahp34/cs490/functional/middle.php';
	//echo $transport_data;

  	// cURL data to middle-end
	$curl_handle = curl_init($middle_end);
	curl_setopt($curl_handle, CURLOPT_SLL_VERIFYPEER, 0);
	curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $transport_data);
	curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

	// Message for json decoded response
	$answer = curl_exec($curl_handle);
	// Close cURL connection
	curl_close($curl_handle);

	// Decode JSON data returned from middle-end and print results
	//$returned_data = json_decode($answer, true);
  echo $answer;

?>
