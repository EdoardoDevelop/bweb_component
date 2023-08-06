<?php
header("Content-type: text/css");

class CSSmini {

    /**
     * Array of CSS files path
     **/
    private $cssPath = array();


    /**
     * Initialize the class, optionally set the array of css paths
     **/
    public function __construct($cssFilesPath = array()){
        if (is_array($cssFilesPath) && !empty($cssFilesPath)){
            $this->cssPath = $cssFilesPath;
        }
    }

    /**
     * Add the path of a css file to stack.
     * @param file of CSS file
     **/
    public function addFile($cssFilePath){
        $this->cssPath[] = $cssFilePath;
    }

    /**
     * Minify the current css files added.
     * If no css path is set throws error and exit.
     **/
    public function minify(){
        $allCss = array();
        if (empty($this->cssPath)){
            echo "No CSS was added";
            exit; // maybe you will have a better error handler
        }

        foreach($this->cssPath as $css){
            // make sure its a css file
            $bits = explode(".",$css);
            /*$extention = $bits[count($bits)-1];
            if ($extention !== "css") {
                echo "Only CSS allowed";
                exit; // or better error handling
            }*/
            $file = @file_get_contents($css);
            $file = $this->remove_spaces($file);
            $file = $this->remove_css_comments($file);
            $allCss[] = $file;
        }

        return implode("\n",$allCss);
    }

    /**
     * Remove unnecessary spaces from a css string
     * @param String $string
     * @return String
     **/
    private function remove_spaces($string){
        $string = preg_replace("/\s{2,}/", " ", $string);
        $string = str_replace("\n", "", $string);
        $string = str_replace('@CHARSET "UTF-8";', "", $string);
        $string = str_replace(', ', ",", $string);
        return $string;
    }

    /**
     * Remove all comments from css string
     * @param String $css
     * @return String
     **/
    private function remove_css_comments($css){
        $file = preg_replace("/(\/\*[\w\'\s\r\n\*\+\,\"\-\.]*\*\/)/", "", $css);
        return $file;
    }
}
if(!empty($_GET['file'])){
    if(isset($_GET['file'])){
        $minifier = new CSSmini();

        $minifier->addFile(base64_decode($_GET['file']));
        echo $minifier->minify();
    }
}
?>