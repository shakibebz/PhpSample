<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // collect value of input field
    $email = $_REQUEST['email'];
    $pass = password_hash($_REQUEST['pass'], PASSWORD_DEFAULT);

    //check the fields to not being empty
    if (!empty($email) && !empty($pass)) {

        try {
            $data__parameters = [
                "email" => $email,
                "pass" => $pass,

            ];
            require 'DBconnect.php';

            // check for duplicate user
            $check= "SELECT * FROM users where email= '$email'";
            $state= $con->prepare($check);
            $state->execute();
            $duplicate_check_count= $state->rowCount();
            if ($duplicate_check_count > 0 )
            {
                http_response_code(404);
                $server__response__error = array(
                    "code" => http_response_code(404),
                    "status" => false,
                    "message" => "This user is already registered."
                );
                echo json_encode($server__response__error);
            }

            //if pass and confirm pass are equal, then insert user data
         else if ($_REQUEST["pass"] === $_REQUEST["confirm"]) {
                $query = "INSERT INTO users (email, pass, role_id) VALUES ('$email', '$pass', 1)";
                $insert__data__statement = $con->prepare($query);
                $insert__data__statement->execute();
                $insert__record__flag = $insert__data__statement->rowCount();

                if ($insert__record__flag > 0) {
                    $server__response__success = array(
                        "code" => http_response_code(200),
                        "status" => true,
                        "message" => "User successfully created."
                    );
                    echo json_encode($server__response__success);
                } else {
                    http_response_code(404);
                    $server__response__error = array(
                        "code" => http_response_code(404),
                        "status" => false,
                        "message" => "Failed to create user. Please try again."
                    );
                    echo json_encode($server__response__error);
                }


            } else {
                echo "Password and confirm password does not match";
            }
        } catch (Exception $ex) {
            http_response_code(404);
            $server__response__error = array(
                "code" => http_response_code(404),
                "status" => false,
                "message" => "Opps!! Something Went Wrong! " . $ex->getMessage()
            );
            echo json_encode($server__response__error);
        }

    }
    else
    {
        echo json_encode('fields should not be empty');
    }
}

?>