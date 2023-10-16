<?php
require 'db.php';

if(isset($_POST["action"]) && $_POST["action"]=="login"){
    login();
}


function login(){
  global $conn;
  header('Content-Type: application/json');
  if(isset($_POST['username']) && isset($_POST['password']))
  {
    $username = $_POST["username"];
    $password = $_POST["password"];
    if(empty($username)){
        $response["message"]="Username is Required";
        echo json_encode($response);
        exit;
    }else if(empty($password)){
        $response["message"]="Password is Required";
        echo json_encode($response);
        exit;
    }else{
        $user = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

        if(mysqli_num_rows($user) > 0){

            $row = mysqli_fetch_assoc($user);

            if($password == $row['password']){
                $response["login"] = true;
                $response["id"] = $row["index"];
                $_SESSION["id"] = $row["index"];
                $response["message"]="Login Successful";
                echo json_encode($response);
            }
            else
            {
                $response["message"]="Wrong Password";
                echo json_encode($response);
                exit;
            }
        }
        else
        {
            $response["message"]="User Not Registered";
            echo json_encode($response);
            exit;
        }
    
    }
  }
}


?>