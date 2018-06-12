<?php

	use App\Http\Models\Links;

	$Links= new Links;
	$affilationData=array(
			'isActive'=>1,
			'orderBy'=>'displayOrder',
			'paginate'=>5
		); 
	$resultAffilation=$Links->getByAttributesQuery($affilationData);  //Get All Links Data
	$data['affilationRecordCount']=$resultAffilation['recordCount'];				
	$data['qGetAffilationData']=$resultAffilation['data'];

?>