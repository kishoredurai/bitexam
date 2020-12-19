<?php
include('../include/user_header.php');
?>
<script>
    window.alert = function(al, $) {
        return function(msg) {
            al.call(window, msg);
            $(window).trigger("okbuttonclicked");
        };
    }(window.alert, window.jQuery);



    $(window).on("okbuttonclicked", function() {
        console.log("you clicked ok");
        var el = document.documentElement,
            rfs = el.requestFullscreen ||
            el.webkitRequestFullScreen ||
            el.mozRequestFullScreen ||
            el.msRequestFullscreen;

        rfs.call(el);
    });

    alert("something");
</script>