<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nesnelerin Interneti</title>
    <link rel="stylesheet" href="./vendor/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="./vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="./vendor/jsgrid/jsgrid.min.css" />
    <link rel="stylesheet" href="./vendor/jsgrid/jsgrid-theme.min.css" />
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body class="sidebar-fixed header-fixed">


<!-- Dialog -->
<div class="modal fade" id="ModalDialog" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="ModalDialogLabel"></h4>
        </div>
        <div class="modal-body" id="ModalDialogMessage">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" id="ModalDialogButton">Tamam</button>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!--ShowDialog("Info", "Message", callback); -->
<!-- Dialog Question-->
<div class="modal fade" id="ModalQuestionDialog" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            ?
        </div>
        <div class="modal-body" id="ModalQuestionDialogMessage">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" data-dismiss="modal" id="btnModalQuestionDialogYes">Evet</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal" id="btnModalQuestionDialogNo">Hayır</button>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!--QuestionDialog("Message", yesCallback, noCallback); -->

<?php
// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value
function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();
    $url = "http://localhost/proje1/api/v1/controller/".$url;

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }
    // Optional Authentication:
    $headers = [
        'Content-type: application/json; charset=UTF-8',
        'access_token:'.$_COOKIE['access_token']
    ];
    //var_dump($headers);
    //echo "URL=".$url;

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTP_VERSION,  CURL_HTTP_VERSION_1_1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($curl);
    if(!curl_exec($curl)){
        die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
    }

    curl_close($curl);

    return json_decode($result);
}

function GetApiData($json)
{
    $result = array();
    
    if($json->Success)
    {
        $result = $json->Data; 
    }

    return $result;
}
?>