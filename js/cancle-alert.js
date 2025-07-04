 jQuery(document).ready(function($) { // Use jQuery instead of $ to avoid conflict
        $('#cancel-btn').on('click', function(e) {
            e.preventDefault(); // Prevent the default action
            
            const cancelUrl = $(this).data('url'); // Get the URL from the data attribute
            
            // Display SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to cancel your subscription?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, cancel it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, redirect to the cancel URL
                    window.location.href = cancelUrl;
                }
            });
        });
    });