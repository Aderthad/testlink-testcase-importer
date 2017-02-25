<?php
$smarty = new TLSmarty();
$gui = new stdClass();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once(__DIR__.'/csv2xml/Csv2Xml.php');
if (isset($_POST["submit"])) {    
    if ($_FILES["csvFile"]["size"] <= 400000) {
	$fileName = $_FILES["csvFile"]["name"];
	$fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
        if ($fileExt == 'csv') {
            $csv2Xml = new Csv2Xml();
            $filePath = $_FILES["csvFile"]["tmp_name"];
            $fileNameWoutExt = basename($fileName, $fileExt);
            $xml = $csv2Xml->createXmlFromCsv($filePath);
            sendXml($xml, $fileNameWoutExt.'xml');
        } else {
            echo plugin_lang_get('invalidFile');
        }
    } else {
        echo plugin_lang_get('fileTooBig');
    }
    return;
}

$gui->title = plugin_lang_get('title');
$gui->labelHeaderMessage = plugin_lang_get('labelHeaderMessage');

$smarty->assign('gui',$gui);
$smarty->display(plugin_file_path('import.tpl'));

function sendXml($xml, $file){    
    $output = fopen($file, "wb");
    fwrite($output, $xml);
    fclose($output);
    header('Content-Description: File Transfer');
    header('Content-Type: text/xml');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: '.filesize($file));
    readfile($file);
    unlink($file);
}