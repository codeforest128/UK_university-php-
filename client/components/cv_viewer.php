
<?php

$path = '../../../temp/uploads/';

if(isset($_GET["file"])){
    // Get parameters
    
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    $file = urldecode($_GET["file"]); // Decode URL-encoded string
    $f_name = explode(".", $file);
    $file = $f_name[0].'.pdf';

    $filepath = "../../../temp/uploads/" . $file;
    $filepath1 = "../../../temp/CVS_PDF/" . $file;

    $content1 = file_get_contents($filepath);
    $content2 = file_get_contents($filepath1);
    $content = $content1 ? $content1 : $content2;
    // print_r($file);
    // print_r($content1);
    // print_r($content2);
    if ($content == "") {
    ?>
    <!DOCTYPE html>
    <html style="font-family: 'Raleway', sans-serif;">
        <body>
            <div style="text-align: center;">
                <p style="font-size: 120%; margin-top: 2em;">No CV Uploaded</p>    
            </div>
        </body>
    </html>
    <?php
    } else {

        header('Content-Type: application/pdf');
        header('Content-Length: ' . strlen($content));
        header('Content-Disposition: inline; filename="YourFileName.pdf"');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');
        ini_set('zlib.output_compression','0');
    
        die($content);
    
    }
}
?>