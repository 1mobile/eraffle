<?php
	$this->load->view('whole/head');
	$this->load->view('whole/body');
	if(isset($load_js))
		$this->load->view('js/'.$load_js);
	$this->load->view('whole/foot');
?>