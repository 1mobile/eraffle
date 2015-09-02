<?php
function settingsForm($det=array()){
	$CI =& get_instance();
	$CI->make->sTab();
        $tabs = array(
            fa('fa-envelope')." Emails" => array('href'=>'#emails','class'=>'tab_link','load'=>'item/details_load','id'=>'details_link'),
            fa('fa-circle-thin')." Raffle" => array('href'=>'#raffle','class'=>'tab_link','load'=>'item/details_load','id'=>'details_link'),
        );
        $CI->make->tabHead($tabs,null,array());
        $CI->make->sTabBody();
            $CI->make->sTabPane(array('id'=>'emails','class'=>'tab-pane active'));
                $CI->make->sForm("settings/db",array('id'=>'email_form'));
                    $CI->make->H(4,"Email Notifications",array('class'=>'page-header'));
                    $CI->make->sDivRow();
                        $CI->make->sDivCol(6);
                            $CI->make->textarea('Code Redeem Message','code_redeem_msg',iGetObj($det,'code','code_redeem_msg','value'),'Type Name',array('class'=>'rOkay'));
                        $CI->make->eDivCol();
                        $CI->make->sDivCol(6);
                            $CI->make->textarea('Item Redeem Message','item_redeem_msg',iGetObj($det,'code','item_redeem_msg','value'),'Type Name',array('class'=>'rOkay'));
                        $CI->make->eDivCol();
                    $CI->make->eDivRow();
                    $CI->make->H(4,"",array('class'=>'page-header'));
                    $CI->make->sDivRow();
                	    $CI->make->sDivCol(4,'left',4);
                	        $CI->make->button(fa('fa-save')." Save Details",array('id'=>'save-email-btn','class'=>'btn-block'),'success');
                	    $CI->make->eDivCol();
                	$CI->make->eDivRow();
                $CI->make->eForm();
            $CI->make->eTabPane();
            $CI->make->sTabPane(array('id'=>'raffle','class'=>'tab-pane'));
                $CI->make->H(4,"Configuration",array('class'=>'page-header'));
                $CI->make->sForm("settings/db",array('id'=>'raffle_form'));
                    $CI->make->sDivRow();
                        $CI->make->sDivCol(6);
                            $CI->make->input('Raffle Delay','raffle_delay',iGetObj($det,'code','raffle_delay','value'),'Type Name',array('class'=>'rOkay'));
                        $CI->make->eDivCol();
                    $CI->make->eDivRow();
                    $CI->make->H(4,"",array('class'=>'page-header'));
                    $CI->make->sDivRow();
                        $CI->make->sDivCol(4,'left',4);
                            $CI->make->button(fa('fa-save')." Save Details",array('id'=>'save-raffle-btn','class'=>'btn-block'),'success');
                        $CI->make->eDivCol();
                    $CI->make->eDivRow();
                $CI->make->eForm();
            $CI->make->eTabPane();
        $CI->make->eTabBody();
    $CI->make->eTab();
	return $CI->make->code();
}
?>