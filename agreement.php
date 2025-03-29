<?php

date_default_timezone_set('Asia/Seoul');

require __DIR__.'/includes/app.php';
use \App\Utils\Common as Common;

$idx= $_REQUEST['idx'];
$result = Common::getAgreement($idx);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            border: 1px solid #000;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
        }

        @media print {
            /* 페이지 크기 설정: A4(210mm x 297mm)에 맞추기 */
            @page {
                size: A4;
                margin: 20mm; /* 페이지 여백 설정 (적절히 조정 가능) */
            }

            /* 프린트에만 적용될 스타일 */
            body {
                margin: 0;
                padding: 0;
                font-size: 12px;
            }

            .container {
                width: 100%;
                max-width: 170mm; /* A4 너비에서 여백(20mm씩)을 제외한 크기 */
                margin: auto;
                border: none; /* 출력 시 테두리 제거 가능 */
                padding: 0px; /* 여백 설정 */
            }

            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }

            th, td {
                padding: 4px; /* 출력 시 테이블 내부 여백 최소화 */
            }
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

<div class="container">
    <h2>소개 요금 약정서</h2>

    <table>
        <tr>
            <th rowspan="4" style="width: 100px;">구인자</th>
        </tr>
        <tr>
            <th style="width:150px;">사업체 명칭</th>
            <td colspan="4"><?php echo $result['business'];?></td>
        </tr>
        <tr>
            <th style="width:150px;">소재지</th>
            <td style="width:180px;"><?php echo $result['guinJibunAddress'];?></td>
            <th style="width:150px;">전화번호</th>
            <td style="width:180px;"><?php echo $result['guinPhoneNumber_1'];?></td>
        </tr>

        <tr>
            <th>대표자</th>
            <td><?php echo $result['guinName'];?></td>
            <th>업종</th>
            <td><?php echo $result['industry'];?></td>
        </tr>

    </table>

    <table>
        <tr>
            <th rowspan="4" style="width: 100px;">구직자</th>
        </tr>
        <tr>
            <th style="width:150px;">성명</th>
            <td style="width:180px;"><?php echo $result['gujigName'];?></td>
            <th style="width:150px;">생년월일</th>
            <td style="width:180px;"><?php echo $result['birthdate'];?></td>
        </tr>
        <tr>
            <th>주소</th>
            <td colspan="4"><?php echo $result['gujigJibunAddress'];?></td>
        </tr>
        <tr>
            <th>전화번호</th>
            <td colspan="4"><?php echo $result['gujigPhoneNumber_1'];?></td>
        </tr>
    </table>

    <table>
        <tr>
            <th rowspan="14" style="width: 100px;">계약내용</th>
        </tr>
        <tr>
            <th style="width:150px;">임금</th>
            <td colspan="4">총액 <?php echo $result['pay'];?>원 </td>
        </tr>
        <tr>
            <th>임금 지급 형태</th>
            <td style="width:180px;"><?php echo $result['wagePayment'];?></td>
            <th style="width:150px;">취업 장소</th>
            <td style="width:180px;"><?php echo $result['place'];?></td>
        </tr>
        <tr>
            <th>소정 근로 시간</th>
            <td><?php echo $result['workingHours'];?></td>
            <th>종사자 업무</th>
            <td><?php echo $result['worker'];?></td>
        </tr>
        <tr>
            <th>근로 계약 기간</th>
            <td colspan="4"><?php echo $result['contractPeriod'];?></td>
        </tr>
        <tr>
            <th>기타</th>
            <td colspan="4"><?php echo $result['gita'];?></td>
        </tr>
    </table>

    <table>
        <tr>
            <th rowspan="14" style="width: 100px;">소개요금</th>
        </tr>
        <tr>
            <th style="width:150px;">요율제</th>
            <td colspan="3" style="padding:0px;margin:0px">
                <table style="width:100%;margin:0px;padding:0px;">
                    <tr>
                        <th>구인자 부담액</th>
                        <th>구직자 부담액</th>
                    </tr>
                    <tr>
                        <td>임금의 (<?php echo $result['guinBurdenPrice'];?>)% <br> 금액 (<?php echo $result['guinBurdenPrice'];?>원)</td>
                        <td>임금의 (<?php echo $result['gujigBurden'];?>)% <br> 금액 (<?php echo $result['guinBurdenPrice'];?>원)</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <th rowspan="2">회원제인 경우</th>
            <th style="width:170px;">회원기간</th>
            <th style="width:170px;">구인자 월회비(원)</th>
            <th style="width:170px;">구직자 월회비(원)</th>
        </tr>
        <tr>
            <td><?php echo $result['duesDate'];?></td>
            <td><?php echo $result['guinDuesPrice'];?></td>
            <td><?php echo $result['gujigDuesPrice'];?></td>
        </tr>
        <tr>
            <td colspan="4" style="padding:0px;margin:0px">
                <table style="width:100%;margin:0px;padding:0px;">
                    <tr>
                        <th>소개요금 지급일자</th>
                        <th>비 고 (기타 일정)</th>
                    </tr>
                    <tr>
                        <td width="50%">
                            당일일시불지급, 월별분할지급
                            등 당사자 간정한 지급일자를 기입
                            <?php echo $result['introductionFee'];?>
                        </td>
                        <td width="50%">
                            소개 근로자의 중도퇴사, 일용근로자의 사용전환등
                            다툼의 소지가 있는 사항을 명시적으로 기술
                            <?php echo $result['bigo'];?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table  class="small-height">
        <tr>
            <td colspan="4"><p>위와 같이 직업소개요금에 관하여 약정하였음을 확인합니다.</p></td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: right"><p><?php echo $result['checkDateY'];?>년  <?php echo $result['checkDateM'];?>월  <?php echo $result['checkDateD'];?>일</p></td>
        </tr>
        <tr>
            <td class="blanktd"></td>
            <td class="signature_label"><p>구직자</p></td>
            <td class="signature_name"></td>
            <td class="signature_in">(서명 또는 인)</td>
        </tr>
        <tr>
            <td class="blanktd"></td>
            <td class="signature_label"><p>구인자</p></td>
            <td class="signature_name"></td>
            <td class="signature_in">(서명 또는 인)</td>
        </tr>
        <tr>
            <td class="blanktd"></td>
            <td class="signature_label"><p>유료직업소개사업자</p></td>
            <td class="signature_name"></td>
            <td class="signature_in">(서명 또는 인)</td>
        </tr>
    </table>

</div>

<div class="container" style="margin-top: 20px;margin-bottom: 20px;text-align: center">
    <div align="center">
        <canvas id="drawCanvas" width="320" height="320" style="border:1px solid #000000;">Canvas not supported</canvas>
    </div>
    <div align="center" style="margin-top: 15px;">
        <button id="btnClea" class="signature-btn">다시 서명</button>
        <button id="btnSave" class="signature-btn primary">저장</button>
    </div>
</div>
<img id="saveImg" src="" style="display:none;"/>



<style>
    .signature-btn {
        padding: 10px 20px;
        margin: 0 5px;
        border-radius: 5px;
        border: 1px solid #ddd;
        background-color: #f8f8f8;
        color: #333;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
        /*border: 0px solid #FFFFFF;*/
        border: 1px solid red;
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

</style>




</body>
</html>
