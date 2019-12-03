<?php
echo "google-cv loaded in";

include "../classes/vendor/autoload.php";

// namespace Google\Cloud\Samples\Vision;

use Google\Cloud\Vision\V1\ImageAnnotatorClient;

class CVParser {
    public function detect_document_text() {
    
    echo "function initiated";
    $path = "../temp/uploads/OCH838 George Cherry CV.pdf";
    try {
        $imageAnnotator = new ImageAnnotatorClient();
    } catch (Exception $e) {
        echo "Couldn't create annotator";
    }
    # annotate the image
    try {
        $image = file_get_contents($path);
    } catch (Exception $e) {
        echo "Couldn't read in cv";
    }
    try {
        $response = $imageAnnotator->documentTextDetection($image);
    } catch (\Exception $e) {
        echo "No response received from server";
    }
    try {
        $annotation = $response->getFullTextAnnotation();
    } catch (Exception $e) {
        echo "Couldn't parse annotation";
    }

    # print out detailed and structured information about document text
    if ($annotation) {
        foreach ($annotation->getPages() as $page) {
            foreach ($page->getBlocks() as $block) {
                $block_text = '';
                foreach ($block->getParagraphs() as $paragraph) {
                    foreach ($paragraph->getWords() as $word) {
                        foreach ($word->getSymbols() as $symbol) {
                            $block_text .= $symbol->getText();
                        }
                        $block_text .= ' ';
                    }
                    $block_text .= "\n";
                }
                echo 'Block content: %s' . $block_text;
                echo 'Block confidence: %f' . PHP_EOL . $block->getConfidence();
            }
        }
    } else {
        echo 'No text found';
    }
    $imageAnnotator->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Testing -- CV Parsing</title>
</head>
<body>
<?php
    $cvparser = new CVParser();
    try {
        $cvparser->detect_document_text();
    } catch (Exception $e) {
        echo "Stuff went wrong";
    }
?>
</body>
</html>