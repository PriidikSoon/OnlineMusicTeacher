<!DOCTYPE html>
<html>
<head>
    <title>Online Music Teacher</title>
    <meta name="mobileOptimized" content="0">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no" />
    <meta name="HandheldFriendly" content="true">
    <link href="css/app.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/themes/smoothness/jquery-ui.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/audioProcessing.js"></script>
    <script type="text/javascript" src="js/vexflow-min.js"></script>
    <script type="text/javascript" src="js/measure.js"></script>
    <script type="text/javascript" src="js/musicxml.js"></script>
    <script type="text/javascript" src="js/document.js"></script>
    <script type="text/javascript" src="js/documentformatter.js"></script>
    <style type="text/css">
        div.content {
            overflow: hidden;
            width: 100%;
            padding: 0; margin: 0;
        }
    </style>
</head>
<body>
<div style="width: 100%"><div style="margin: 0 auto; display: table"><h1>Online Music Teacher</h1></div></div>
@if (!Auth::guest())
@include('menu')
@endif