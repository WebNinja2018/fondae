<?php
	
	use App\Http\Models\Gallery;

	$Gallery= new Gallery;
	$galleryData=array(
			'isActive'=>1,
			'orderBy'=>'gallery.displayOrder',
			'paginate'=>12
		); 
	$resultGalley=$Gallery->getByAttributesQuery($galleryData);
	
	$data['galleryRecordCount']=$resultGalley['recordCount'];				
	$data['qGetGalleryData']=$resultGalley['data'];
?>