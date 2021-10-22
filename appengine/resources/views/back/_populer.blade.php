<div class="card-header bg-white p-0">
    <div class="row no-gutters row-grid align-items-stretch">
        <div class="col-12 col-md">
            <div class="text-uppercase text-muted py-2 px-3">Judul Post</div>
        </div>
        <div class="col-sm-6 col-md-3 col-xl-2 hidden-md-down">
            <div class="text-uppercase text-muted py-2 px-3">Status</div>
        </div>
    </div>
</div>
<div class="card-body p-0">
    <div class="row no-gutters row-grid">
        <!-- thread -->
        @foreach ($populer as $d)
            <div class="col-12">
                <div class="row no-gutters row-grid align-items-stretch">
                    <div class="col-md">
                        <div class="p-3">
                            <div class="d-flex">
                                            <span class="fa-stack display-4 mr-3 flex-shrink-0" style="vertical-align: top;font-size: 1.55rem;">
                                                <i class="fas fa-circle fa-stack-2x"></i>
                                                <i class="fas fa-newspaper fa-stack-1x fa-inverse"></i>
                                            </span>
                                <div class="d-inline-flex flex-column">
                                    <a target="_blank" href="{{ url('/details/'.$d->seotitle) }}" class="fs-lg fw-500 d-block">
                                        {{ $d->title }}<span class="badge badge-warning rounded">{{ $d->kategori->title }}</span>
                                    </a>
                                    <div class="d-block text-muted fs-sm">
                                        Seo: {{ $d->seotitle }}, Tag: {{ $d->tag }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 col-xl-2 hidden-md-down">
                        <div class="p-3 p-md-3">
                            <span class="d-block text-muted">{{ $d->vzt()->count() }} <i>Views</i></span>
                            <span class="d-block text-muted">{{ \Carbon\Carbon::parse($d->tanggal)->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>