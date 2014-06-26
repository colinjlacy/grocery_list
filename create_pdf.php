<?php
session_start();

// Check that the user is logged in
if (!(isset($_SESSION['user_loggedin']))) {

    header('Location: /grocery_list/');
}

// Include the main TCPDF library.
require_once('lib/tcpdf/tcpdf.php');
require_once('class/PDF.php');

$creator = new \classes\PDF();

$list = $creator->data_pull();
$config = $creator->pdf_config();
$log = "pdf_log.log";

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator($config['creator']);
$pdf->SetAuthor($config['author']);
$pdf->SetTitle($list['title']);
$pdf->SetSubject($list['title'].", A Grocery List");
$pdf->SetKeywords($config['keywords']);

// remove default header
$pdf->setPrintHeader(false);
//$pdf->setPrintFooter(false);

// set footer config
$pdf->setFooterData(array(180,180,180), array(200,200,200));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, 'B', PDF_FONT_SIZE_DATA));
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set margins
$pdf->SetMargins($config['left_margin'], $config['top_margin'], $config['right_margin']);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 10);

// add a page
$pdf->AddPage();

// define some HTML content with style
$html = $creator->templatize_data($list, $_SESSION['username']);

//$creator->logging($log, $html);

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

//Close and output PDF document
$pdf->Output($list['title'].'.pdf', 'I');

