<?php
header("Content-Type: application/javascript");
header("Cache-Control: max-age=604800, public");

if(!empty($_GET['file'])){
    if(isset($_GET['file'])){
        require_once 'JShrink_Minifier.php';

        $js = @file_get_contents(base64_decode($_GET['file']));

        $minifiedCode = \JShrink\Minifier::minify($js, array(
            'flaggedComments' => false
        ));

        echo $minifiedCode;
    }
}

?>
