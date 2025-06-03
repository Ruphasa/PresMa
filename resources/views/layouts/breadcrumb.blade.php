<section class="content-header">
    <div class="jumbotron jumbotron-fluid position-relative overlay-bottom" style="margin-bottom: 90px;">
        <div class="container text-center my-5 py-5">
            <h1 class="text-white mt-4 mb-4">
                @foreach ($breadcrumb->list as $key => $value)
                    @if ($key == count($breadcrumb->list) - 1)
                        {{ $value }}
                    @else
                        {{ $value }} /
                    @endif
                @endforeach
            </h1>
            <h1 class="text-white display-1 mb-5">{{ $breadcrumb->title }}</h1>
            @if ($activeMenu == 'listcompetition')
                <div class="mx-auto mb-5" style="width: 100%; max-width: 600px;">
                    <form action="{{ url('/ListCompetition') }}" method="GET" class="input-group">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-light bg-white text-body px-4 dropdown-toggle" type="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Kategori</button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ url('/ListCompetition') }}">All</a>
                                @foreach ($categories as $category)
                                    <a class="dropdown-item"
                                        href="{{ url('/ListCompetition?kategori_id=' . $category->kategori_id) }}">{{ $category->kategori_nama }}</a>
                                @endforeach
                            </div>
                        </div>
                        <input type="text" name="keyword" class="form-control border-light"
                            style="padding: 30px 25px;" placeholder="Keyword" value="{{ request('keyword') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-danger px-4 px-lg-5">Search</button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
</section>
