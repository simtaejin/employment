<?php
require __DIR__.'/includes/app.php';

use \App\Utils\Common as Common;

$idx = $_REQUEST['idx'];
$mode = $_REQUEST['mode'];
$result = Common::getAgreement($idx);
//Common::print_r2($result);

$signature = false;
if ($mode == "guin") {
    if ($result['guinImage']) {
        $signature = true;
    }
} else if ($mode == "gujig") {
    if ($result['gujigImage']) {
        $signature = true;
    }
}


?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8"/>
    <title>소개요금약정서</title>
    <style type="text/css">
        /* Reset styles */
        * {
            margin: 0;
            padding: 0;
            text-indent: 0;
            box-sizing: border-box; /* 모든 요소의 박스 크기 계산을 더 일관성 있게 */

        }

        /* 화면에서의 body 스타일 */
        body {
            font-family: Batang, serif;
            color: black;
            max-width: 800px; /* 화면에서 최대 폭 */
            margin: 0 auto; /* 화면 중앙 정렬 */
            padding: 20px; /* 내용 좌우 여백 */
            border: 1px solid #000; /* 테두리 추가 */
            height: 1123px; /* 화면 높이를 A4 높이로 지정 (일반 96DPI 기준) */
            overflow: auto; /* 스크롤 사용할 경우 */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* 화면 그림자 */
        }

        /* Typography classes */
        .text-s {
            font-size: 9pt;
            font-weight: normal;
            font-style: normal;
            text-decoration: none;
        }

        .text-m {
            font-size: 10pt;
            font-weight: normal;
            font-style: normal;
            text-decoration: none;
        }

        .text-regular {
            font-size: 11pt;
            font-weight: normal;
            font-style: normal;
            text-decoration: none;
        }

        .text-l {
            font-size: 18pt;
            font-weight: normal;
            font-style: normal;
            text-decoration: none;
        }

        .text-xs {
            font-size: 8pt;
            font-weight: normal;
            font-style: normal;
            text-decoration: none;
        }

        .underline {
            text-decoration: underline;
        }

        .vertical-align-up {
            vertical-align: 2pt;
        }

        .vertical-align-down {
            vertical-align: -2pt;
        }

        /* Layout classes */
        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .padding-top-xs {
            padding-top: 2pt;
        }

        .padding-top-s {
            padding-top: 3pt;
        }

        .padding-top-m {
            padding-top: 6pt;
        }

        .padding-top-l {
            padding-top: 7pt;
        }

        .padding-top-xl {
            padding-top: 9pt;
        }

        .padding-left-xs {
            padding-left: 5pt;
        }

        .padding-left-s {
            padding-left: 7pt;
        }

        .padding-left-m {
            padding-left: 12pt;
        }

        .padding-left-l {
            padding-left: 17pt;
        }

        .padding-left-xl {
            padding-left: 20pt;
        }

        .padding-left-xxl {
            padding-left: 31pt;
        }

        .padding-left-mega {
            padding-left: 60pt;
        }

        .padding-left-large {
            padding-left: 75pt;
        }

        .padding-right-m {
            padding-right: 11pt;
        }

        .padding-bottom-s {
            padding-bottom: 1pt;
        }

        .margin-left-s {
            margin-left: 5.93pt;
        }

        /* List styles */
        .list-marker::before {
            content: "■ ";
            color: black;
        }

        .list-item {
            display: block;
            padding-left: 21pt;
            text-indent: -12pt;
        }

        /* Table styles */
        .table {
            border-collapse: collapse;
            /*width: 480pt;*/
            width: 100%;
            margin-bottom: 20px;

        }

        .table td {
            vertical-align: top;
            overflow: visible;
        }

        .border-top {
            border-top-style: solid;
            border-top-width: 1pt;
        }

        .border-top-gray {
            border-top-style: solid;
            border-top-width: 1pt;
            border-top-color: #999999;
        }

        .border-top-light-gray {
            border-top-style: solid;
            border-top-width: 1pt;
            border-top-color: #B1B1B1;
        }

        .border-top-dotted {
            border-top-style: dotted;
            border-top-width: 1pt;
            border-top-color: #CCCCCC;
        }

        .border-bottom {
            border-bottom-style: solid;
            border-bottom-width: 1pt;
        }

        .border-bottom-gray {
            border-bottom-style: solid;
            border-bottom-width: 1pt;
            border-bottom-color: #999999;
        }

        .border-bottom-light-gray {
            border-bottom-style: solid;
            border-bottom-width: 1pt;
            border-bottom-color: #B1B1B1;
        }

        .border-bottom-dotted {
            border-bottom-style: dotted;
            border-bottom-width: 1pt;
            border-bottom-color: #CCCCCC;
        }

        .border-left-gray {
            border-left-style: solid;
            border-left-width: 1pt;
            border-left-color: #999999;
        }

        .border-right {
            border-right-style: solid;
            border-right-width: 1pt;
        }

        .border-right-gray {
            border-right-style: solid;
            border-right-width: 1pt;
            border-right-color: #999999;
        }

        /* Utility classes */
        .line-height-s {
            line-height: 13pt;
        }

        .line-height-m {
            line-height: 115%;
        }

        .line-height-l {
            line-height: 117%;
        }

        .color-blue {
            color: #00F;
        }

        .indent-negative {
            text-indent: -22pt;
        }

        .form-field {
            display: inline-block;
            min-width: 40pt;
            border-bottom: 1pt solid black;
            text-align: center;
        }

        /* 인쇄 전용 스타일 */
        @media print {
            body {
                width: 210mm; /* A4 크기의 폭 */
                height: 297mm; /* A4 크기의 높이 */
                margin: 0; /* 브라우저 여백 제거 */
                padding: 20px; /* 화면과 동일한 내부 여백 */
                border: 1px solid black; /* 테두리 유지 */
                box-shadow: none; /* 그림자 제거 */
                overflow: visible; /* 스크롤 방지 */
            }

            /* 브라우저 자동 여백 제거 */
            @page {
                margin: 0; /* 페이지 기본 여백 제거 */
            }
        }


        .signature-block {
            position: relative;
            width: 100%;
            height: 50px; /* 이미지 겹칠 수 있도록 충분한 높이 */
        }

        .signature_gujig_image {
            position: absolute;
            width: 100px;
            height: 100px;
            top: -20px;
            right: 0; /* 오른쪽으로 정렬 */
            left: auto !important; /* 가운데 정렬 강제 제거 */
            transform: none !important; /* 가운데 이동 제거 */
            z-index: 10;
        }

        .signature_gujig_image img {
            width: 100%;
            height: auto;
        }

        .signature_guin_image {
            position: absolute;
            width: 100px;
            height: 100px;
            top: -20px;
            right: 0; /* 오른쪽으로 정렬 */
            left: auto !important; /* 가운데 정렬 강제 제거 */
            transform: none !important; /* 가운데 이동 제거 */
            z-index: 10;
        }

        .signature_guin_image img {
            width: 100%;
            height: auto;
        }


        .canvas-container {
            width: 100%;
            max-width: 320px;
            margin: 0 auto;
        }

        #drawCanvas {
            width: 100%;
            height: auto;
            aspect-ratio: 1 / 1;
            touch-action: none;
        }

        .signature-btn {
            padding: 10px 20px;
            margin: 5px;
            border-radius: 5px;
            border: 1px solid #ddd;
            background-color: #f8f8f8;
            color: #333;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .signature-btn:hover {
            background-color: #eaeaea;
            transform: translateY(-2px);
        }

        .signature-btn.primary {
            background-color: #4e73df;
            color: white;
            border-color: #4e6ad0;
        }

        .signature-btn.primary:hover {
            background-color: #375cd8;
        }


        .small-height {
            height: 10px;
            padding: 12px; /* 필요하면 패딩도 낮춤 */
            border: 0px solid #FFFFFF;
        }

        .small-height td {
            border: 0px solid #FFFFFF;
            /*border: 1px solid red;*/
        }

        .small-height p {
            margin: 0; /* 기본 여백 제거 */
            line-height: 1; /* 줄 높이 조정 */
        }

        .blanktd {

        }

        .signature_label {
            width: 180px;
            text-align: left;
            padding-right: 10px;
            font-weight: bold;
            font-size: 14px;
        }

        .signature_name {
            width: 250px;
            text-align: right;
            padding-right: 10px;
        }

        .signature_in {
            width: 100px;
            text-align: right;
        }

        /* 서명 관련 스타일 추가 */
        td[name="signature_gujig"] {
            position: relative;
            padding-top: 60px; /* 이미지 높이에 따라 조정 */
            text-align: center;
        }

        .signature_gujig_image {
            position: absolute;
            width: 100px;
            height: 100px;
            top: -00px; /* 이미지를 위로 이동 (음수 값으로 td 위에 배치) */
            left: 50%;
            transform: translateX(-50%); /* 가운데 정렬 */
            z-index: 10; /* 다른 요소 위에 표시 */
        }

        td[name="signature_guin"] {
            position: relative;
            padding-top: 60px; /* 이미지 높이에 따라 조정 */
            text-align: center;
        }

        .signature_guin_image {
            position: absolute;
            width: 100px;
            height: 100px;
            top: -00px; /* 이미지를 위로 이동 (음수 값으로 td 위에 배치) */
            left: 50%;
            transform: translateX(-50%); /* 가운데 정렬 */
            z-index: 10; /* 다른 요소 위에 표시 */
        }

    </style>
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
                    // loadImage();
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


                function saveImage() {
                    var idx = document.getElementById('idx');
                    var mode = document.getElementById('mode');
                    var canvas = document.getElementById('drawCanvas');
                    var imageData = canvas.toDataURL('image/png');

                    // 서버에 이미지 데이터 전송
                    $.ajax({
                        type: "POST",
                        url: "save_signature.php",  // 이미지를 처리할 PHP 파일
                        data: {
                            idx: idx.value,
                            mode: mode.value,
                            image_data: imageData,
                            filename: "signature_" + Date.now() + ".png"  // 고유한 파일명 생성
                        },
                        success: function (response) {
                            // 서버 응답이 이미 객체인지 문자열인지 확인
                            var result;

                            if (typeof response === 'object') {
                                result = response; // 이미 객체면 그대로 사용
                            } else {
                                try {
                                    result = JSON.parse(response); // 문자열이면 파싱 시도
                                } catch (e) {
                                    console.error("JSON 파싱 오류:", e);
                                    alert("서버 응답을 처리하는 중 오류가 발생했습니다.");
                                    return;
                                }
                            }

                            if (result.success) {
                                alert("서명이 성공적으로 저장되었습니다.");
                                // 필요한 경우 저장된 이미지의 경로를 로컬 스토리지에도 저장
                                // localStorage.setItem('imgCanvas', imageData);

                                if (result.file_path) {
                                    // localStorage.setItem('signatureFilePath', result.file_path);
                                }
                                location.reload()
                            } else {
                                alert("저장 중 오류가 발생했습니다: " + (result.message || "알 수 없는 오류"));
                            }
                        },
                        error: function (xhr, status, error) {
                            alert("서버 통신 오류: " + error);
                            console.error("AJAX 오류:", xhr.responseText);
                        }
                    });
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
<input type="hidden" name="idx" id="idx" value="<?php echo $idx; ?>"/>
<input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>"/>
<p class="list-marker list-item text-s padding-top-s">직업안정법 시행규칙 [별지 제20호서식] <span class="color-blue">&lt;개정 2018. 10. 18.&gt;</span>
</p>
<p class="text-l padding-top-xl text-center">소 개 요 금 약 정 서</p>
<p class="text-left"><br/></p>
<table class="table margin-left-s">
    <tr>
        <td class="border-top border-bottom border-right-gray" rowspan="3" style="width:46pt;">
            <p class="padding-top-l text-left"><br/></p>
            <p class="text-regular padding-left-s text-left">구인자</p>
        </td>
        <td class="border-top border-left-gray border-bottom-gray border-right-gray" style="width:86pt;">
            <p class="text-regular padding-top-xs text-center">사업체명칭</p>
        </td>
        <td class="border-top border-left-gray border-bottom-gray" colspan="3" style="width:349pt;">
            <p class="text-left"><?php echo $result['business']; ?></p>
        </td>
    </tr>
    <tr>
        <td class="border-top-gray border-left-gray border-bottom-gray border-right-gray" style="width:86pt;">
            <p class="text-regular padding-top-xs text-center">소재지</p>
        </td>
        <td class="border-top-gray border-left-gray border-bottom-gray border-right-gray" style="width:160pt;">
            <p class="text-left"><?php echo $result['guinJibunAddress']; ?></p>
        </td>
        <td class="border-top-gray border-left-gray border-bottom-gray border-right-gray" style="width:79pt;">
            <p class="text-regular padding-top-xs text-center">전화번호</p>
        </td>
        <td class="border-top-gray border-left-gray border-bottom-gray" style="width:110pt;">
            <p class="text-left"><?php echo $result['guinPhoneNumber_1']; ?></p>
        </td>
    </tr>
    <tr>
        <td class="border-top-gray border-left-gray border-bottom border-right-gray" style="width:86pt;">
            <p class="text-regular padding-top-xs text-center">대표자</p>
        </td>
        <td class="border-top-gray border-left-gray border-bottom border-right-gray" style="width:160pt;">
            <p class="text-left"><?php echo $result['guinName']; ?></p>
        </td>
        <td class="border-top-gray border-left-gray border-bottom border-right-gray" style="width:79pt;">
            <p class="text-regular padding-top-xs text-center">업종</p>
        </td>
        <td class="border-top-gray border-left-gray border-bottom" style="width:110pt;">
            <p class="text-left"><?php echo $result['industry']; ?></p>
        </td>
    </tr>
</table>
<p class="text-left"><br/></p>
<table class="table margin-left-s">
    <tr>
        <td class="border-top border-bottom border-right-gray" rowspan="3" style="width:46pt;">
            <p class="padding-top-l text-left"><br/></p>
            <p class="text-regular padding-left-s text-left">구직자</p>
        </td>
        <td class="border-top border-left-gray border-bottom-gray border-right-gray" style="width:86pt;">
            <p class="text-regular padding-top-xs text-center">성명</p>
        </td>
        <td class="border-top border-left-gray border-bottom-gray border-right-gray" style="width:160pt;">
            <p class="text-left"><?php echo $result['gujigName']; ?></p>
        </td>
        <td class="border-top border-left-gray border-bottom-gray border-right-gray" style="width:79pt;">
            <p class="text-regular padding-top-xs text-center">생년월일</p>
        </td>
        <td class="border-top border-left-gray border-bottom-gray" style="width:110pt;">
            <p class="text-left"><?php echo $result['birthdate']; ?></p>
        </td>
    </tr>
    <tr>
        <td class="border-top-gray border-left-gray border-bottom-gray border-right-gray" style="width:86pt;">
            <p class="text-regular padding-top-xs text-center">주소</p>
        </td>
        <td class="border-top-gray border-left-gray border-bottom-gray" colspan="3" style="width:349pt;">
            <p class="text-left"><?php echo $result['gujigJibunAddress']; ?></p>
        </td>
    </tr>
    <tr>
        <td class="border-top-gray border-left-gray border-bottom border-right-gray" style="width:86pt;">
            <p class="text-regular padding-top-xs text-center">전화번호</p>
        </td>
        <td class="border-top-gray border-left-gray border-bottom" colspan="3" style="width:349pt;">
            <p class="text-left"><?php echo $result['gujigPhoneNumber_1']; ?></p>
        </td>
    </tr>
</table>
<p class="text-left"><br/></p>
<table class="table margin-left-s">
    <tr>
        <td class="border-top border-bottom border-right-gray" rowspan="5" style="width:46pt;">
            <p class="text-left"><br/></p>
            <p class="text-regular padding-left-m padding-right-m line-height-l text-left">계약<br/>내용</p>
        </td>
        <td class="border-top border-left-gray border-bottom-gray border-right-gray" style="width:86pt;">
            <p class="text-regular padding-top-s text-center">임금</p>
        </td>
        <td class="border-top border-left-gray border-bottom-gray" colspan="3" style="width:349pt;">
            <p class="text-regular padding-top-s padding-left-xl text-left">총액 <span
                        class="form-field"><?php echo $result['pay']; ?></span>
                원</p>
        </td>
    </tr>
    <tr>
        <td class="border-top-gray border-left-gray border-bottom-gray border-right-gray" style="width:86pt;">
            <p class="text-regular padding-top-s text-center">임금지급형태</p>
        </td>
        <td class="border-top-gray border-left-gray border-bottom-gray border-right-gray" style="width:174pt;">
            <p class="text-regular padding-top-s text-center"><?php echo $result['wagePayment']; ?></p>
        </td>
        <td class="border-top-gray border-left-gray border-bottom-gray border-right-gray" style="width:65pt;">
            <p class="text-regular padding-top-s text-center">취업장소</p>
        </td>
        <td class="border-top-gray border-left-gray border-bottom-gray" style="width:110pt;">
            <p class="text-left"><?php echo $result['place']; ?></p>
        </td>
    </tr>
    <tr>
        <td class="border-top-gray border-left-gray border-bottom-gray border-right-gray" style="width:86pt;">
            <p class="text-regular padding-top-s text-center">소정근로시간</p>
        </td>
        <td class="border-top-gray border-left-gray border-bottom-gray border-right-gray" style="width:174pt;">
            <p class="text-regular padding-top-s text-center"><?php echo $result['workingHours']; ?></p>
        </td>
        <td class="border-top-gray border-left-gray border-bottom-gray border-right-gray" style="width:65pt;">
            <p class="text-regular padding-top-s text-center">종사자업무</p>
        </td>
        <td class="border-top-gray border-left-gray border-bottom-gray" style="width:110pt;">
            <p class="text-left"><?php echo $result['worker']; ?></p>
        </td>
    </tr>
    <tr>
        <td class="border-top-gray border-left-gray border-bottom-gray border-right-gray" style="width:86pt;">
            <p class="text-regular padding-top-s text-center">근로계약기간</p>
        </td>
        <td class="border-top-gray border-left-gray border-bottom-gray" colspan="3" style="width:349pt;">
            <p class="text-regular padding-top-s text-center"><?php echo $result['contractPeriod']; ?></p>
        </td>
    </tr>
    <tr>
        <td class="border-top-gray border-left-gray border-bottom border-right-gray" style="width:86pt;">
            <p class="text-regular padding-top-s text-center">기타</p>
        </td>
        <td class="border-top-gray border-left-gray border-bottom" colspan="3" style="width:349pt;">
            <p class="text-left"><?php echo $result['gita']; ?></p>
        </td>
    </tr>
</table>
<p class="text-left"><br/></p>
<table class="table margin-left-s">
    <tr>
        <td class="border-top border-bottom border-right-gray" rowspan="7" style="width:46pt;">
            <p class="text-left"><br/></p>
            <p class="text-regular padding-left-m padding-right-m line-height-m text-left">소개<br/>요금</p>
        </td>
        <td class="border-top border-left-gray border-bottom border-right-gray" rowspan="2" style="width:66pt;">
            <p class="padding-top-l text-left"><br/></p>
            <p class="text-regular padding-left-l text-left">요율제</p>
        </td>
        <td class="border-top border-left-gray border-bottom-gray border-right-gray" colspan="2" style="width:184pt;">
            <p class="text-regular padding-top-s padding-left-xl text-left">구인자 부담액</p>
        </td>
        <td class="border-top border-left-gray border-bottom-gray" style="width:185pt;">
            <p class="text-regular padding-top-s padding-left-xl text-left">구직자 부담액</p>
        </td>
    </tr>
    <tr>
        <td class="border-top-gray border-left-gray border-bottom border-right-gray" colspan="2" style="width:184pt;">
            <p class="text-regular padding-top-s padding-left-m text-left">임금의 (<span
                        class="form-field">&nbsp;<?php echo $result['guinBurdenPrice']; ?></span>)%</p>
            <p class="text-regular padding-top-l padding-left-m text-left">금액 <span
                        class="form-field"><?php echo $result['guinBurdenPrice']; ?></span>
                원</p>
        </td>
        <td class="border-top-gray border-left-gray border-bottom" style="width:185pt;">
            <p class="text-regular padding-top-s padding-left-m text-left">임금의 (<span
                        class="form-field"><?php echo $result['gujigBurden']; ?></span>)%</p>
            <p class="text-regular padding-top-l padding-left-m text-left">금액 <span
                        class="form-field"><?php echo $result['guinBurdenPrice']; ?></span>
                원</p>
        </td>
    </tr>
    <tr>
        <td class="border-top border-left-gray border-bottom border-right-gray" rowspan="2" style="width:66pt;">
            <p class="text-left"><br/></p>
            <p class="text-regular text-left">※ 회원제인 경우</p>
        </td>
        <td class="border-top border-left-gray border-bottom-gray border-right-gray" style="width:155pt;">
            <p class="text-regular padding-top-s padding-left-xxl text-left">회원기간</p>
        </td>
        <td class="border-top border-left-gray border-bottom-gray border-right-gray" style="width:132pt;">
            <p class="text-regular padding-top-s padding-left-xl text-left">구인자 월회비(원)</p>
        </td>
        <td class="border-top border-left-gray border-bottom-gray" style="width:132pt;">
            <p class="text-regular padding-top-s padding-left-xl text-left">구직자 월회비(원)</p>
        </td>
    </tr>
    <tr style="height: 120px;">
        <td class="border-top-gray border-left-gray border-bottom border-right-gray" style="width:105pt;">
            <p class="text-regular padding-top-s padding-left-m line-height-s text-left"><?php echo $result['duesDate']; ?></p>
        </td>
        <td class="border-top-gray border-left-gray border-bottom border-right-gray" style="width:132pt;">
            <p class="text-left"><?php echo $result['guinDuesPrice']; ?></p>
        </td>
        <td class="border-top-gray border-left-gray border-bottom" style="width:132pt;">
            <p class="text-left"><?php echo $result['gujigDuesPrice']; ?></p>
        </td>
    </tr>
    <tr>
        <td class="border-top border-left-gray border-bottom-light-gray border-right-gray" colspan="3"
            style="width:205pt;">
            <p class="text-regular padding-top-xs padding-left-mega text-left">소개요금 지급일자</p>
        </td>
        <td class="border-top border-left-gray border-bottom-light-gray" style="width:230pt;">
            <p class="text-regular padding-top-xs padding-left-large text-left">비 고(기타 약정)</p>
        </td>
    </tr>
    <tr style="height: 10   0px;">
        <td class="border-top-light-gray border-left-gray border-bottom-dotted border-right-gray" colspan="3"
            style="width:205pt;">
            <p class="text-m padding-left-s text-left">※ 당일일시불지급, 월별분할지급 등 당사자 간</p>
            <p class="text-m padding-top-xs padding-left-xl text-left">정한 지급일자를 기입</p>
            <?php echo $result['introductionFee']; ?>
        </td>
        <td class="border-top-light-gray border-left-gray border-bottom-dotted" style="width:230pt;">
            <p class="text-m padding-left-xs text-center">※ 소개 근로자의 중도퇴사, 일용근로자의 상용전환</p>
            <p class="text-m padding-top-xs padding-left-xs text-center">등 다툼의 소지가 있는 사항을 명시적으로 기술</p>
            <?php echo $result['bigo']; ?>
        </td>
    </tr>
    <tr>
        <td class="border-top-dotted border-left-gray border-bottom border-right-gray" colspan="3" style="width:205pt;">
            <p class="text-left"><br/></p>
        </td>
        <td class="border-top-dotted border-left-gray border-bottom" style="width:230pt;">
            <p class="text-left"><br/></p>
        </td>
    </tr>
</table>
<p class="padding-top-s padding-left-xxl text-left">위와 같이 직업소개요금에 관하여 약정하였음을 확인합니다.</p>
<p class="padding-top-xl text-left" style="height: 80px;"><br/></p>
<p class="text-s text-right"><span class="form-field">&nbsp;&nbsp;&nbsp;&nbsp;</span>년 <span class="form-field">&nbsp;&nbsp;</span>월
    <span class="form-field">&nbsp;&nbsp;</span>일</p>

<!-- 구직자 서명 부분 전체 감싸기 -->
<div class="signature-block">
    <?php if ($result['gujigImage']) { ?>
        <div class="signature_gujig_image">
            <img src="<?php echo $result['gujigImage']; ?>" alt="서명 이미지"/>
        </div>
    <?php } ?>
    <p class="text-regular vertical-align-up padding-top-m padding-left-mega text-right">
        구직자
        <span class="form-field">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
        <span class="text-xs" name="signature_gujig">(서명 또는 인)</span>
    </p>
</div>

<!-- 구직자 서명 부분 전체 감싸기 -->
<div class="signature-block">
    <?php if ($result['guinImage']) { ?>
        <div class="signature_guin_image">
            <img src="<?php echo $result['guinImage']; ?>" alt="서명 이미지"/>
        </div>
    <?php } ?>
    <p class="text-regular vertical-align-up padding-top-m padding-left-mega text-right">
        구인자
        <span class="form-field">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
        <span class="text-xs" name="signature_guin">(서명 또는 인)</span>
    </p>
</div>

<p class="padding-top-xs padding-bottom-s padding-left-mega text-right">유료직업소개사업자
    <span class="form-field">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
    <span class="text-xs vertical-align-down">(서명 또는 인)</span>
</p>

<p class="padding-left-xs text-left" style="line-height: 1pt;"></p>
<p class="text-xs text-right">210㎜×297㎜(보존용지(1종) 70g/㎡)</p>

<?php
if ($signature == false) {
    ?>
    <div class="container" style="margin-top: 140px;margin-bottom: 20px;text-align: center">
        <div align="center" class="canvas-container">
            <canvas id="drawCanvas" style="border:1px solid #000000;max-width:100%;">Canvas not supported</canvas>
        </div>
        <div align="center" style="margin-top: 15px;">
            <button id="btnClea" class="signature-btn">다시 서명</button>
            <button id="btnSave" class="signature-btn primary">저장</button>
        </div>
    </div>
    <img id="saveImg" src="" style="display:none;"/>


    <?php
}
?>
</body>
</html>

