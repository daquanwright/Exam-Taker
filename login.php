<?php
/* Daquan Wright - Front-end */
session_start();

  if(isset($_POST['submit']))
  {
  	//echo hello;
      if (isset($_POST["username"]) && !empty($_POST["username"]) && (isset($_POST["password"]) && !empty($_POST["password"])))
  	{
          $username = $_POST['username'];
          $password = $_POST['password'];
          $role = $_GET['role'];
          $operation = $_POST['operation'];
          //echo $operation;

  	// Store login or operation data inside PHP array
  	$data = array(
  		'username' => "$username",
  		'password' => "$password",
      'role' => "$role",
  		'operation' => "$operation",
  	);
  }
    else
    {
        //echo 'Enter a username and/or password';
      }
  }

	// Convert PHP array into JSON representation
	$transport_data = json_encode($data, true);
  //echo $transport_data;

  //to test middle
	$middle_end = 'https://web.njit.edu/~kjk42/CS490Test/mLoginTest.php';

  //to functional middle
	//$middle_end = 'https://web.njit.edu/~ahp34/cs490/functional/middle.php';
	//echo $transport_data;

  	// cURL data to middle-end
	$curl_handle = curl_init($middle_end);
	//curl_setopt($curl_handle, CURLOPT_SLL_VERIFYPEER, 0);
	curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $transport_data);
	curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

	// Message for successful or unsuccessful login attempt
	$answer = curl_exec($curl_handle);
	// Close cURL connection
	curl_close($curl_handle);

	// Decode JSON data returned from middle-end and print results
	$returned_data = json_decode($answer, true);

  //$operation = 'Login';

  switch ($operation)
  {
    case "Login":

      if ($username == 'teacher')
      {
        $_SESSION['username'] = "teacher";
        header('Location: https://web.njit.edu/~dw269/functional/professor/home.php');
        //echo 'Welcome Professor X!';
      }
      elseif ($username == 'student')
      {
        $_SESSION['username'] = "student";
        header('Location: https://web.njit.edu/~dw269/functional/student/home.php');
        //echo 'Student with much to learn and much potential';
      }
      else
      {
        header('Location: https://web.njit.edu/~dw269/functional/login.html');
      }

    break;

    default: echo "Please provide a valid username and/or password!";
  }

?>
