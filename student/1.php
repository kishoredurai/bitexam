<?php

//view_exam.php 

include('../master/Examination.php');

$exam = new Examination;

$exam->user_session_private();

include('../include/exam_header.php');
?>
<script>
        // var button = document.querySelector('#start');
        var container = document.querySelector('#jitsi-container');
        var api = null;

        
            // var possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            // var stringLength = 30;

            // function pickRandom() {
            //     return possible[Math.floor(Math.random() * possible.length)];
            // }

            // var randomString = Array.apply(null, Array(stringLength)).map(pickRandom).join('');
            var randomString = '191CS151';    
            var domain = "meet.jit.si";
            var options = {
                "roomName": randomString,
                "parentNode": container,
                "width": 500,
                "height": 350,
                

            };
            api = new JitsiMeetExternalAPI(domain, options);



            api.executeCommand('toggleShareScreen',
                {
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