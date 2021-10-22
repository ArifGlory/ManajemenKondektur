<div class="panel-container show">
    <ul class="list-unstyled m-0 pb-2">
        @foreach($apis as $api)
            <li>
                <div class="d-flex w-100 px-3 py-2 text-dark hover-white cursor-pointer show-child-on-hover">
                    <div class="px-2 flex-1">
                        <div class="text-truncate text-truncate-md">
                            {{ $api->name }}
                            <small class="d-block font-italic fs-xs opacity-50">
                                @if($api->active)<span class="badge bg-info-800">Aktif</span>@else<span class="badge bg-danger-800">Nonaktif</span>@endif {{ $api->access_count }} transaksi
                            </small>
                        </div>
                    </div>
                    <div class="position-absolute pos-right mt-2 mr-3 show-on-hover-parent">
                        <button class="btn @if ($api->active)
                            btn-info
                            @else
                            btn-danger
                        @endif btn-xs btn-icon rounded-circle shadow-0 waves-effect waves-themed btn-api-status" data-url="{{ route('api.update', $api->id) }}" data-toggle="tooltip" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner @if(!$api->active) bg-success-500 @else bg-danger-500 @endif&quot;></div></div>" data-original-title="@if($api->active) Nonaktifkan! @else Aktifkan! @endif">
                            <i class="fal fa-power-off"></i>
                        </button>
                        <button class="btn btn-danger btn-xs btn-icon rounded-circle shadow-0 waves-effect waves-themed btn-api-delete" data-url="{{ route('api.destroy', $api->id) }}  " data-toggle="tooltip" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-original-title="Hapus Token!">
                            <i class="fal fa-trash"></i>
                        </button>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    @if ($apis->total() > 6)
        <div class="panel-content rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted">
            {{ $apis->links() }}
        </div>
    @endif
</div>
