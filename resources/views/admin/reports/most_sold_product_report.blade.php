<div class="body-wrapper-inner">
    <div class="container-fluid">
<div class=" mb-3 mb-sm-0 mb-4">
                <h5 class="card-title fw-semibold">Reports /  Most Sold Products</h5>
            </div>
        <div class="row mb-3 mt-4 table-date">
            
            <div class="col-md-3">
                <label>Products</label>
                <select name="product_id" id="product_id" class="form-control searchable">
                    <option value="" selected>All</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->title}}</option>

                    @endforeach
                </select>
            </div>
             <div class="col-md-3">
                <label>Categories</label>
                <select name="category_id" id="category_id" class="form-control searchable">
                    <option value="" selected>All</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>

                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label>From Date</label>
                <input type="date" id="from_date" class="form-control">
            </div>
            <div class="col-md-3">
                <label>To Date</label>
                <input type="date" id="to_date" class="form-control">
            </div>

        </div>
        <div class="row">
            <div class="col-lg-12 d-flex align-items-stretch">

                <div class="card w-100">
                    <div class="card-body">

                        <div class="table-responsive">

                            {{ $dataTable->table() }}
                        </div>
                        {{ $dataTable->scripts() }}

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>