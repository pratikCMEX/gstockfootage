<button type="button" class="btn image-search-btn shadow" data-bs-toggle="modal" data-bs-target="#exampleModal">
    <i class="bi bi-camera"></i>
    Search by image
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="exampleModalLabel">Search by Image</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('photos.searchByImage') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body search-image-body" id="imageDropZone">



                    {{-- Hidden file input --}}
                    <input type="file" name="image" id="search-image" accept="image/*" hidden>

                    {{-- Preview --}}
                    <img id="imagePreview" src="" alt="Preview"
                        style="display:none; max-height:180px; border-radius:8px; margin-bottom:12px; object-fit:cover;">

                    {{-- Upload icon --}}
                    <svg id="uploadIcon" xmlns="http://www.w3.org/2000/svg" width="35" height="35"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" x2="12" y1="3" y2="15"></line>
                    </svg>

                    <label for="search-image" id="uploadLabel" style="cursor:pointer; margin-top:10px;">
                        Click to upload an image or drag and drop
                    </label>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-hover-dark btn-all-dark cancel-btn"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="btn" class="btn btn-orange" id="searchByImageBtn" disabled>
                        Search
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
