https://itrooms.tistory.com/213
https://itrooms.tistory.com/228


function saveImageToServer() {
    var canvas = document.getElementById('drawCanvas');
    var imageData = canvas.toDataURL('image/png');

    // jQuery AJAX를 사용하여 PHP 서버로 데이터 전송
    $.ajax({
        url: 'save_image.php',
        type: 'POST',
        data: { imageData: imageData },
        dataType: 'text',
        success: function(response) {
            console.log("Response: " + response);
        },
        error: function(xhr, status, error) {
            console.error("Error: " + error);
        }
    });
}


<?php
if(isset($_POST['imageData'])){
    $imageData = $_POST['imageData'];
    $filteredData = substr($imageData, strpos($imageData, ",")+1);
    $unencodedData = base64_decode($filteredData);
    
    // 저장할 파일 이름 생성 (예: 현재 시간을 사용)
    $fileName = 'image_' . time() . '.png';
    
    // 이미지를 서버에 저장
    if (file_put_contents('uploads/' . $fileName, $unencodedData)) {
        echo "이미지가 성공적으로 저장되었습니다: " . $fileName;
    } else {
        echo "이미지 저장 중 오류가 발생했습니다.";
    }
} else {
    echo "이미지 데이터가 전송되지 않았습니다.";
}
?>

https://ttowa.tistory.com/entry/JS-%EC%9B%B9Mobile%EC%97%90%EC%84%9C-SMS-%EB%AC%B8%EC%9E%90%EB%B3%B4%EB%82%B4%EA%B8%B0#google_vignette

소개요금약정서

https://moongift.tistory.com/entry/PHP%EC%97%90%EC%84%9C-html%EC%9D%84-PDF%EB%A1%9C-%EB%A7%8C%EB%93%A4%EA%B8%B0
