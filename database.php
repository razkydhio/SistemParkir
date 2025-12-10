<?php session_start();

$hostname = "localhost";
$username = "root";
$password = "";
$db_name = "db_parkir";

$db = mysqli_connect($hostname, $username, $password, $db_name);

function query($sql)
{

    global $db;

    return mysqli_query($db, $sql);
}
function hitung($sql)
{
    return mysqli_num_rows($sql);
}



function ts($time)
{
    $jam = $time / (60 * 60);
    return ceil($jam);
}
