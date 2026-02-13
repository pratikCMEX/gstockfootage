
        $(document).ready(function () {
            $('#profile_form').validate({
                rules: {
                    first_name: {
                        required: true,
                        maxlength: 50,
                    },
                    last_name: {
                        required: true,
                        maxlength: 50,
                       
                    },
                    email: {
                        required: true,
                        email:true,
                       
                    },
                  
                   
                },
                messages: {
                    first_name: {
                        required: "Please enter  First Name",
                        maxlength: "First Name cannot exceed 50 characters"
                    },
                    last_name: {
                        required: "Please enter Last Name",
                      maxlength: "Last Name cannot exceed 50 characters"
                    },
                    email: {
                        required: "Please enter Email",
                        email:"Plase Enter a valid Email"
                       
                    },
                   
                },

                //  THIS IS THE KEY PART
                submitHandler: function (form) {

                    $('.save')
                        .prop('disabled', true);

                    form.submit();
                },

                //  If validation fails, button stays enabled
                invalidHandler: function () {
                    $('.save').prop('disabled', false);
                }
            });
        });
        $.validator.addMethod("notEqualTo", function (value, element, param) {
            return value !== $(param).val();
        }, "Values must be different.");


        $('#password_form').validate({
            rules: {
                current_password: {
                    required: true,
                    minlength: 6,
                    // remote: {
                    //     url: "",
                    //     type: "post",
                    //     data: {
                    //         id: function () {
                    //             return $("input[name='id']").val();   // hidden user id
                    //         },
                    //         outlet_id: function () {
                    //             return $("input[name='outlet_id']").val();   // hidden user id
                    //         },
                    //         current_password: function () {
                    //             return $("#current_password").val();
                    //         },
                    //         _token: $('meta[name="csrf-token"]').attr('content')
                    //     }
                    // }

                },
                new_password: {
                    required: true,
                    minlength: 6,
                    notEqualTo: "#current_password"

                },
                confirm_password: {
                    required: true,
                    minlength: 6,
                    equalTo: '#new_password',

                },

            },
            messages: {
                current_password: {
                    required: "Please enter  current password",
                    minlength: "current password number must be atleast 6 characters",
                    // remote: "Entered password is incorrect"
                },
                new_password: {
                    required: "Please enter new password",
                    minlength: "new password number must be atleast 6 characters",
                    notEqualTo: "New password and current password cannot be same"

                },
                confirm_password: {
                    required: "Please enter confirm password",
                    minlength: "confirm password number must be atleast 6 characters",
                    equalTo: " new password And Confirm Password Does not Match"
                },

            },

            // THIS IS THE KEY PART
            submitHandler: function (form) {

                $('.save')
                    .prop('disabled', true);

                form.submit();
            },

            // If validation fails, button stays enabled
            invalidHandler: function () {
                $('.save').prop('disabled', false);
            }
        });



        $(document).on('click', '.cancel', function (e) {
            window.close();
        })
