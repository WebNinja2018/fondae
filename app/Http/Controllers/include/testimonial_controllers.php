<?php 
	
	use App\Http\Models\Testimonials;
	
	$Testimonials= new Testimonials;
	$testimonialData=array(
							'isActive'=>1,
							'orderBy'=>'created_at',
							'order'=>'DESC',
							'paginate'=>12
						  ); 
	$resultTestimonial=$Testimonials->getByAttributesQuery($testimonialData);  //Get All Testimonial Data
	$data['testimonialRecordCount']=$resultTestimonial['recordCount'];					
	$data['qGetTestimonialData']=$resultTestimonial['data'];	
?>