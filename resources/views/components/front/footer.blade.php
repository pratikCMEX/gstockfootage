<script src="{{ asset('assets/admin/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/front/js/cart.js') }}"></script>
<script src="{{ asset('assets/admin/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/additional-methods.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/admin/js/toastr.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>

<script src="{{ asset('assets/admin/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/dataTables.responsive.min.js') }}"></script>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<!-- toast js -->

<script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset('assets/front/js/script.js') }}"></script>
<script src="https://js.stripe.com/v3/"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>

<script>

    // document.addEventListener("DOMContentLoaded", function () {

    //     var input = document.querySelector("#phone");

    //     var iti = window.intlTelInput(input, {
    //         initialCountry: "us",
    //         preferredCountries: ["us"],
    //         separateDialCode: true,
    //         utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
    //     });

    //     document.querySelector("#signup").addEventListener("submit", function () {

    //         var fullPhone = iti.getNumber();

    //         document.querySelector("#full_phone").value = fullPhone;

    //     });

    // });

</script>
<script>


    var base_url = $("#base_url").val();

    @if (session('msg_error'))
        toastr.error("{{ session('msg_error') }}");
    @endif

    @if (session('msg_success'))
        toastr.success("{{ session('msg_success') }}");
    @endif

    @if (isset($errors) && $errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif
</script>
@if (isset($js))
    @foreach ($js as $value)
        <script src="{{ asset('assets/front') }}/js/{{ $value }}.js"></script>
    @endforeach
@endif