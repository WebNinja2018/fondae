@if($faqQuestionRecordCount>0)
    <div class="">
        <div class="container">
            <div class="group-title-index">
                <h4 class="top-title">Answer all of your questions</h4>
                <h2 class="center-title">FREQUENTLY ASKED QUESTIONS</h2>
            </div>
            <div class="accordion-faq">
                <div class="row">
                    <div class="col-md-12">
                        <div id="accordion-2" class="panel-group accordion">
                            @foreach($qGetFaqQuestionData as $resultFaqQuestionData)
                            <div class="panel">
                                <div class="panel-heading" role="tab" id="headingThree24-{{$resultFaqQuestionData->faqID}}">
                                    <h5 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion-2" href="#collapse-2-{{$resultFaqQuestionData->faqID}}" aria-expanded="true" class="accordion-toggle collapsed"><span>{{$resultFaqQuestionData->question}}</span></a>
                                    </h5>
                                </div>
                                <div id="collapse-2-{{$resultFaqQuestionData->faqID}}" role="tabpanel" aria-labelledby="headingThree24-{{$resultFaqQuestionData->faqID}}" aria-expanded="true" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        {!!$resultFaqQuestionData->answer!!}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
	<h3>Record Not Found</h3>
@endif

<div class="back">
	<a @if(strlen(Request::server('HTTP_REFERER'))>0) href="{{URL::previous()}}" @else href="{{url('/')}}" @endif title="BACK" class="back_link">&lt; BACK</a>
</div>