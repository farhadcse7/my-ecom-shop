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


<script>
    //price range slider script
    $(function() {
        // Initialize the range slider
        $("#slider-range").slider({
            range: true,
            min: 0, // Minimum price
            max: 200000, // Maximum price (adjust based on your product prices)
            values: [
                {{ request('min_price', 0) }}, // Default min price
                {{ request('max_price', 200000) }} // Default max price
            ],
            slide: function(event, ui) {
                // Update the displayed price range
                $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
                // Update the hidden inputs
                $("#min_price").val(ui.values[0]);
                $("#max_price").val(ui.values[1]);
            },
            change: function(event, ui) {
                // Submit the form when the slider value changes
                document.getElementById('price-filter-form').submit();
            }
        });

        // Set initial display value
        $("#amount").val("$" + $("#slider-range").slider("values", 0) +
            " - $" + $("#slider-range").slider("values", 1));
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

<script>
    $(document).ready(function() {
        console.log("Document is ready");
        // const categoryId = $('#category_id').val(); // Fetching value instead of data attribute
        const categoryId = $('#category_id').data('category-id');

        function applyFilters() {
            // Serialize both forms and combine data
            const filterData = $('#other-filters-form').serialize();
            const sortingData = $('#combined-filter-form').serialize();
            const combinedData = filterData + '&' + sortingData;

            console.log("Combined Data:", combinedData);

            // AJAX Request
            $.ajax({
                url: `/product-category/${categoryId}`,
                method: "GET",
                data: combinedData,
                success: function(response) {
                    console.log("AJAX Response:", response);
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

            console.log("Pagination URL:", url);

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
