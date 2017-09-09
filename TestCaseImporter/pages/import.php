<?php
include_once(__DIR__."/CsvReader.php");
include_once(__DIR__.'/csv2xml/Csv2Xml.php');

/**
 * TestCaseImporter - https://github.com/Aderthad/testlink-testcase-importer
 * This script is distributed under the GNU General Public License 3 or later.
 *
 * This file prepares langtexts for Smarty template and handles
 * files uploaded by the user.
 */

// set debug info on
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// instantiate a new Smarty class that will hold path to the smarty template and langtexts
$smarty = new TLSmarty();
// holder object for langtexts
$gui = new stdClass();

// check whether user has uploaded a file
if (isset($_POST["submit"])) {
    // check file's size
    if ($_FILES["csvFile"]["size"] <= 400000) {
	$fileName = $_FILES["csvFile"]["name"];
        // get file's extension and check whether it is a csv file
	$fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
        if ($fileExt == 'csv') {
            $filePath = $_FILES["csvFile"]["tmp_name"];
            // read the csv file to an array
            $csv =  CsvReader::readCSV($filePath);            
            $csv2Xml = new Csv2Xml();
            // tranform the array to an XML string conforming to TestLink's
            // import xml format
            $xml = $csv2Xml->createXmlFromCsv($csv);
            $fileNameWoutExt = basename($fileName, $fileExt);
            // sends the XML file to user
            // (same file name as the original csv file but with xml extenstion)
            sendXml($xml, $fileNameWoutExt.'xml');
            // exit the script
            return;
        } else {
            // set invalid file message to be displayed
            $gui->message = plugin_lang_get('invalidFile');
        }
    } else {
        // set file too big message to be displayed
        $gui->message = plugin_lang_get('fileTooBig');
    }
}

// set plugin title message to be displayed
$gui->title = plugin_lang_get('title');
// set plugin button message to be displayed
$gui->labelHeaderMessage = plugin_lang_get('labelHeaderMessage');

// assign message holder to Smarty object
$smarty->assign('gui',$gui);
// set smarty template to be displayed
$smarty->display(plugin_file_path('import.tpl'));

/**
 * This function outputs a file (with given name and xml contents) to the user.
 * @param string $xml content of the file
 * @param string $name name of the file
 */
function sendXml($xml, $name){
    // get upload temporary folder from configuration options.
    // User under whom is the server running will always have 
    // the neccesary permissions to read/write here.
    $tempfolder = ini_get('upload_tmp_dir');
    // create full path to the file
    $file = $tempfolder . '/' . $name;
    // create the file and open it
    $output = fopen($file, "wb");
    // write given xml to the file
    fwrite($output, $xml);
    // close the file
    fclose($output);
    // set up headers
    header('Content-Description: File Transfer');
    header('Content-Type: text/xml; charset=UTF-8');
    header('Content-Disposition: attachment; filename="'.$name.'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: '.filesize($file));
    // output the file contents to the response
    readfile($file);
    // delete the file
    unlink($file);
}