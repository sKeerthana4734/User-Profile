<?php
require 'connection.php';

if(isset($_POST["action"]) && $_POST["action"]=="register"){
    register();
}


function register(){
  global $conn;
  header('Content-Type: application/json');
  $name = $_POST["name"];
  $username = $_POST["username"];
  $password = $_POST["password"];

  if(empty($name) || empty($username) || empty($password)){
    $response["message"]="Please Fill Out The Form!";
    echo json_encode($response);
    exit;
  }

  $usr_query = $conn->prepare("SELECT * FROM users WHERE username = ?");
  $usr_query->bind_param("s", $username);
  $usr_query->execute();
  $usr_query->store_result();
  if ($usr_query->num_rows > 0) {
      $response["message"] = "Username Has Already Taken";
      echo json_encode($response);
      exit;
  }
  $usr_query->close();

  $query = "INSERT INTO users (name, username, password) VALUES (?, ?, ?)";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "sss", $name, $username, $password);
  if($stmt){
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_close($stmt);
        $response["register"] = true;
        $response["message"]="Registration Successful. Please Login to Continue.";
        echo json_encode($response);
        exit();
    }
  } else {
    $response["message"]="Registration Failed. Try again Later.";
    echo json_encode($response);
  }
}

?>