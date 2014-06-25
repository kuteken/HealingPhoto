<?php
require_once 'HTTP/Request2.php';

// 顔検出WebAPIサンプル(PHP)
// 【動作確認バージョン】
// PHP 5.4.7
// 【注意事項】
// HTTP_Request2を利用しています。
// $api_keyには発行されたAPIキーを指定してください
//
class PostImageFace
{
    // リクエストドメイン
    const REQ_URL = "http://eval.api.pux.co.jp:8080";
    // リクエストパス
    const REQ_PATH = "/webapi/face.do";

    // inputFile での送信(multipart/form-data)
    // $input : 画像のファイルパス
    function PostFileSend($api_key, $input){

        // POSTリクエストの生成
        $request = new HTTP_Request2();
        $request->setMethod( HTTP_Request2::METHOD_POST );
        $request->setURL( self::REQ_URL . self::REQ_PATH );

        // PARTデータの設定
        $request->addPostParameter("apiKey", $api_key);
        $request->addPostParameter("enjoyJudge", 1);
        // 画像データの設定
        $request->addUpload('inputFile', $input, "test.jpg", "image/jpeg");

        try {

            // リクエスト発行
            $response = $request->send();

            if (200 == $response->getStatus() || 201 == $response->getStatus() ) {
                // 正常のときXMLオブジェクトにする
                $xml = simplexml_load_string($response->getBody());
                // XML操作
                echo "<pre>";
                var_dump (
                    $xml->faceRecognition->detectionFaceInfo->genderJudge,
                    $xml->faceRecognition->detectionFaceInfo->ageJudge,
                    $xml->faceRecognition->detectionFaceInfo->enjoyJudge
                );
                echo "</pre>";
                $result['gender'] = $xml->faceRecognition->detectionFaceInfo->genderJudge->genderResult;
                $result['age']    = $xml->faceRecognition->detectionFaceInfo->ageJudge->ageResult;
                $result['animal'] = $xml->faceRecognition->detectionFaceInfo->enjoyJudge->similarAnimal;
            } else {
                // エラーの表示
                echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
                        $response->getReasonPhrase(). ' ' . $response->getBody();
            }
        } catch (HTTP_Request2_Exception $e) {
            // リクエスト発行の例外
            echo 'Error: ' . $e->getMessage();
        }

        return $result;

    }
}

// パラメータを指定
$api_key = "";
$imageURL = "http://st1.pux.co.jp/test/480x640_w1.jpg";
if (isset($_FILES['img'])) {
    $imageFile = $_FILES['img']['tmp_name'];
}
$instance = new PostImageFace();
$result = $instance->PostFileSend($api_key, $imageFile);
if ($_POST['type'] == 'animal') {
    $tag = ($result['animal'] != 'unknown') ? $result['animal'] : 'people';
} else {
    $tag = ($result['gender'] == 0) ? 'sexygirl' : 'child';
    $tag = ($result['age'] > 50) ? 'nature' : $tag;
}

header('Location: /500px.html?tag=' . $tag);

?>
