<?php
function codeSearchForm($post=array()){
	$CI =& get_instance();
	$CI->make->sForm();
		$CI->make->sDivRow();
			$CI->make->sDivCol(6);
				$CI->make->input('Code','code',null,null);
				$CI->make->input('Email','email',null,null);
			$CI->make->eDivCol();
			$CI->make->sDivCol(6);
				$CI->make->date('Redeem Date','datetime',null,null);
			$CI->make->eDivCol();
    	$CI->make->eDivRow();
	$CI->make->eForm();
	return $CI->make->code();
}
function codeUploadForm($post=array()){
	$CI =& get_instance();
		$CI->make->sDivRow();
			$CI->make->sDivCol(8,'left','2');
				$CI->make->sBox('solid');
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol(12);
								$CI->make->sForm(base_url().'codes/upload_excel_codes',array('id'=>'upload_form','enctype'=>"multipart/form-data"));
									$CI->make->H(3,'Select Code  Excel File',array('class'=>'page-header'));
									$CI->make->file('fileUpload',array('class'=>'rOkay','ro-msg'=>'Please select file'));
								$CI->make->eForm();
							$CI->make->eDivCol();
				    	$CI->make->eDivRow();
						$CI->make->H(3,null,array('class'=>'page-header'));
						$CI->make->sDivRow();
							$CI->make->sDivCol(12,'right');
								$CI->make->button(fa('fa-upload')." Upload File",array('id'=>'uploader-file','style'=>'margin-right:10px;'),'success');

								$CI->make->button(fa('fa-download')." Download Code Excel Template",array('id'=>'dl-temp-excel'),'info');
							$CI->make->eDivCol();
				    	$CI->make->eDivRow();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	return $CI->make->code();
}

function codeConfirmForm($post=array()){
	$CI =& get_instance();
	$CI->make->sForm();
		$CI->make->sDivRow();
			$CI->make->sDivCol(6);

				$CI->make->input('Code','code',null,null);
				$CI->make->input('Email','email',null,null);
			$CI->make->eDivCol();
			$CI->make->sDivCol(6);
				$CI->make->date('Redeem Date','datetime',null,null);
			$CI->make->eDivCol();
    	$CI->make->eDivRow();
	$CI->make->eForm();
	return $CI->make->code();
}
?>