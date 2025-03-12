<?php

date_default_timezone_set('Asia/Seoul');

require __DIR__.'/includes/app.php';
?>

<!doctype html>

<html>

<head>

    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no"/>

    <script src="//code.jquery.com/jquery.min.js"></script>


    <script>

        $(document).ready(function () {
            var drawCanvas = document.getElementById('drawCanvas');
            var drawBackup = new Array();
            if (typeof drawCanvas.getContext == 'function') {
                var ctx = drawCanvas.getContext('2d');
                var isDraw = false;
                var width = 3;
                var color = "#000000";
                var pDraw = $('#drawCanvas').offset();
                var currP = null;


                $('#width').bind('change', function () {
                    width = $('#width').val();
                });

                // 저장된 이미지 호출

                if (localStorage['imgCanvas']) {
                    loadImage();
                } else {
                    ctx.clearRect(0, 0, drawCanvas.width, drawCanvas.height);
                }


                // Event (마우스)

                $('#drawCanvas').bind('mousedown', function (e) {
                    if (e.button === 0) {
                        saveCanvas();
                        e.preventDefault();
                        ctx.beginPath();
                        isDraw = true;
                    }
                });

                $('#drawCanvas').bind('mousemove', function (e) {
                    var event = e.originalEvent;
                    e.preventDefault();
                    currP = {X: event.offsetX, Y: event.offsetY};
                    if (isDraw) draw_line(currP);
                });

                $('#drawCanvas').bind('mouseup', function (e) {
                    e.preventDefault();
                    isDraw = false;
                });

                $('#drawCanvas').bind('mouseleave', function (e) {
                    isDraw = false;
                });


                // Event (터치스크린)

                $('#drawCanvas').bind('touchstart', function (e) {
                    saveCanvas();
                    e.preventDefault();
                    ctx.beginPath();
                });

                $('#drawCanvas').bind('touchmove', function (e) {
                    var event = e.originalEvent;
                    e.preventDefault();
                    currP = {X: event.touches[0].pageX - pDraw.left, Y: event.touches[0].pageY - pDraw.top};
                    draw_line(currP);
                });

                $('#drawCanvas').bind('touchend', function (e) {
                    e.preventDefault();
                });


                // 선 그리기

                function draw_line(p) {
                    ctx.lineWidth = width;
                    ctx.lineCap = 'round';
                    ctx.lineTo(p.X, p.Y);
                    ctx.moveTo(p.X, p.Y);
                    ctx.strokeStyle = color;
                    ctx.stroke();
                }


                function loadImage() { // reload from localStorage
                    var img = new Image();
                    img.onload = function () {
                        ctx.drawImage(img, 0, 0);
                    }
                    img.src = localStorage.getItem('imgCanvas');
                }


                function saveImage() { // save to localStorage
                    var canvas = document.getElementById('drawCanvas');
                    localStorage.setItem('imgCanvas', canvas.toDataURL('image/png'));
                    var img = document.getElementById('saveImg');
                    img.src = canvas.toDataURL('image/png');
                    var tmp = $('<a>').attr('download', 'test.png').attr('href', img.src);
                    tmp[0].click();
                    tmp.remove();
                }


                function clearCanvas() {
                    ctx.clearRect(0, 0, drawCanvas.width, drawCanvas.height);
                    ctx.beginPath();
                    localStorage.removeItem('imgCanvas');
                }


                function saveCanvas() {
                    drawBackup.push(ctx.getImageData(0, 0, drawCanvas.width, drawCanvas.height));
                }


                function prevCanvas() {
                    ctx.putImageData(drawBackup.pop(), 0, 0);
                }


                $('#btnPrev').click(function () {
                    prevCanvas();
                });


                $('#btnClea').click(function () {
                    clearCanvas();
                });

                $('#btnSave').click(function () {
                    saveImage();
                });

            }

        });

    </script>

</head>

<body>

<div>

    <div align="center">

        <canvas id="drawCanvas" width="320" height="320" style="border:1px solid #000000;">Canvas not supported</canvas>

    </div>

    <div align="center">


        <button id="btnClea">다시 서명</button>

        <button id="btnSave">저장</button>

    </div>

</div>

<img id="saveImg" src="" style="display:none;"/>

<div style="width:100%;height:800px;">&nbsp;</div>

</body>

</html>
