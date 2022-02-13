<?php

session_start();

if(!isset($_SESSION['user_id']))
{
	header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href='css/select2.min.css' rel='stylesheet' type='text/css'>
    <link href="css/datatables.min.css" rel="stylesheet">
    <link href="css/app2.css" rel="stylesheet">
    <title>Table of content</title>
</head>

<body>