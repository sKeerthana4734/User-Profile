<?php
require 'connection.php';

if(isset($_POST["action"]) && $_POST["action"]=="login"){
    login();
}


function login(){
  global $conn;
  global $redis;
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
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            if($password == $row['password']){
                $response["login"] = true;
                $response["id"] = $row["index"];
                $redis->set('userID', $row["index"]);
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