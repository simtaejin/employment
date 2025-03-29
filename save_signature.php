<?php
header('Content-Type: application/json');

require __DIR__.'/includes/app.php';
use \App\Utils\Common as Common;
use \App\Model\Entity\Agreement as EntityAgreement;

function saveToDatabase($idx, $mode, $filePath) {
    if ($mode == 'guin') {
        EntityAgreement::setGuinImage($idx, $filePath);
    } else if ($mode == 'gujig') {
        EntityAgreement::setGujigImage($idx, $filePath);
    }
}


// 출력 버퍼링 시작 - 예기치 않은 출력을 방지
ob_start();

// 출력 배열 초기화
$response = array(
    'success' => false,
    'message' => '',
    'file_path' => ''
);


try {
    // 이미지 데이터와 파일명 가져오기
    if (!isset($_POST['image_data']) || !isset($_POST['filename'])) {
        throw new Exception('필수 매개변수가 없습니다.');
    }

    $idx = $_POST['idx'];
    $mode = $_POST['mode'];
    $imageData = $_POST['image_data'];
    $filename = $_POST['filename'];

    // 이미지 디렉토리 설정
    $uploadDir = 'uploads/signatures/';

    // 디렉토리가 없으면 생성
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            throw new Exception('디렉토리 생성 실패: ' . $uploadDir);
        }
    }

    // 데이터 URI에서 base64 인코딩된 데이터 추출
    $imageData = str_replace('data:image/png;base64,', '', $imageData);
    $imageData = str_replace(' ', '+', $imageData);

    // base64 디코딩
    $decodedData = base64_decode($imageData);

    if ($decodedData === false) {
        throw new Exception('이미지 데이터 디코딩 실패');
    }

    // 파일 경로 설정
    $filePath = $uploadDir . $filename;

    // 파일 저장
    if (file_put_contents($filePath, $decodedData)) {
        $response['success'] = true;
        $response['message'] = '이미지가 성공적으로 저장되었습니다.';
        $response['file_path'] = $filePath;

        saveToDatabase($idx, $mode, $filePath);

    } else {
        throw new Exception('파일 저장 실패');
    }
} catch (Exception $e) {
    $response['message'] = '오류 발생: ' . $e->getMessage();
}

// 버퍼 비우기
ob_end_clean();

// JSON 응답 반환
echo json_encode($response);
exit;

?>


