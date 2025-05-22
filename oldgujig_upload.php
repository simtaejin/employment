<?php
require __DIR__.'/includes/app.php';

use \App\Utils\Common as Common;
use PhpOffice\PhpSpreadsheet\IOFactory;

use \App\Model\Entity\OldGujig as EntityOldGujig;

try {
    // 읽어올 파일 경로 설정
    $filePath = './oldgujig.XLS';

    // 파일 존재 여부 확인
    if (!file_exists($filePath)) {
        die('파일이 존재하지 않습니다: '.$filePath);
    }

    // 파일 읽기
    $spreadsheet = IOFactory::load($filePath);
    $worksheet = $spreadsheet->getActiveSheet();
    $data = $worksheet->toArray(null, true, true, true);

    $obj = new EntityOldGujig();

    foreach ($data as $rowNumber => $row) {
        if ($rowNumber > 1) {
            $obj->receptionNo = $row['A'];
            $obj->name = $row['B'];
            $obj->ssn = $row['C'];
            $obj->age = $row['D'];
            $obj->receptionDate = $formattedDate = date("Y-m-d", strtotime(str_replace('/', '-', $row['E'])));
            $obj->contactNo = $row['F'];
            $obj->desiredJob = $row['G'];
            $obj->postalCode = $row['H'];
            $obj->address = $row['I'];
            $obj->remarks = $row['J'];
            $obj->infoDisclosure = $row['K'];
            $obj->memberType = $row['L'];
            $obj->nationalityStatus = $row['M'];
            $obj->bankAccount = $row['N'];
            $obj->foreignName = $row['O'];
            $obj->residencyExpiry = $row['P'];
            $obj->country = $row['Q'];
            $obj->visaType = $row['R'];
            $obj->healthCertificate = $row['S'];
            $obj->healthCertExpiry = $row['T'];
//            $obj->created();
        }
    }

    echo "끝";


} catch (Exception $e) {
    die('파일 읽기 중 오류가 발생하였습니다: '.$e->getMessage());
}
