<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4"><a class="card-title fw-semibold mb-4"
                                    href="{{ route('admin.blog') }}">Blogs</a> / Add Blog
                            </h5>
                </h5>
                <div class="card">
                    <div class="card-body">
                        <form id="blog_form" method="POST" enctype="multipart/form-data"
                            action="{{ route('admin.blog_store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">Blog Title</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="title" class="form-control" id="title"
                                    placeholder="enter Blog Title">
                            </div>
                            <!-- <div class="mb-3">
                                <label for="short_description" class="form-label">Short Description</label>
                                <textarea class="form-control" name="short_description" id="short_description" rows="3"
                                    placeholder="enter short description">{{ isset($blog->short_description) ? $blog->short_description : '' }}</textarea>
                            </div> -->
                            <div class="mb-3">
                                <label for="author_name" class="form-label">Author Name</label>
                                <input type="text" name="author_name" class="form-control" id="author_name"
                                    placeholder="enter Author Name">
                            </div>
                            <div class="mb-3">
                                <label for="author_tag" class="form-label">Author Tag</label>
                                <input type="text" name="author_tag" class="form-control" id="author_tag"
                                    placeholder="enter Author Tag">
                            </div>
                            <div class="mb-3">
                                <label for="publish_date" class="form-label">Publish Date</label><span
                                    class="text-danger">*</span>
                                <input type="date" name="publish_date" class="form-control" id="publish_date"  max="{{ date('Y-m-d') }}">
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
                                    placeholder="enter Description"></textarea>
                            </div>
                            <label id="description-error" class="text-danger mb-2" for="description"></label>
                            <div>
                                <button type="submit" class="btn btn-orange"> Add Blog</button>
                                <a href="{{ route('admin.blog') }}" class="btn btn-orange">Cancel</a>
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