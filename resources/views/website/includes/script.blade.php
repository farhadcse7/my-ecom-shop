<!-- JS here -->
<script src="{{ asset('/') }}website/assets/js/jquery-3.7.1.js"></script>{{-- <script src="{{asset('/')}}website/assets/js/vendor/jquery.js"></script> --}}
<script src="{{ asset('/') }}website/assets/js/vendor/waypoints.js"></script>
<script src="{{ asset('/') }}website/assets/js/bootstrap-bundle.js"></script>
<script src="{{ asset('/') }}website/assets/js/meanmenu.js"></script>
<script src="{{ asset('/') }}website/assets/js/swiper-bundle.js"></script>
<script src="{{ asset('/') }}website/assets/js/slick.js"></script>
<script src="{{ asset('/') }}website/assets/js/range-slider.js"></script>
<script src="{{ asset('/') }}website/assets/js/magnific-popup.js"></script>
<script src="{{ asset('/') }}website/assets/js/nice-select.js"></script>
<script src="{{ asset('/') }}website/assets/js/purecounter.js"></script>
<script src="{{ asset('/') }}website/assets/js/countdown.js"></script>
<script src="{{ asset('/') }}website/assets/js/wow.js"></script>
<script src="{{ asset('/') }}website/assets/js/isotope-pkgd.js"></script>
<script src="{{ asset('/') }}website/assets/js/imagesloaded-pkgd.js"></script>
<script src="{{ asset('/') }}website/assets/js/ajax-form.js"></script>
<script src="{{ asset('/') }}website/assets/js/main.js"></script>
<!-- sweet alert 2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: '{{ session('success') }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: '{{ session('error') }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
        });
    @endif

    @if(session('warning'))
        Swal.fire({
            icon: 'warning',
            title: '{{ session('warning') }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
        });
    @endif

    @if(session('info'))
        Swal.fire({
            icon: 'info',
            title: '{{ session('info') }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
        });
    @endif
</script>
<!-- sweet alert 2 end-->

<!-- jQuery UI -->
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">


<!-- theme settings wrapper class remove script -->
<script>
    // theme settings wrapper is inside of main.js file
    document.querySelector('.tp-theme-wrapper').remove();
</script>

<!-- ajax search script -->
<script>
    // .search-container = div class -main full search container
    // #product-search = input id - product name typed here
    // #search-results =div id - wrapped the ul field. it shows and hide result box
    // #results-list = ul id -where li results appended

    $(document).ready(function() {
        $('#product-search').on('keyup', function() { // #product-search = product name input field it
            var query = $(this).val();
            if (query.length > 0) {
                $.ajax({
                    url: "{{ route('ajax-search') }}", // URL to the search route
                    method: 'GET',
                    data: {
                        query: query
                    },
                    success: function(data) {
                        var resultsList = $('#results-list'); // #results-list = ul id
                        resultsList.empty(); // Clear previous results

                        if (data.length > 0) {
                            data.forEach(function(product) {
                                resultsList.append(`
                                    <a href="/product-detail/${product.id}">
                                        <li class="result-item">
                                            <img src="${window.location.origin}/${product.image}"
                                                 alt="${product.name}"
                                                 style="width: 50px; height: 50px;">
                                            <div class="result-details">
                                                <span class="product-name">${product.name}</span>
                                                <span class="product-price">TK. ${product.selling_price}</span>
                                            </div>
                                        </li>
                                    </a>
                                `);
                            });
                            $('#search-results')
                                .show(); // Show the dropdown with results // #search-results =div above of ul and it contains the result
                        } else {
                            resultsList.append('<li>No products found</li>');
                            $('#search-results').show();
                        }
                    }
                });
            } else {
                $('#search-results').hide(); // Hide the dropdown if query is too short
            }
        });

        // Hide the search results if clicking outside the search box or dropdown
        $(document).click(function(e) {
            if (!$(e.target).closest('.search-container')
                .length) { // .search-container = main full search container
                $('#search-results').hide();
            }
        });
    });
</script>

{{-- <script>
    // Auto-Submit for Other Filters (Brands, Categories, Colors, Sizes Checkbox)
    document.querySelectorAll('#other-filters-form input[type="checkbox"], #other-filters-form input[type="radio"]')
        .forEach(input => {
            input.addEventListener('change', () => {
                document.getElementById('other-filters-form').submit();
            });
        });
</script> --}}

{{-- <script>
    // Auto-Submit for Dropdowns (use when you have multiple dropdowns)
    document.querySelectorAll('#combined-filter-form select').forEach(select => {
        select.addEventListener('change', () => {
            document.getElementById('combined-filter-form').submit();
        });
    });
</script> --}}

{{-- Product filering and sorting start --}}
<script>
    $(document).ready(function() {
        console.log("Document is ready");

        // Initialize the range slider
        $("#slider-range").slider({
            range: true,
            min: 0, // Minimum price (showing bar range start value)
            max: 300000, // Maximum price (showing bar range end value)
            values: [
                {{ request('min_price', 0) }}, // Default min price
                {{ request('max_price', 300000) }} // Default max price
            ],
            slide: function(event, ui) {
                // Update the displayed price range on the slider
                $("#min-price-display").text(ui.values[0]);
                $("#max-price-display").text(ui.values[1]);

                // Update the hidden input fields
                $("#min_price").val(ui.values[0]);
                $("#max_price").val(ui.values[1]);

                // Sync manual input fields
                $("#min_price_input").val(ui.values[0]);
                $("#max_price_input").val(ui.values[1]);
            },
            change: function(event, ui) {
                // Trigger AJAX filtering instead of form submission
                applyFilters();
            }
        });

        // Initialize the display with the current slider values
        $("#min-price-display").text($("#slider-range").slider("values", 0));
        $("#max-price-display").text($("#slider-range").slider("values", 1));

        // Sync the slider with manual inputs
        let minVal, maxVal;

        // Sync min price input
        $("#min_price_input").on('input', function() {
            minVal = parseInt($("#min_price_input").val()) || 0; // Ensure it's an integer
            maxVal = parseInt($("#max_price_input").val()) || 300000; // Default max value

            // Ensure valid range (min <= max)
            if (minVal >= 0 && minVal <= maxVal) {
                // Update the slider
                $("#slider-range").slider("values", 0, minVal);
                $("#slider-range").slider("values", 1, maxVal);

                // Update the display and hidden inputs
                $("#min-price-display").text(minVal);
                $("#max-price-display").text(maxVal);
                $("#min_price").val(minVal);
                $("#max_price").val(maxVal);

            } else {
                // Restore the last valid value
                $("#min_price_input").val($("#slider-range").slider("values", 0));
            }
        });

        // Sync max price input
        $("#max_price_input").on('input', function() {
            maxVal = parseInt($("#max_price_input").val()) || 300000; // Ensure it's an integer
            minVal = parseInt($("#min_price_input").val()) || 0; // Default min value

            // Ensure valid range (max >= min)
            if (maxVal >= minVal && maxVal <= 300000) {
                // Update the slider
                $("#slider-range").slider("values", 0, minVal);
                $("#slider-range").slider("values", 1, maxVal);

                // Update the display and hidden inputs
                $("#min-price-display").text(minVal);
                $("#max-price-display").text(maxVal);
                $("#min_price").val(minVal);
                $("#max_price").val(maxVal);


            } else {
                // Restore the last valid value
                $("#max_price_input").val($("#slider-range").slider("values", 1));
            }
        });

        // AJAX request on Filter button click
        $("#apply-filter").on("click", function() {
            applyFilters(); // Call the filtering function
        });

        // Trigger AJAX request when input fields lose focus (user clicks away or presses enter)
        $("#min_price_input, #max_price_input").on('blur', function() {
            applyFilters(); // Trigger AJAX request when input field is blurred
        });

        // Trigger AJAX request on 'Enter' key press in input fields
        $("#min_price_input, #max_price_input").on('keyup', function(event) {
            if (event.key === "Enter") {
                applyFilters(); // Trigger AJAX request when 'Enter' is pressed
            }
        });

        // Other filtering starts from here
        const categoryId = $('#category_id').data('category-id');

        function applyFilters() {
            // Serialize both forms and combine data
            const priceFilterData = $('#price-filter-form').serialize();
            const otherFilterData = $('#other-filters-form').serialize();
            const sortingData = $('#combined-filter-form').serialize();
            const combinedData = priceFilterData + '&' + otherFilterData + '&' + sortingData;

            //console.log("Combined Data:", combinedData);

            // AJAX Request
            $.ajax({
                url: `/product-category/${categoryId}`,
                method: "GET",
                data: combinedData,
                success: function(response) {
                    //console.log("AJAX Response:", response);
                    $('#search-result').html($(response).find('#search-result').html());
                    $('#pagination-container').html($(response).find('#pagination-container')
                        .html());
                },
                error: function(xhr) {
                    console.error("Error:", xhr.responseText);
                }
            });
        }

        // Trigger AJAX when filters are changed
        $('#other-filters-form, #combined-filter-form').on('change', 'select, input', function(e) {
            e.preventDefault();
            applyFilters();
        });

        // Handle pagination AJAX
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');

            //console.log("Pagination URL:", url);

            $.ajax({
                url: url,
                method: "GET",
                success: function(response) {
                    console.log("Pagination AJAX Response:", response);
                    $('#search-result').html($(response).find('#search-result').html());
                    $('#pagination-container').html($(response).find(
                        '#pagination-container').html());
                },
                error: function(xhr) {
                    console.error("Error:", xhr.responseText);
                }
            });
        });
    });
</script>
{{-- Product filering and sorting end --}}
