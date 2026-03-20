<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">
                    <a class="card-title fw-semibold mb-4" href="javascript::void(0);">
                        {{ $title }}
                    </a>
                </h5>
                <div class="card">
                    <div class="card-body">
                        <form name="content_master_form" id="content_master_form" method="POST"
                            enctype="multipart/form-data" action="{{ route('admin.content_store') }}">
                            @csrf
                            <input id="id" name="id"
                                value="{{ isset($content_master->id) ? $content_master->id : '' }}" hidden />
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label><span class="text-danger">*</span>

                                <input type="text" name="title" class="form-control" id="title"
                                    value="{{ isset($content_master->title) ? $content_master->title : '' }}"
                                    placeholder="Please enter title">
                            </div>
                            <div class="mb-3">
                                <label for="sub_title" class="form-label">Sub Title</label>
                                <input type="text" name="sub_title" class="form-control" id="sub_title"
                                    value="{{ isset($content_master->sub_title) ? $content_master->sub_title : '' }}"
                                    placeholder="Please enter sub title">
                            </div>
                            @php

                                $sections = isset($content_master->content) ? $content_master->content : [];
                            @endphp

                            @for ($i = 0; $i < 4; $i++)
                                <div class="card p-3 mb-3">
                                    <h6>Section {{ $i + 1 }}</h6>

                                    <input type="text" name="sections[{{ $i }}][title]"
                                        class="form-control mb-2" placeholder="Title"
                                        value="{{ $sections[$i]['title'] ?? '' }}">

                                    <input type="text" name="sections[{{ $i }}][sub_title]"
                                        class="form-control mb-2" placeholder="Sub Title"
                                        value="{{ $sections[$i]['sub_title'] ?? '' }}">

                                    <label class="form-label mt-2">SVG Icon</label>
                                    <textarea name="sections[{{ $i }}][svg]" class="form-control mb-2" rows="4"
                                        placeholder="Paste your SVG code here e.g. <svg>...</svg>">{{ $sections[$i]['svg'] ?? '' }}</textarea>

                                </div>
                            @endfor


                            <button type="submit"
                                class="btn btn-orange">{{ $content_master ? 'Update' : 'Add' }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
