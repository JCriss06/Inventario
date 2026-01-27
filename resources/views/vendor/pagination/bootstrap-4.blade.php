@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        <!-- Links Anteriores -->
        <div class="flex-1 flex sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-l-lg cursor-default">
                    ← Anterior
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-50 transition-colors">
                    ← Anterior
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-3 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-50 transition-colors">
                    Siguiente →
                </a>
            @else
                <span class="relative inline-flex items-center px-3 py-2 -ml-px text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-r-lg cursor-default">
                    Siguiente →
                </span>
            @endif
        </div>

        <!-- Links Desktop -->
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div class="flex gap-2">
                {{-- Link Anterior --}}
                @if ($paginator->onFirstPage())
                    <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-lg cursor-default">
                        ← Anterior
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        ← Anterior
                    </a>
                @endif

                {{-- Números de página --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-lg">
                            {{ $element }}
                        </span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Link Siguiente --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Siguiente →
                    </a>
                @else
                    <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-lg cursor-default">
                        Siguiente →
                    </span>
                @endif
            </div>
        </div>
    </nav>
@endif
