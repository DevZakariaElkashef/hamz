<script>
    // Wait for the DOM to fully load
    document.addEventListener('DOMContentLoaded', function() {
        // Set a timeout to hide the element after 5 seconds (5000 milliseconds)
        setTimeout(function() {
            var toast = document.querySelector('.demo-static-toast');
            if (toast) {
                toast.style.display = 'none';
            }
        }, 5000);
    });


    // update delete btn data url to delete form
    $(document).on('click', '.delete-btn', function() {
        let url = $(this).data('url');
        $('#deleteForm').attr('action', url);
    })


    // search input
    $(document).on('input', '#searchInput', function() {
        let val = $(this).val();

        $.ajax({
            type: "GET",
            url: $(this).data('url'),
            data: {
                search: val
            },
            success: function(response) {
                $('#tableFile').html(response);
            }
        });
    });


    // select all checkboxs
    $(document).ready(function() {
        // Function to update the visibility of the delete button
        function updateDeleteButtonVisibility() {
            $("#deleteSelectionBtn").toggleClass('d-none', $('.checkbox-input:checked').length === 0);
        }

        // Handle "Select All" checkbox
        $('#selectAllInputs').on('change', function() {
            var isChecked = $(this).is(':checked');
            $('.checkbox-input').prop('checked', isChecked);
            updateDeleteButtonVisibility();
        });

        // Handle individual checkboxes
        $('.checkbox-input').on('change', function() {
            // Uncheck "Select All" if any individual checkbox is unchecked
            if (!$(this).is(':checked')) {
                $('#selectAllInputs').prop('checked', false);
            }

            // Update the visibility of the delete button
            updateDeleteButtonVisibility();
        });

        // Initial check to set button visibility based on existing checkboxes
        updateDeleteButtonVisibility();
    });

    $(document).ready(function() {
        $(document).on('click', '#deleteSelectionBtn', function() {
            var url = $(this).data('url');
            // Initialize an array to hold the values of checked checkboxes
            var selectedValues = [];

            // Loop through all checked checkboxes and get their values
            $('.checkbox-input:checked').each(function() {
                selectedValues.push($(this).val());
            });

            // Join the array into a comma-separated string
            var valuesString = selectedValues.join(',');

            // Assign the values string to the input
            $("#selectionIdsInput").val(valuesString);
            $('#deleteForm').attr('action', url);

        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.custom-toggle-input').change(function() {
            var switchElement = $(this);
            var id = switchElement.data('id');
            var url = switchElement.data('url');
            var status = switchElement.prop('checked') ? 1 : 0;

            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    is_active: status
                },
                success: function(response) {
                    if (response.success) {
                        // Remove d-none before showing the toast
                        $('.success-toast').removeClass('d-none').show();
                        $('.success-toast .toast-body').text(response.message);

                        setTimeout(function() {
                            // Hide the toast after 1 second
                            $('.success-toast').fadeOut(function() {
                                $(this).addClass(
                                    'd-none'
                                    ); // Add d-none after fade out completes
                            });
                        }, 1000);
                    }
                }
            });
        });
    });
</script>

<script>
    function updatePageSize() {
        var perPage = document.getElementById('showPerPage').value;
        var selectElement = document.getElementById('showPerPage');
        var baseUrl = selectElement.getAttribute('data-url'); // Get the URL from the data-url attribute

        // Construct the new URL with the per_page parameter
        var url = new URL(baseUrl, window.location.origin);
        url.searchParams.set('per_page', perPage);

        // Redirect to the new URL
        window.location.href = url.href;
    }
</script>
