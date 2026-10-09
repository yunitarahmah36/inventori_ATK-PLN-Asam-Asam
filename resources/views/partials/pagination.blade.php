{{-- 
  Template Pagination Kustom (Biru-Putih PLN)
  Mendukung LengthAwarePaginator Laravel, navigasi SPA (data-spa-link), 
  dan ikon panah proporsional sesuai standar desain aplikasi.
--}}
@if ($paginator->hasPages())
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
