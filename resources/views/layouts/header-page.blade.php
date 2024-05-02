<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    {{$data_page['title']}}
                </div>
                <h2 class="page-title">
                    {{$data_page['sub_title']}}
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    @if ($data_page['create_button']['is_enabled'])
                        <a href="{{$data_page['create_button']['redirect']}}" class="btn btn-primary d-sm-inline-block"><i
                                class="fas fa-plus"></i>&nbsp;&nbsp;{{$data_page['create_button']['caption']}}
                        </a>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
