<?php
    include_once "../../../classes/DB.php";
    $user_id = $_GET["user"];
    $sql = "SELECT username FROM `users` WHERE id=:user_id";
    $username = DB::query($sql, array(":user_id" => $user_id))[0]["username"];
    
    $url ="../../../temp/cvs_pdf_form/OCH".$user_id." ".$username." CV.pdf";
    $content = file_get_contents($url);

    header('Content-Type: application/pdf');
    header('Content-Length: ' . strlen($content));
    header('Content-Disposition: inline; filename="YourFileName.pdf"');
    header('Cache-Control: private, max-age=0, must-revalidate');
    header('Pragma: public');
    ini_set('zlib.output_compression','0');

    die($content);
?>