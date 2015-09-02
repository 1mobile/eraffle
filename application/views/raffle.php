<?php
	$this->load->view('raffle/head');
	$this->load->view('raffle/body');
	if(isset($load_js))
		$this->load->view('js/'.$load_js);
	$this->load->view('raffle/foot');
?>