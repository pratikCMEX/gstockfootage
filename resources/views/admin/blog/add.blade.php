<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">
                    <a class="card-title fw-semibold mb-4" href="javascript::void(0);">
                        Add Blog
                    </a>
                </h5>
                <div class="card">
                    <div class="card-body">
                        <form id="blog_form" method="POST" enctype="multipart/form-data"
                            action="{{ route('admin.blog_store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="title" class="form-control" id="title"
                                    placeholder="Please enter blog title">
                            </div>
                            <!-- <div class="mb-3">
                                <label for="short_description" class="form-label">Short Description</label>
                                <textarea class="form-control" name="short_description" id="short_description" rows="3"
                                    placeholder="Please enter short description">{{ isset($blog->short_description) ? $blog->short_description : '' }}</textarea>
                            </div> -->
                            <div class="mb-3">
                                <label for="author_name" class="form-label">Author Name</label>
                                <input type="text" name="author_name" class="form-control" id="author_name"
                                    placeholder="Please enter author name">
                            </div>
                            <div class="mb-3">
                                <label for="author_tag" class="form-label">Author Tag</label>
                                <input type="text" name="author_tag" class="form-control" id="author_tag"
                                    placeholder="Please enter author tag">
                            </div>
                            <div class="mb-3">
                                <label for="publish_date" class="form-label">Publish Date</label><span
                                    class="text-danger">*</span>
                                <input type="date" name="publish_date" class="form-control" id="publish_date">
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label><span class="text-danger">*</span>
                                <input type="file" name="image" class="form-control" id="image" accept="image/*">

                            </div>
                            <label id="image-error" class="text-danger" for="image"></label>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <span class="text-danger">*</span>
                                <textarea class="form-control ckeditor" name="description" id="description" rows="6"
                                    placeholder="Please enter description"></textarea>
                            </div>
                            <label id="description-error" class="text-danger" for="description"></label>
                            <div>
                                <button type="submit" class="btn btn-orange"> Add</button>
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