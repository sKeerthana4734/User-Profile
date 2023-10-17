<?php

require 'connection.php';
global $redis;

header('Content-Type: application/json');
if(isset($_POST["action"]) && $_POST["action"]=="save"){
    save();
}
if(isset($_POST["action"]) && $redis->get('userID')!=null){
    if ($_POST["action"]==="load_profile"){
    getUserdata();
    }
}
// retreive user data from db
function getUserdata(){
    global $conn;
    global $redis;
    $id = intval($redis->get('userID'));
    $query = "SELECT * FROM users WHERE `index` = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    if($stmt)
    {
        if(mysqli_stmt_execute($stmt))
        {
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            if($row){
                $userData['username']=$row['username'];
                $userData['firstname']=$row['firstname'];
                $userData['lastname']=$row['lastname'];
                $userData['email']=$row['email'];
                $userData['age']=$row['age'];
                $userData['gender']=$row['gender'];
                $userData['phone']=$row['phone'];
                $userData['country']=$row['country'];
            }
            mysqli_stmt_close($stmt);
        }
        mysqli_close($conn);
    }
    echo json_encode($userData);
}



function save(){
  global $conn;
  global $redis;
  function isPostDataEmptyOrNull($postArray) {
    foreach ($postArray as $value) {
        if (empty($value) && !is_numeric($value)) {
            return true; 
        }
    }
    return false; 
}

if (isPostDataEmptyOrNull($_POST)) {
    $response['message']="Please fill all the fields";
    echo json_encode($response);
} else {
  $username = $_POST["username"];
  $firstname = $_POST["firstname"];
  $lastname = $_POST["lastname"];
  $age = $_POST["age"];
  $gender = $_POST["gender"];
  $email = $_POST["email"];
  $phone = $_POST["phone"];
  $country = $_POST["country"]; 
  $id = intval($redis->get('userID'));


  $query = "UPDATE users SET firstname = ?, lastname = ?, email = ?, age = ?, gender = ?, phone = ?, country = ? WHERE `index` = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "sssssssi", $firstname, $lastname, $email, $age, $gender, $phone, $country, $id);

  if($stmt){
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_close($stmt);
        $response["save"] = true;
        $response['message']="Saved Successfully";
        echo json_encode($response);
        exit();
    }
  } else {
    $response['message']="Saved failed";
    echo json_encode($response);
    exit();
  }
  }

}
?>