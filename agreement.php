<?php

date_default_timezone_set('Asia/Seoul');

require __DIR__.'/includes/app.php';
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>소개 요금 약정서</title>
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
</head>
<body>
<div class="container">
    <h2>소개 요금 약정서</h2>

    <table>
        <tr>
            <th rowspan="4">구인자</th>
        </tr>
        <tr>
            <th>사업체 명칭</th>
            <td colspan="4"></td>
        </tr>
        <tr>
            <th>소재지</th>
            <td></td>
            <th>전화번호</th>
            <td></td>
        </tr>

        <tr>
            <th>대표자</th>
            <td></td>
            <th>업종</th>
            <td></td>
        </tr>

    </table>

    <table>
        <tr>
            <th rowspan="4">구직자</th>
        </tr>
        <tr>
            <th>성명</th>
            <td></td>
            <th>생년월일</th>
            <td></td>
        </tr>
        <tr>
            <th>주소</th>
            <td colspan="4"></td>
        </tr>
        <tr>
            <th>전화번호</th>
            <td colspan="4"></td>
        </tr>
    </table>

    <table>
        <tr>
            <th rowspan="14">계약내용</th>
        </tr>
        <tr>
            <th>임금</th>
            <td colspan="4">총액</td>
        </tr>
        <tr>
            <th>임금 지급 형태</th>
            <td>시급 / 일급 / 주급 / 월급 / 기타</td>
            <th>취업 장소</th>
            <td></td>
        </tr>
        <tr>
            <th>소정 근로 시간</th>
            <td>일 시간 / 주 시간</td>
            <th>종사자 업무</th>
            <td></td>
        </tr>
        <tr>
            <th>근로 계약 기간</th>
            <td colspan="4"> ~</td>
        </tr>
        <tr>
            <th>기타</th>
            <td colspan="4"></td>
        </tr>
    </table>

    <table>
        <tr>
            <th rowspan="14">소개요금</th>
        </tr>
        <tr>
            <th>요율제</th>
            <td colspan="3" style="padding:0px;margin:0px">
                <table style="width:100%;margin:0px;padding:0px;">
                    <tr>
                        <th>구인자 부담액</th>
                        <th>구직자 부담액</th>
                    </tr>
                    <tr>
                        <td>임금의 ( )% <br> 금액 ( 원)</td>
                        <td>임금의 ( )% <br> 금액 ( 원)</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <th rowspan="2">회원제인 경우</th>
            <th>회원기간</th>
            <th>구인자 월회비(원)</th>
            <th>구직자 월회비(원)</th>
        </tr>
        <tr>
            <td>~</td>
            <td></td>
            <td></td>
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
                        </td>
                        <td width="50%">
                            소개 근로자의 중도퇴사, 일용근로자의 사용전환등
                            다툼의 소지가 있는 사항을 명시적으로 기술
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <p>위와 같이 직업소개요금에 관하여 약정하였음을 확인합니다.</p>
    <p>년 월 일</p>
    <p>구직자 서명 또는 인: ___________</p>
    <p>구인자 서명 또는 인: ___________</p>
    <p>유료직업소개사업자 서명 또는 인: ___________</p>
</div>
</body>
</html>


