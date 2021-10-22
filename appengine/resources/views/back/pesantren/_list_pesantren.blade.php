<div class="panel-content">
    @if (!count($data))
        <p class="text-center font-weight-bold">Tidak ada data Pesantren!</p>
    @else
    <div class="card-columns" id="active-Pesantren">
        @foreach($data as $d)
            <div class="card">
                @if($d->foto != null)
                    <img src="https://api.nyantri.net/img/sekolah/{{$d->foto}}" class="card-img-top" alt="{{ $d->name }}">
                @else
                    <img src="{{ asset('img/padrao.png') }}" class="card-img-top" alt="{{ $d->name }}">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $d->name }}
                    </h5>
                    <p>Pengasuh : <strong> {{$d->nama_pengasuh}} </strong></p>
                    <div class="row">
                        <div class="col">
                            @if (!$d->deleted_at)
                            <span class="card-text"><small class="text-muted">Diupload pada {{ \Carbon\Carbon::parse($d->created_at)->format('d M Y') }}</small></span>
                            @else
                            <span class="card-text"><small class="text-danger">Dihapus pada {{ \Carbon\Carbon::parse($d->deleted_at)->format('d M Y') }}</small></span>
                            @endif
                        </div>
                        <div class="col-4">
                            @if (!$d->deleted_at)
                            <div class="form-group text-right">
                               
                            </div>
                            @endif
                        </div>
                        @if ($d->deleted_at)
                        <button onclick="restoreData('{{ route('pesantren.restore', $d->id_user) }}')" class="btn btn-xs btn-success btn-icon mr-1 pull-right"><i class="fal fa-reply"></i></button>
                        @endif
                        @if (!$d->deleted_at)
                            <a href="{{ url('/pesantren', $d->id_user) }}" class="btn btn-xs btn-info btn-icon mr-1"><i class="fal fa-eye"></i></a>
                            {{--<a href="{{ url('/pesantren.edit', $d->id_user) }}" class="btn btn-xs btn-success btn-icon mr-1"><i class="fal fa-edit"></i></a>--}}
                        @endif
                        <button onclick="deleteData('{{ route('pesantren.destroy', $d->id_user) }}')" class="btn btn-xs btn-danger btn-icon mr-1"><i class="fal fa-trash"></i></button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @endif
    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted">
        {{ $data->links() }}
    </div>
</div>
