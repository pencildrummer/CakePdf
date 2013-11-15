<?php
App::uses('AbstractPdfEngine', 'CakePdf.Pdf/Engine');
App::uses('Multibyte', 'I18n');

class MpdfEngine extends AbstractPdfEngine {

/**
 * Constructor
 *
 * @param $Pdf CakePdf instance
 */
	public function __construct(CakePdf $Pdf) {
		parent::__construct($Pdf);
		App::import('Vendor', 'CakePdf.Mpdf', array('file' => 'mpdf' . DS . 'mpdf.php'));
	}

/**
 * Generates Pdf from html
 *
 * @return string raw pdf data
 */
	public function output() {
		//mPDF often produces a whole bunch of errors, although there is a pdf created when debug = 0
		//Configure::write('debug', 0);
		$format = $this->_Pdf->pageSize();
		if ($this->_Pdf->orientation() == 'landscape')
			$format .= '-L';
		$MPDF = new mPDF($this->_Pdf->encoding(), $format);
		$MPDF->writeHTML($this->_Pdf->html());
		return $MPDF->Output('', 'S');
	}

}