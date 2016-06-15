<?php
 
class PdfGenerator
{
  public function generate($html,$filename)
  {
  	// Composer's auto-loading functionality
	require "vendor/autoload.php";

	// inhibit DOMPDF's auto-loader
	define('DOMPDF_ENABLE_AUTOLOAD', false);

	//include the DOMPDF config file (required)
	require 'vendor/dompdf/dompdf/dompdf_config.inc.php';

	//if you get errors about missing classes please also add:
	require_once('vendor/dompdf/dompdf/include/autoload.inc.php');
 
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->render();
    $dompdf->stream($filename.'.pdf',array("Attachment"=>0));
  }
}
?>