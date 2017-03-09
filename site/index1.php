<?php
/**
 * Created by PhpStorm.
 * User: rootXcomp
 * Date: 07.02.2017
 * Time: 15:38
 */
?>
<!DOCTYPE>
<html>
<head>
    <title>Distributed System Geting Weather Information</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="core.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<p>
<h1 class="tittle">Distributed System Geting Weather Information</h1>
<div class="menu">
    <a href="#" class="start_geting" onclick="recreload()">START GETING DATA!</a> |
    <a href="#" id="stopTimer">Stop live getting</a> |
    <a href="#">something yet</a> |
    <a href="#">menu ...</a> |
</div>
<br />
<span id="status">Status:
    <span class="status">click start!<input type="text" name="city" id="city" value="Lutsk"/>
    </span>
</span>
<div id="data">
    <div>ID:<span id="id"></span></div>
    <div>Station:<span id="station"></span></div>
    <div>Temperature:<span id="data0"></span></div>
    <div>Humidity:<span id="data1"></span></div>
    <div>HIC:<span id="data2"></span></div>
    <div>Rain:<span id="data3"></span></div>
    <div>Light:<span id="data4"></span></div>
    <div>Gigrometer:<span id="data5"></span></div>
    <div>Vibration:<span id="data6"></span></div>
    <div>Date:<span id="date"></span></div>
    <div>Time:<span id="time"></span></div>
</div>
</body>
</html>
