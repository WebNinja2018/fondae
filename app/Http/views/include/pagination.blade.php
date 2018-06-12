@if ($paginator->lastPage() > 1)
    <?php /*?><ul class="pagination"><?php */?>
        <!-- si la pagina actual es distinto a 1 y hay mas de 5 hojas muestro el boton de 1era hoja -->

		
       <?php /*?> <!-- if actual page is not equals 1, and there is more than 5 pages then I show first page button -->
        @if ($paginator->currentPage() != 1 && $paginator->lastPage() >= Config::get('config.paginationLink', '3'))
            <li>
                <a href="{{ $paginator->url($paginator->url(1)) }}" class="pagination__page btn-squae">
                    &#8249;&#8249;
                </a>
            </li>
		@else
			<li><a rel="prev" href="##" class="pagination__previous btn-squae disable">&#8249;&#8249;</a></li>
        @endif<?php */?>

        <!-- si la pagina actual es distinto a 1 muestra el boton de atras -->
        @if($paginator->currentPage() != 1)
            <li>
                <a href="{{ $paginator->url($paginator->currentPage()-1) }}" class="pagination__next btn-squae">
                    &#8249;
                </a>
            </li>
		@else
			<li><a rel="prev" href="##" class="pagination__previous btn-squae disable">&#8249;</a></li>
        @endif

		<!-- if actual page is not equals 1, and there is more than 5 pages then I show first page button -->
        @if ($paginator->currentPage() != 1 && $paginator->currentPage() > Config::get('config.paginationLink', '3'))
            <li>
                <a href="{{ $paginator->url($paginator->url(1)) }}" class="pagination__page btn-squae">
                    1
                </a>
            </li>
        @endif
	
		@if ($paginator->currentPage() != 1 && $paginator->currentPage() > Config::get('config.paginationLink', '3'))
            <li>
                <a href="{{ $paginator->url($paginator->currentPage()-Config::get('config.paginationLink', '3'))}}" class="pagination__page btn-squae">
                    &#8230;
                </a>
            </li>
        @endif

        <!-- dibuja las hojas... Tomando un rango de 5 hojas, siempre que puede muestra 2 hojas hacia atras y 2 hacia adelante -->
        <!-- I draw the pages... I show 2 pages back and 2 pages forward -->
        @for($i = max($paginator->currentPage()-2, 1); $i <= min(max($paginator->currentPage()-2, 1)+(Config::get('config.paginationLink', '3')-1),$paginator->lastPage()); $i++)
                <li>
                    <a class="pagination__page btn-squae {{ ($paginator->currentPage() == $i) ? ' active' : '' }}" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </li>
        @endfor
        
        @if ($paginator->currentPage() <= $paginator->lastPage()- Config::get('config.paginationLink', '3') && $paginator->lastPage() >  Config::get('config.paginationLink', '3'))
			<li>
                <a href="{{ $paginator->url($paginator->currentPage()+Config::get('config.paginationLink', '3')) }}" class="pagination__page btn-squae">
                    &#8230;
                </a>
            </li>
		@endif
        
		<!-- Last Record -->
		@if ($paginator->currentPage() != $paginator->lastPage()  && $paginator->lastPage() > Config::get('config.paginationLink', '3'))
			<li>
                <a href="{{ $paginator->url($paginator->lastPage()) }}" class="pagination__page btn-squae">
                    {{$paginator->lastPage()}}
                </a>
            </li>
		@endif

        <!-- si la pagina actual es distinto a la ultima muestra el boton de adelante -->
        <!-- if actual page is not equal last page then I show the forward button-->
        @if ($paginator->currentPage() != $paginator->lastPage())
            <li>
                <a class="pagination__next btn-squae" href="{{ $paginator->url($paginator->currentPage()+1) }}" >
                    &#8250;
                </a>
            </li>
		@else
			<li>
				<a rel="prev" href="##" class="pagination__previous btn-squae disable">
					&#8250;
				</a>
			</li>
        @endif

        <?php /*?><!-- si la pagina actual es distinto a la ultima y hay mas de 5 hojas muestra el boton de ultima hoja -->
        <!-- if actual page is not equal last page, and there is more than 5 pages then I show last page button -->
        @if ($paginator->currentPage() != $paginator->lastPage() && $paginator->lastPage() >= Config::get('config.paginationLink', '3'))
			<li>
                <a href="{{ $paginator->url($paginator->lastPage()) }}" class="pagination__next btn-squae">
                    {{$paginator->lastPage()}}
                </a>
            </li>

            <li>
                <a class="pagination__next btn-squae" href="{{ $paginator->url($paginator->lastPage()) }}" >
                    &#8250;&#8250;
                </a>
            </li>
		@else
			<li>
				<a rel="prev" href="##" class="pagination__previous btn-squae disable">
					&#8250;&#8250; 
				</a>
			</li>
        @endif<?php */?>
    <?php /*?></ul><?php */?>
@endif