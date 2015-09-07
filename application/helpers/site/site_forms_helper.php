<?php
function site_list_table($datatable=null,$column_id=null,$id=null,$th=array(),$searchUrl=null,$multiple=false,$listTypeDefault='list',$toExcel=null){
    $CI =& get_instance();
    $CI->make->sBox('primary',array('style'=>'-webkit-border-radius: 0px;-moz-border-radius: 0px;border-radius: 0px;'));
        $CI->make->sBoxBody(array('class'=>'no-padding'));  
            $CI->make->append('<br>');
            $data_url = 'loads/get_tbl_data/'.$datatable.'/'.$column_id;
            $targs = array('class'=>'table','id'=>$id,'data-tbl-url'=>$data_url,'search-url'=>$searchUrl);
            $targs['listyle'] = $listTypeDefault;
            $targs['listyle-multi'] = 'no';                
            if($multiple){
                $targs['listyle-multi'] = 'yes'; 
            }
                
            $targs['to-excel'] = 'no';                
            if($toExcel != ""){
                $targs['to-excel'] = $toExcel;   
            }


            $CI->make->sTable($targs);
                $CI->make->sRow(array('id'=>'rtable-ths'));
                    foreach ($th as $txt) {
                        if($txt == 'add_ctr'){
                            $CI->make->th('#',array('style'=>'width:10px;'));
                        }
                        else{
                            $CI->make->th($txt);
                        }
                    }
                $CI->make->eRow();
            $CI->make->eTable();
        $CI->make->eBoxBody();
    $CI->make->eBox();
    return $CI->make->code();
}    
function site_list_form($load_url=null,$form=null,$title_header=null,$lists=array(),$desc=null,$ref=null){
    $CI =& get_instance();
        $CI->make->sDivRow();
            $CI->make->sDivCol(3);
                $CI->make->sBox('primary');
                    $CI->make->sBoxHead();
                        $CI->make->boxTitle($title_header);
                    $CI->make->eBoxHead();
                    $CI->make->sBoxBody(array('style'=>'max-height:350px;overflow:auto'));
                        $list = array();
                        // $icon = $CI->make->icon('fa-plus');
                        $list[fa('fa-plus').' Add New'] = array('id'=>'add-new','class'=>'grp-list');
                        foreach($lists as $val){
                            $name = "";
                            if(!is_array($desc))
                              $name = $val->$desc;
                            else{
                                foreach ($desc as $dsc) {
                                   $name .= $val->$dsc." ";
                                }
                            }
                            $list[$name] = array('class'=>'grp-btn grp-list','id'=>'grp-list-'.$val->$ref,'ref'=>$val->$ref);
                        }
                        $CI->make->listGroup($list,array('id'=>'add-grp-list-div'));
                    $CI->make->eBoxBody();
                $CI->make->eBox();
            $CI->make->eDivCol();

            $CI->make->sDivCol(9);
                $CI->make->sBox('primary');
                    $CI->make->sBoxBody(array('id'=>'group-detail-con','load-url'=>$load_url));
                    $CI->make->eBoxBody();
                    $CI->make->sBoxFoot(array("style"=>"text-align:right"));
                        $CI->make->button(fa('fa-save').' Save',array('id'=>'save-list-form','class'=>'btn-primary','save-form'=>$form,'load-url'=>$load_url),'primary');
                    $CI->make->eBoxFoot();
                $CI->make->eBox();
            $CI->make->eDivCol();
        $CI->make->eDivRow();
    return $CI->make->code();
}
function siteImagesLoad($id=null,$res=null,$tbl,$folder){
    $CI =& get_instance();
        $CI->make->sForm("site/images_db/".$tbl."/".$folder,array('id'=>'images_form','enctype'=>'multipart/form-data'));
            $CI->make->hidden('form_id',$id);
            $CI->make->sDivRow();
                $img = base_url().'img/noimage.png';
                if(iSetObj($res,'img_path') != ""){                 
                    $img = base_url().$res->img_path;
                }
                $CI->make->sDivCol(12,'center');
                    $CI->make->img($img,array('class'=>'media-object thumbnail','id'=>'target','style'=>'max-height:220px;margin:0 auto;'));
                    $CI->make->file('fileUpload',array('style'=>'display:none;'));
                $CI->make->eDivCol();
            $CI->make->eDivRow();
        $CI->make->eForm();
        $CI->make->sDiv(array('style'=>'margin-top:10px;'));
            $CI->make->sDivRow();
                $CI->make->sDivCol(12,'center');
                    $CI->make->button(fa('fa-save').' Save Image',array('id'=>'save-image'),'primary');
                $CI->make->eDivCol();
            $CI->make->eDivRow();
        $CI->make->eDiv();
    return $CI->make->code();
}
?>