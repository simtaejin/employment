<?php
require __DIR__.'/includes/app.php';

use \App\Utils\Common as Common;
use PhpOffice\PhpSpreadsheet\IOFactory;

use \App\Model\Entity\OldGuin as EntityOldGuin;


    // 읽어올 파일 경로 설정
    $filePath = './bb.XLS';

    // 파일 존재 여부 확인
    if (!file_exists($filePath)) {
        die('파일이 존재하지 않습니다: '.$filePath);
    }

    // 파일 읽기
    $spreadsheet = IOFactory::load($filePath);
    $worksheet = $spreadsheet->getActiveSheet();
    $data = $worksheet->toArray(null, true, true, true);

    $obj = new EntityOldGuin();

    foreach ($data as $rowNumber => $row) {
        if ($rowNumber > 1) {

            $obj->registrationNo = $row['A'];
            $obj->employerName = $row['B'];
            $obj->contactNo = $row['C'];
            $obj->address = $row['D'];
            $obj->receptionDate = $formattedDate = date("Y-m-d", strtotime(str_replace('/', '-', $row['E'])));
            $obj->remarks = $row['F'];
            $obj->created();
            echo $rowNumber."</br>";
        }
    }

    echo "끝";


