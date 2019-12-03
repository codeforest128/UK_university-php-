<?php
require_once('../../../../vendor/autoload.php');

use \ConvertApi\ConvertApi;

//get api key: https://www.convertapi.com/a/si
ConvertApi::setApiSecret('yVgxtPLYgRgWlScr');

$result = ConvertApi::convert('pdf', ['File' => '/fils/test.docx']);

# save to file
$result->getFile()->save('/results/newfile.pdf');

?>