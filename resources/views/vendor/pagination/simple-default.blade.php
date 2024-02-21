@if ($paginator->hasPages())

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <button class="hover:bg-[#F8F6F6] text-black p-[10px] rounded border border-[#D1D5DB]  disabled" aria-disabled="true">
                                           @lang('pagination.previous')
                                        </button>
            @else

            <a class="hover:bg-[#F8F6F6] text-black p-[10px] rounded border border-[#D1D5DB]" href="{{ $paginator->previousPageUrl() }}" rel="prev">
               @lang('pagination.previous')
            </a>
             
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="hover:bg-[#F8F6F6] text-black p-[10px] rounded border border-[#D1D5DB]">
                                           @lang('pagination.next')
                                        </a>
            @else
            <button class="hover:bg-[#F8F6F6] text-black p-[10px] rounded border border-[#D1D5DB] disabled" aria-disabled="true">
                                            @lang('pagination.next')
                                        </button>
               
            @endif

@endif
