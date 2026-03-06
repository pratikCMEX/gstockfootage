<main>
    <section class="term_section  privacy-wrapper">
        <div class="container-fluid">
            <div class="term-content">
                  @if(isset($terms_services[0]))
                <div class="heading">
                    <h2> <span class="yellow-headings"> {{$terms_services[0]->title}}</span></h2>
                    <span class="last-update">Last updated: {{ $terms_services[0]->updated_at->format('F d, Y') }}</span>
                </div>
                 <div class="privacy-content mt-4">
                    {!! $terms_services[0]->content !!}
                </div>
                  @endif
            </div>
        </div>
    </section>
</main>