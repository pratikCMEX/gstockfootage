<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">
                    <a class="card-title fw-semibold mb-4" href="javascript::void(0);">
                        Edit Blog
                    </a>
                </h5>
                <div class="card">
                    <div class="card-body">
                        <form id="blog_edit_form" method="POST" enctype="multipart/form-data"
                            action="{{ route('admin.blog_update') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ encrypt($blog->id) }}">
                            
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="title" class="form-control" id="title"
                                    value="{{ $blog->title ?? '' }}"
                                    placeholder="Please enter blog title">
                            </div>
                            <div class="mb-3">
                                <label for="author_name" class="form-label">Author Name</label>
                                <input type="text" name="author_name" class="form-control" id="author_name"
                                    value="{{ $blog->author_name ?? '' }}"
                                    placeholder="Please enter author name">
                            </div>
                            <div class="mb-3">
                                <label for="author_tag" class="form-label">Author Tag</label>
                                <input type="text" name="author_tag" class="form-control" id="author_tag"
                                    value="{{ $blog->author_tag ?? '' }}"
                                    placeholder="Please enter author tag">
                            </div>
                            <div class="mb-3">
                                <label for="publish_date" class="form-label">Publish Date</label><span
                                    class="text-danger">*</span>
                                <input type="date" name="publish_date" class="form-control" id="publish_date"
                                    value="{{ $blog->publish_date ? date('Y-m-d', strtotime($blog->publish_date)) : '' }}">
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" name="image" class="form-control" id="image" accept="image/*">
                                @if($blog->image)
                                    <div class="mt-2">
                                        <p class="small text-muted mb-2">Current Image:</p>
                                        <img src="{{ asset('uploads/images/blogs/' . $blog->image) }}" 
                                             style="max-width: 100px; border-radius: 5px; border: 1px solid #ddd;" 
                                             alt="Blog Image">
                                             <input type="hidden" id="old_image" value="{{ $blog->image ?? '' }}">
                                    </div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <span class="text-danger">*</span>
                                <textarea class="form-control ckeditor" name="description" id="description" rows="6"
                                    placeholder="Please enter description">{{ $blog->description ?? '' }}</textarea>
                            </div>
                            <label id="description-error" class="text-danger" for="description"></label>
                            <div>
                                <button type="submit" class="btn btn-orange">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    CKEDITOR.replace('description');
</script>