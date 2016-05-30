<?php
include "cek_keberadaan_abstraksi.php";
include "tokenizing.php";
// All references to "dir" is needed to run the demo from any older folder

require_once dirname(__DIR__).DIRECTORY_SEPARATOR.'ta'.DIRECTORY_SEPARATOR.'PDFBox.php';
require_once dirname(__DIR__).DIRECTORY_SEPARATOR.'ta'.DIRECTORY_SEPARATOR.'ExtractText.php';

$jar = __DIR__.DIRECTORY_SEPARATOR."pdfbox-app-1.8.4.jar";
$pdf_box = new PDFBox\PDFBox($jar);
$extract_text = new PDFBox\ExtractText($pdf_box);

$filename = '3';

$extract_text->parse(__DIR__.DIRECTORY_SEPARATOR. $filename . '.pdf');

$content =  file_get_contents($filename . '.txt');
$abstract = $content;
//echo $abstract;

echo cek_keberadaan_abstraksi($abstract);
?>