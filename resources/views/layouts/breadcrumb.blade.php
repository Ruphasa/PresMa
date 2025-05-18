<section class="content-header">
    <div class="jumbotron jumbotron-fluid position-relative overlay-bottom" style="margin-bottom: 90px;">
        <div class="container text-center my-5 py-5">
            <h1 class="text-white mt-4 mb-4">
                    @foreach ($breadcrumb->list as $key => $value)
                        @if($key == count($breadcrumb->list) - 1)
                            {{ $value }}
                        @else
                            {{ $value }}
                        @endif
                    @endforeach

            </h1>
            <h1 class="text-white display-1 mb-5">{{ $breadcrumb->title }}</h1>
        </div>
    </div>
</section>