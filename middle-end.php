<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

       $received_data = json_decode(file_get_contents('php://input'), true);

    $operation =$received_data['operation'];

    switch ($operation)
        {
        case "Login":
               $url3 = 'https://web.njit.edu/~kjk42/CS490Test/dbLogin.php';
        break;
        case "Add_Question":
            $url3 = 'https://web.njit.edu/~kjk42/CS490Test/addQuestion.php';
        break;
        default:
            echo "Invalid Action middle!";
    }
    $payload = json_encode($received_data);

        //channel to backend
        //$url3 = 'https://web.njit.edu/~kjk42/CS490Test/dbLogin.php';
        $ch3 = curl_init($url3); //connecting to backend
        curl_setopt($ch3, CURLOPT_POSTFIELDS, $payload); // send array
        curl_setopt($ch3, CURLOPT_RETURNTRANSFER,1); //saves information from curl
        curl_setopt($ch3, CURLINFO_HEADER_OUT,0); //header info rnot need from backend
        $BACK_RET = curl_exec($ch3); // execute back curl
        $returned_data_from_back = json_decode($BACK_RET); //decode data received from back
        curl_close($ch3); //close curl to back

        $payload = json_encode($returned_data_from_back, true);
        echo $payload;

?>
