<div class="row">

        <div class="col-sm-5 text-left">
          <small class="text-muted inline m-t-sm m-b-sm">
            Hiển thị kết quả từ 
            @if($paginator->count() == 5)
              {{$paginator->currentPage()*$paginator->count() - $paginator->count() + 1}} - {{$paginator->currentPage()*$paginator->count()}}
            @else

              {{($paginator->currentPage() - 1)* 5 + 1}} - {{$paginator->total()}}

            @endif
             của {{$paginator->total()}}.
           </small>
        </div>
        <!--Pagination-->
        <div class="col-sm-7 text-right text-center-xs">
          @if ($paginator->hasPages())
          <ul class="pagination pagination-sm m-t-none m-b-none">
            <!--pre page-->
            @if (!$paginator->onFirstPage())
            <li>
              <a href="{{ $paginator->url(0) }}">
                    <i class="fa fa-chevron-left"></i><i class="fa fa-chevron-left"></i>
                </a>
            </li>
            @endif
            <!--end pre page-->

            <!--numbers page-->
            @foreach ($elements as $element)
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                      @if ($page == $paginator->currentPage())    
                    <li>
                        <a href="{{ $paginator->url($page) }}" style="background:#d19a98; color: white;">
                        {{$page}}
                      </a>
                    </li>
                      @else
                      <li>
                        <a href="{{ $paginator->url($page) }}">
                        {{$page}}
                      </a>
                    </li>
                      @endif
                    @endforeach
                  @endif
              @endforeach
            <!--endnumbers page-->

            <!--next page-->
            @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->url($paginator->lastPage()) }}">
                  <i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i>
                </a>
              </li> 
            @endif
            <!--end next page-->
          </ul>
          @endif
            
        </div>
      </div>