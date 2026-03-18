@if ($blogs->isNotEmpty())
    <section class="blog">
        <div class="container">

            <div class="heading mb-4">
                <h2>Latest stories</h2>
            </div>


            <div class="row g-3">
                @foreach($blogs as $blog)
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <div class="blog-card">
                            <div class="blog-img">
                                <img src="{{ asset('uploads/images/blogs/' . $blog->image) }}" height="100%" width="100%"
                                    alt="">
                                @isset($blog->author_tag) <span
                                class="popular-badge blog-badge">{{$blog->author_tag}}</span>@endisset
                            </div>
                            <div class="p-3">
                                <div class="blog-time">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-calendar" viewBox="0 0 16 16">
                                        <path
                                            d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                                    </svg>
                                    <span>{{ \Carbon\Carbon::parse($blog->publish_date)->format('F d, Y') }} </span>
                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                    class="bi bi-clock" viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
                                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0" />
                                                </svg> -->
                                    @isset($blog->author_name)
                                        <div class="d-flex align-items-center gap-2 text-muted small">

                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm0 2c-3.33 0-10 1.67-10 5v1h20v-1c0-3.33-6.67-5-10-5z" />
                                            </svg>

                                            <span>
                                                {{ $blog->author_name }}
                                            </span>

                                        </div>
                                    @endisset
                                </div>
                                <h6 class="blog-title">{{ $blog->title }}</h6>
                                <p class="blog-text">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($blog->description), 100) }}
                                </p>
                                <a href="{{ route('blog_detail', ['id' => encrypt($blog->id)]) }}" class="brows-btn">
                                    Read Article
                                    <i class="bi bi-arrow-right-short"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

        </div>
    </section>
@endif