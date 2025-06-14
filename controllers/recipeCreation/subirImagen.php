<?php
    session_start();
    $folderImg = "/makefs/mediaDb/recipeImages";

    $imagen = $_FILES["imagenR"];
    $tipo = $_FILES["imagenR"]["type"];

    if($tipo =='image/gif' || $tipo =='video/mp4' || $tipo =='video/webm' || $tipo =='video/flv'){
        echo json_encode(array("msg"=>"error_unsuported_type"));
        exit;
    }
    
    if ($_FILES["imagenR"]["size"] > 3000000){
        echo json_encode(array("msg"=>"error_too_large"));
        exit;
    }

    if($tipo == 'image/jpeg' || $tipo == 'image/png'){
        $resultado = move_uploaded_file($imagen["tmp_name"], $folderImg.'/chef-'.$_SESSION["chefid"].$imagen["name"]);
        if ($resultado) {
            http_response_code(200);
            $jsonEcho = json_encode(array("msg"=>"success_200"));
            echo $jsonEcho;
        } else {
            echo json_encode(array("msg"=>"error_upload"));
        }
    }else{
        echo json_encode(array("msg"=>"error_unsuported_type"));
        exit;
    }
?>