<?php

//view_exam.php 

include('../master/Examination.php');

$exam = new Examination;

$exam->user_session_private();

include('../include/exam_header.php');
?>

<head>
    <META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=utf-8">
    <TITLE>WebGazer Demo</TITLE>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <script src='https://meet.jit.si/external_api.js'></script>
    <center>
        <div id="jitsi-container"></div>
        <div><canvas id="canvas"></canvas></div>

        <div id="label-container"></div>
    </center>


</head>

<body LANG="en-US" LINK="#0000ff" DIR="LTR">

    <script>
        // var button = document.querySelector('#start');
        var container = document.querySelector('#jitsi-container');
        var api = null;


        var possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var stringLength = 30;

        function pickRandom() {
            return possible[Math.floor(Math.random() * possible.length)];
        }



        var randomString = <?php echo "hi"?>

        var domain = "meet.jit.si";
        var options = {
            "roomName": randomString ,
            "parentNode": container,
            "width": 500,
            "height": 550,


        };
        api = new JitsiMeetExternalAPI(domain, options);



        api.executeCommand('toggleShareScreen', {
            on: true, //whether screen sharing is on
            details: {
                sourceType: screen,

            }

            // From where the screen sharing is capturing, if known. Values which are
            // passed include 'window', 'screen', 'proxy', 'device'. The value undefined
            // will be passed if the source type is unknown or screen share is off.


        });

        api.executeCommand('toggleVideo');
        /*  window.addEventListener('beforeunload', function (e) {
             e.preventDefault();
             e.returnValue = ''; */

        /*  api.executeCommand('stopRecording',
            { mode: file } */
        //);
        //recording mode to stop, //`stream` or `file` 


        //}); */
    </script>



    <canvas id="plotting_canvas" width="500" height="500" style="cursor:crosshair;"></canvas>
    <script src="webgazer.js"></script>
    <script src="jquery.min.js"></script>
    <script src="sweetalert.min.js"></script>

    <script src="main.js"></script>
    <script src="calibration.js"></script>
    <script src="precision_calculation.js"></script>
    <script src="precision_store_points.js"></script>
    <script src="resize_canvas.js"></script>
    <script src="bootstrap.min.js"></script>


    <!-- <div class="watermark leftwatermark"
        style='background-image: url("watermark.png"); max-width: 140px; max-height: 70px; visibility:hidden;'>
    </div> -->

    <!-- <button id="start" type="button" onclick="init()">Start</button> -->

    <!-- <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@1.3.1/dist/tf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@teachablemachine/pose@0.8/dist/teachablemachine-pose.min.js"></script> -->


    <!-- <div class="horizontalgap" style="width:10px"></div> -->



</body>