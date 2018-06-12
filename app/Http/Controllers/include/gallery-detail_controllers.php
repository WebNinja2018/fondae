<?php

	use App\Http\Models\Gallery;
	use App\Http\Models\Images;

	$Gallery= new Gallery;
	$galleryData=array('url_title'=>$urlName,'isActive'=>1);
	$resultGalley=$Gallery->getByAttributesQuery($galleryData);
	$data['qGetGalleryData'] = $resultGalley['data'];
	$data['galleryRecordCount'] = $resultGalley['recordCount'];
	if($data['galleryRecordCount']==0){
		return Redirect::fun_redirect(url('/').'/gallery');
	}
	
	$Images= new Images;
	$imageData=array(
					'itemID'=>$resultGalley['data'][0]->galleryID, 
					'imagesTypeID'=>Config::get('config.galleryImageTypeID','1'),
					'isActive'=>1,
					'orderBy'=>'displayOrder',
					'paginate'=>12
					);
	$resultImages=$Images->getByAttributesQuery($imageData);
	
	$data['qGetImagesData'] = $resultImages['data'];
	$data['imagesRecordCount'] = $resultImages['recordCount'];
?>