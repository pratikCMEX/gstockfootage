<section class="listing">
    <div class="container">
        <div class="listing-card">
            <div class="listing-img">
                <img src="{{ asset('uploads/images/blogs/'.$blog_detail->image) }}"
                    height="100%" width="100%" alt="">
              @isset($blog_detail->author_tag)
                <span class="popular-badge listing-badge">{{ $blog_detail->author_tag }}</span>
              @endisset

            </div>
            <h1>{{ $blog_detail->title }}</h1>
            <div class="listing-content">
                <p>{!! $blog_detail->description !!}</p>
            </div>
        </div>
    </div>
</section>
