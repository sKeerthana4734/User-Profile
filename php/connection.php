<?php
session_start();
$conn = mysqli_connect("localhost", "root", "4321", "guvi");
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

// Redis connection
$redis_host = 'localhost';
$redis_port = 6379;

try {
    $redis = new Redis();
    $redis->connect($redis_host, $redis_port);

} catch (RedisException $e) {
    die("Redis connection failed: " . $e->getMessage());
}

?>
