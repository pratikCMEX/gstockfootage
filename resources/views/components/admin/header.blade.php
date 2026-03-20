<link rel="shortcut icon" type="image/png" href="{{ asset('assets/admin/images/logos/favicon.png') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
<link rel="stylesheet" href="{{ asset('assets/admin/css/var.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/css/styles.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/css/main.css') }}">

<!-- <link rel="stylesheet" href="{{ asset('assets/front/css/brows.css') }}"> -->
<!-- <link rel="stylesheet" href="{{ asset('assets/front/css/cart.css') }}"> -->
<!-- <link rel="stylesheet" href="{{ asset('assets/front/css/checkout.css') }}"> -->
<!-- <link rel="stylesheet" href="{{ asset('assets/front/css/collection.css') }}"> -->
<!-- <link rel="stylesheet" href="{{ asset('assets/front/css/font.css') }}"> -->
<!-- <link rel="stylesheet" href="{{ asset('assets/front/css/footer.css') }}"> -->
<!-- <link rel="stylesheet" href="{{ asset('assets/front/css/header.css') }}"> -->
<!-- <link rel="stylesheet" href="{{ asset('assets/front/css/home.css') }}"> -->
<!-- <link rel="stylesheet" href="{{ asset('assets/front/css/login_in.css') }}"> -->
<!-- <link rel="stylesheet" href="{{ asset('assets/front/css/product-detail.css') }}"> -->
<!-- <link rel="stylesheet" href="{{ asset('assets/front/css/pricing.css') }}"> -->


<link href="{{ asset('assets/admin/css/toastr.css') }}" rel="stylesheet">
<link href="{{ asset('assets/admin/css/batch.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/admin/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/css/responsive.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/css/owl.carousel.min.css') }}">
<!-- toast css -->
@if (request()->is('admin/dashboard'))
    <link rel="stylesheet" href="{{ asset('assets/admin/css/dashboard.css') }}">
@endif
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<input type="hidden" id="base_url" value="{{ url('/') }}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
    integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" /> -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


<!-- data table button -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
