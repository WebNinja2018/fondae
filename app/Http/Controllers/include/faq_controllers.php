<?php use App\Http\Models\Faq;

	$Faq= new Faq;
	$faqQuestionData=array('isActive'=>1,
						   'orderBy'=>'displayOrder'
						  );
	$resultFaqQuestion=$Faq->getByAttributesQuery($faqQuestionData);
	$data['faqQuestionRecordCount']=$resultFaqQuestion['recordCount'];
	$data['qGetFaqQuestionData']=$resultFaqQuestion['data'];
?>