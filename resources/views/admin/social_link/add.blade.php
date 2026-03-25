<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">
                    <a class="card-title fw-semibold mb-4" href="javascript::void(0);">
                       Social Links
                    </a>
                </h5>
                <div class="card">
                    <div class="card-body">
                        <form name="social_links_form" id="social_links_form" method="POST" action="{{ route('admin.social_links_store') }}">
                            @csrf
                            @if($social_links)
                                <input type="hidden" name="id" value="{{ encrypt($social_links->id) }}">
                            @endif
                            
                            <div class="mb-3">
                                <label for="instagram_link" class="form-label">Instagram Link</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fab fa-instagram"></i>
                                    </span>
                                    <input type="url" name="instagram_link" class="form-control" id="instagram_link"
                                        value="{{ $social_links->instagram_link ?? '' }}"
                                        placeholder="https://instagram.com/username">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="facebook_link" class="form-label">Facebook Link</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fab fa-facebook"></i>
                                    </span>
                                    <input type="url" name="facebook_link" class="form-control" id="facebook_link"
                                        value="{{ $social_links->facebook_link ?? '' }}"
                                        placeholder="https://facebook.com/username">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="twitter_link" class="form-label">Twitter Link</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fab fa-twitter"></i>
                                    </span>
                                    <input type="url" name="twitter_link" class="form-control" id="twitter_link"
                                        value="{{ $social_links->twitter_link ?? '' }}"
                                        placeholder="https://twitter.com/username">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="linkedin_link" class="form-label">LinkedIn Link</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fab fa-linkedin"></i>
                                    </span>
                                    <input type="url" name="linkedin_link" class="form-control" id="linkedin_link"
                                        value="{{ $social_links->linkedin_link ?? '' }}"
                                        placeholder="https://linkedin.com/in/username">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="youtube_link" class="form-label">YouTube Link</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fab fa-youtube"></i>
                                    </span>
                                    <input type="url" name="youtube_link" class="form-control" id="youtube_link"
                                        value="{{ $social_links->youtube_link ?? '' }}"
                                        placeholder="https://youtube.com/channel/username">
                                </div>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle"></i>
                                    Enter complete URLs including https:// (e.g., https://instagram.com/username)
                                </small>
                            </div>

                            <button type="submit" class="btn btn-orange">
                               Save
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



