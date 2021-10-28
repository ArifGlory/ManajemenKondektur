<div class="btn-group btn-group-sm" role="group" data-toggle="tooltip" data-placement="top" title="" data-original-title=".btn-xlg">
    @isset($prepend)
        {!! $prepend !!}
    @endisset
    @if(!$item->deleted_at)
        @if (stripos($button, 'L') !== false)
           <a href="{{ $lihat }}" data-url="{{ $lihat }}" class="btn btn-edit btn-success btn-mini waves-effect waves-light"><span
                            class="fal fa-eye"></span> Lihat</a>
        @endif
        @if (stripos($button, 'E') !== false)
            <a @if(stripos($button, 'F') !== false) onclick="edit('{{ $edit }}')" @endif href="{{ $edit }}" data-url="{{ $edit }}" class="btn btn-edit btn-primary btn-mini waves-effect waves-light"><span
                    class="fal fa-edit"></span> Edit</a>
        @endif
        @if (stripos($button, 'H') !== false)
            <button onclick="deleteTableData('{{ $hapus }}')" type="button"
                    class="btn btn-danger btn-mini waves-effect waves-light"><span class="fal fa-trash"></span> Hapus
            </button>
        @endif
        @if (stripos($button, 'C') !== false)
                <a href="{{ $cetak }}" class="btn btn-warning btn-mini waves-effect waves-light"><span
                        class="fal fa-print"></span> Cetak</a>
        @endif
        @if (stripos($button, 'T') !== false)
            <a href="{{ $tukar }}" class="btn btn-primary btn-mini waves-effect waves-light"><span
                            class="fal fa-reply"></span> Ajukan Tukar Jadwal</a>
        @endif
    @else
        @if (stripos($button, 'R') !== false)
            <button onclick="restoreTableData('{{ $restore }}')" type="button"
                    class="btn btn-primary btn-mini waves-effect waves-light"><span class="fal fa-reply"></span> Restore
            </button>
        @endif
        <button onclick="deleteTableData('{{ $hapus }}')" type="button"
                class="btn btn-danger btn-mini waves-effect waves-light"><span class="fal fa-trash"></span> Hapus
        </button>
    @endif
    @isset($append)
        {!! $append !!}
    @endisset
</div>
