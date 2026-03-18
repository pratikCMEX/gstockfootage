$(document).ready(function() {
    
    // Social Links Form Validation
    $("#social_links_form").validate({
        rules: {
            instagram_link: {
                url: true,
                maxlength: 255
            },
            facebook_link: {
                url: true,
                maxlength: 255
            },
            twitter_link: {
                url: true,
                maxlength: 255
            },
            linkedin_link: {
                url: true,
                maxlength: 255
            },
            youtube_link: {
                url: true,
                maxlength: 255
            }
        },
        messages: {
            instagram_link: {
                url: "Please enter a valid Instagram URL (e.g., https://instagram.com/username)",
                maxlength: "Instagram URL cannot exceed 255 characters"
            },
            facebook_link: {
                url: "Please enter a valid Facebook URL (e.g., https://facebook.com/username)",
                maxlength: "Facebook URL cannot exceed 255 characters"
            },
            twitter_link: {
                url: "Please enter a valid Twitter URL (e.g., https://twitter.com/username)",
                maxlength: "Twitter URL cannot exceed 255 characters"
            },
            linkedin_link: {
                url: "Please enter a valid LinkedIn URL (e.g., https://linkedin.com/in/username)",
                maxlength: "LinkedIn URL cannot exceed 255 characters"
            },
            youtube_link: {
                url: "Please enter a valid YouTube URL (e.g., https://youtube.com/channel/username)",
                maxlength: "YouTube URL cannot exceed 255 characters"
            }
        },
        errorClass: "text-danger",
        errorElement: "label",
        highlight: function (element) {
            $(element).addClass("is-invalid");
            $(element).closest('.input-group').addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
            $(element).closest('.input-group').removeClass('is-invalid');
        },
        errorPlacement: function (error, element) {
            // Place error after the input-group
            error.insertAfter(element.closest('.input-group'));
        },
        submitHandler: function (form) {
            // Show loading state
            form.submit();
            // var submitBtn = $(form).find('button[type="submit"]');
            // var originalText = submitBtn.html();
            // submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Saving...').prop('disabled', true);
            
            // // Submit the form via AJAX for better UX
            // $.ajax({
            //     url: $(form).attr('action'),
            //     type: 'POST',
            //     data: $(form).serialize(),
            //     success: function(response) {
            //         // For redirect responses, let the browser handle it
            //         if (response.redirect) {
            //             window.location.href = response.redirect;
            //         } else {
            //             // For regular form submission, let it proceed
            //             form.submit();
            //         }
            //     },
            //     error: function(xhr) {
            //         // Restore button state
            //         submitBtn.html(originalText).prop('disabled', false);
                    
            //         // Show error message if available
            //         if (xhr.responseJSON && xhr.responseJSON.errors) {
            //             // Display validation errors
            //             var errors = xhr.responseJSON.errors;
            //             $.each(errors, function(key, value) {
            //                 var field = $('[name="' + key + '"]');
            //                 field.addClass('is-invalid');
            //                 field.closest('.input-group').addClass('is-invalid');
                            
            //                 // Remove existing error for this field
            //                 field.closest('.input-group').next('label.text-danger').remove();
                            
            //                 // Add new error message
            //                 var errorLabel = '<label class="text-danger" for="' + key + '">' + value[0] + '</label>';
            //                 field.closest('.input-group').after(errorLabel);
            //             });
            //         } else {
            //             // Show general error message
            //             toastr.error('An error occurred while saving social links.');
            //         }
            //     }
            // });
            
            // return false; // Prevent default form submission
        }
    });

    // Add URL format helper function
    function isValidUrl(url) {
        var pattern = new RegExp('^(https?:\\/\\/)' + // protocol
            '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
            '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
            '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
            '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
            '(\\#[-a-z\\d_]*)?$', 'i'); // fragment locator
        return !!pattern.test(url);
    }

    // Add real-time URL validation feedback
    $('input[type="url"]').on('blur', function() {
        var $this = $(this);
        var url = $this.val().trim();
        var $inputGroup = $this.closest('.input-group');
        
        if (url === '') {
            // Empty field is valid (optional)
            $inputGroup.removeClass('is-valid is-invalid');
            $inputGroup.next('label.text-danger').remove();
            return;
        }
        
        if (isValidUrl(url)) {
            $inputGroup.addClass('is-valid');
            $inputGroup.removeClass('is-invalid');
            $inputGroup.next('label.text-danger').remove();
            
            // Add success feedback
            if (!$inputGroup.find('.valid-feedback').length) {
                $inputGroup.append('<div class="valid-feedback">Valid URL format</div>');
            }
        } else {
            $inputGroup.addClass('is-invalid');
            $inputGroup.removeClass('is-valid');
            
            // Add error feedback
            if (!$inputGroup.next('label.text-danger').length) {
                var fieldName = $this.attr('name').replace('_link', '');
                var errorLabel = '<label class="text-danger" for="' + $this.attr('name') + '">Please enter a valid ' + fieldName.charAt(0).toUpperCase() + fieldName.slice(1) + ' URL</label>';
                $inputGroup.after(errorLabel);
            }
        }
    });

    // Add input formatting helper
    $('input[type="url"]').on('input', function() {
        var $this = $(this);
        var url = $this.val().trim();
        
        // Auto-add https:// if missing and not empty
        if (url !== '' && !url.match(/^https?:\/\//)) {
            $this.val('https://' + url);
        }
    });

    // Add character counter for URLs
    $('input[type="url"]').each(function() {
        var $this = $(this);
        var maxLength = 255;
        
        // Add character counter
        var $counter = $('<small class="text-muted float-end">0/' + maxLength + '</small>');
        $this.closest('.mb-3').find('label').after($counter);
        
        // Update counter on input
        $this.on('input', function() {
            var length = $(this).val().length;
            $counter.text(length + '/' + maxLength);
            
            if (length > maxLength) {
                $counter.addClass('text-danger');
            } else {
                $counter.removeClass('text-danger');
            }
        });
        
        // Initialize counter
        $counter.text($this.val().length + '/' + maxLength);
    });

    // Add paste event handler for better URL formatting
    $('input[type="url"]').on('paste', function(e) {
        var $this = $(this);
        
        setTimeout(function() {
            var url = $this.val().trim();
            
            // Clean up common URL issues
            url = url.replace(/\s+/g, ''); // Remove spaces
            if (!url.match(/^https?:\/\//) && url !== '') {
                url = 'https://' + url;
            }
            
            $this.val(url);
            
            // Trigger validation after paste
            $this.trigger('blur');
        }, 10);
    });

});