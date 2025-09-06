@if ($paginator->hasPages())
   <div class="py-1 px-4 flex justify-end">
    <nav class="flex items-center space-x-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="text-gray-400 p-4 inline-flex items-center gap-2 font-medium rounded-md">
                    <span aria-hidden="true">«</span>
                    <span class="sr-only">Previous</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                   class="text-gray-400 hover:text-primary p-4 inline-flex items-center gap-2 font-medium rounded-md">
                    <span aria-hidden="true">«</span>
                    <span class="sr-only">Previous</span>
                </a>
            @endif

            {{-- Page Numbers --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="text-gray-400 p-4">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page"
                                  class="w-10 h-10 bg-primary text-white inline-flex items-center justify-center text-sm font-medium rounded-full">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                               class="w-10 h-10 text-gray-400 hover:text-primary inline-flex items-center justify-center text-sm font-medium rounded-full">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                   class="text-gray-400 hover:text-primary p-4 inline-flex items-center gap-2 font-medium rounded-md">
                    <span class="sr-only">Next</span>
                    <span aria-hidden="true">»</span>
                </a>
            @else
                <span class="text-gray-400 p-4 inline-flex items-center gap-2 font-medium rounded-md">
                    <span class="sr-only">Next</span>
                    <span aria-hidden="true">»</span>
                </span>
            @endif
        </nav>
    </div>
@endif
