{{-- 
  Template Pagination Kustom (Biru-Putih PLN)
  Mendukung LengthAwarePaginator Laravel, navigasi SPA (data-spa-link), 
  dan ikon panah proporsional sesuai standar desain aplikasi.
--}}
@if ($paginator->hasPages())
    <style>
        .pagination-nav {
            display: flex;
            align-items: center;
        }
        .pagination-list {
            display: inline-flex !important;
            align-items: center !important;
            gap: 5px !important;
            list-style: none !important;
            margin: 0 !important;
            padding: 0 !important;
            flex-wrap: wrap !important;
        }
        .pagination-list li,
        .pagination-list .page-item {
            list-style: none !important;
            list-style-type: none !important;
            margin: 0 !important;
            padding: 0 !important;
            display: inline-flex !important;
            align-items: center !important;
            font-family: inherit !important;
        }
        .pagination-list .page-link {
            font-family: inherit !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-width: 34px !important;
            height: 34px !important;
            padding: 0 10px !important;
            border-radius: 8px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #5C3D43 !important;
            background: #FFFFFF !important;
            border: 1px solid #F2E0E4 !important;
            text-decoration: none !important;
            transition: all 0.15s ease !important;
        }
        .pagination-list .page-link:hover:not(.disabled):not(.active) {
            background: #FDF2F4 !important;
            border-color: #F7C8D3 !important;
            color: #B46A72 !important;
        }
        .pagination-list .page-item.active .page-link,
        .pagination-list .page-link.active {
            background: linear-gradient(135deg, #B46A72 0%, #9C545C 100%) !important;
            border-color: #8E474F !important;
            color: #FFFFFF !important;
            box-shadow: 0 2px 6px rgba(180, 106, 114, 0.3) !important;
        }
        .pagination-list .page-link.disabled {
            opacity: 0.5 !important;
            cursor: not-allowed !important;
            background: #FAFAFA !important;
            border-color: #F2E0E4 !important;
            color: #9C7981 !important;
        }

        .pagination-icon {
            font-size: 18px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            line-height: 1 !important;
            vertical-align: middle !important;
            user-select: none !important;
        }
        .pagination-list .page-prev,
        .pagination-list .page-next {
            gap: 4px !important;
        }

        @media (max-width: 768px) {
            .pagination-list {
                gap: 4px !important;
                justify-content: center !important;
            }
            .pagination-list .page-link {
                min-width: 32px !important;
                height: 32px !important;
                padding: 0 6px !important;
                font-size: 12px !important;
            }
            .pagination-list .page-prev .page-text,
            .pagination-list .page-next .page-text {
                display: none !important;
            }
            .pagination-list .page-prev,
            .pagination-list .page-next {
                padding: 0 6px !important;
                min-width: 32px !important;
            }
        }
    </style>
    <nav class="pagination-nav" role="navigation" aria-label="Navigasi Halaman">
        <ul class="pagination-list">
            {{-- Tombol Sebelumnya (Previous) --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="Sebelumnya">
                    <span class="page-link page-prev disabled">
                        <span class="material-symbols-outlined pagination-icon" aria-hidden="true">chevron_left</span>
                        <span class="page-text">Sebelumnya</span>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a href="{{ $paginator->previousPageUrl() }}" class="page-link page-prev" rel="prev" aria-label="Sebelumnya" data-spa-link>
                        <span class="material-symbols-outlined pagination-icon" aria-hidden="true">chevron_left</span>
                        <span class="page-text">Sebelumnya</span>
                    </a>
                </li>
            @endif

            {{-- Nomor-Nomor Halaman & Pemisah --}}
            @foreach ($elements as $element)
                {{-- Pemisah Tiga Titik (...) --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link page-ellipsis" aria-hidden="true">{{ $element }}</span>
                    </li>
                @endif

                {{-- Kumpulan Link Nomor Halaman --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link page-num active">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a href="{{ $url }}" class="page-link page-num" data-spa-link>{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Tombol Berikutnya (Next) --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a href="{{ $paginator->nextPageUrl() }}" class="page-link page-next" rel="next" aria-label="Berikutnya" data-spa-link>
                        <span class="page-text">Berikutnya</span>
                        <span class="material-symbols-outlined pagination-icon" aria-hidden="true">chevron_right</span>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="Berikutnya">
                    <span class="page-link page-next disabled">
                        <span class="page-text">Berikutnya</span>
                        <span class="material-symbols-outlined pagination-icon" aria-hidden="true">chevron_right</span>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
