<div class="col-sm-6 col-md-6 col-xs-6">
	<div class="row">
        @if ($paginator->lastPage() > 1)
            <ul class="pagination">
                <!-- si la pagina actual es distinto a 1 y hay mas de 5 hojas muestro el boton de 1era hoja -->
                <!-- if actual page is not equals 1, and there is more than 5 pages then I show first page button -->
                @if ($paginator->currentPage() != 1 && $paginator->lastPage() >= Config::get('config.paginationLink', '3'))
                    <li>
                        <a href="{{ $paginator->url($paginator->url(1)) }}" >
                            <i class="fa fa-angle-double-left" aria-hidden="true"></i> First 
                        </a>
                    </li>
                @endif
        
                <!-- si la pagina actual es distinto a 1 muestra el boton de atras -->
                @if($paginator->currentPage() != 1)
                    <li>
                        <a href="{{ $paginator->url($paginator->currentPage()-1) }}" >
                           <i class="fa fa-angle-left" aria-hidden="true"></i>  Previous
                        </a>
                    </li>
                @endif
        
                <!-- dibuja las hojas... Tomando un rango de 5 hojas, siempre que puede muestra 2 hojas hacia atras y 2 hacia adelante -->
                <!-- I draw the pages... I show 2 pages back and 2 pages forward -->
                @for($i = max($paginator->currentPage()-2, 1); $i <= min(max($paginator->currentPage()-2, 1)+(Config::get('config.paginationLink', '3')-1),$paginator->lastPage()); $i++)
                        <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                            <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                        </li>
                @endfor
        
                <!-- si la pagina actual es distinto a la ultima muestra el boton de adelante -->
                <!-- if actual page is not equal last page then I show the forward button-->
                @if ($paginator->currentPage() != $paginator->lastPage())
                    <li>
                        <a href="{{ $paginator->url($paginator->currentPage()+1) }}" >
                            Next <i class="fa fa-angle-right" aria-hidden="true"></i>
                        </a>
                    </li>
                @endif
        
                <!-- si la pagina actual es distinto a la ultima y hay mas de 5 hojas muestra el boton de ultima hoja -->
                <!-- if actual page is not equal last page, and there is more than 5 pages then I show last page button -->
                @if ($paginator->currentPage() != $paginator->lastPage() && $paginator->lastPage() >= Config::get('config.paginationLink', '3'))
                    <li>
                        <a href="{{ $paginator->url($paginator->lastPage()) }}" >
                            Last <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                        </a>
                    </li>
                @endif
            </ul>
        @endif
    </div>
</div>
<?php 
if($paginator->currentPage()==1 && $paginator->currentPage() != $paginator->lastPage()){
$CurrentPageFirstRecored=1;
$CurrentPageLastRecored=$paginator->perPage();
}elseif($paginator->currentPage() == $paginator->lastPage()){
$CurrentPageFirstRecored=($paginator->perPage()*($paginator->currentPage()-1))+1;
$CurrentPageLastRecored=$paginator->total();
}else{
$CurrentPageFirstRecored=($paginator->perPage()*($paginator->currentPage()-1))+1;
$CurrentPageLastRecored=$paginator->perPage()*$paginator->currentPage();
}
?>
@if($paginator->total()>0)
 <div class="col-sm-6 col-md-6 col-xs-6 pull-right text-left showing_text">
	<div class="row">
		<b>Showing {{$CurrentPageFirstRecored}} to {{$CurrentPageLastRecored}} of {{$paginator->total()}} entries</b>
	</div>
</div> 
@endif