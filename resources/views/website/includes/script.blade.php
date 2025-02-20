<!-- JS here -->
<script src="{{asset('/')}}website/assets/js/jquery-3.7.1.js"></script>{{--<script src="{{asset('/')}}website/assets/js/vendor/jquery.js"></script>--}}
<script src="{{asset('/')}}website/assets/js/vendor/waypoints.js"></script>
<script src="{{asset('/')}}website/assets/js/bootstrap-bundle.js"></script>
<script src="{{asset('/')}}website/assets/js/meanmenu.js"></script>
<script src="{{asset('/')}}website/assets/js/swiper-bundle.js"></script>
<script src="{{asset('/')}}website/assets/js/slick.js"></script>
<script src="{{asset('/')}}website/assets/js/range-slider.js"></script>
<script src="{{asset('/')}}website/assets/js/magnific-popup.js"></script>
<script src="{{asset('/')}}website/assets/js/nice-select.js"></script>
<script src="{{asset('/')}}website/assets/js/purecounter.js"></script>
<script src="{{asset('/')}}website/assets/js/countdown.js"></script>
<script src="{{asset('/')}}website/assets/js/wow.js"></script>
<script src="{{asset('/')}}website/assets/js/isotope-pkgd.js"></script>
<script src="{{asset('/')}}website/assets/js/imagesloaded-pkgd.js"></script>
<script src="{{asset('/')}}website/assets/js/ajax-form.js"></script>
<script src="{{asset('/')}}website/assets/js/main.js"></script>


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

    $(document).ready(function () {
        $('#product-search').on('keyup', function () {  // #product-search = product name input field it
            var query = $(this).val();
            if (query.length > 0) {
                $.ajax({
                    url: "{{ route('ajax-search') }}", // URL to the search route
                    method: 'GET',
                    data: {
                        query: query
                    },
                    success: function (data) {
                        var resultsList = $('#results-list'); // #results-list = ul id
                        resultsList.empty(); // Clear previous results

                        if (data.length > 0) {
                            data.forEach(function (product) {
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
                            $('#search-results').show(); // Show the dropdown with results // #search-results =div above of ul and it contains the result
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
        $(document).click(function (e) {
            if (!$(e.target).closest('.search-container').length) {  // .search-container = main full search container
                $('#search-results').hide();
            }
        });
    });
</script>

<!--  price sorting ajax -->
{{-- <script>
    $(document).ready(function () {
        // Sorting handler
        $('#sort_by').on('change', function () {
            let sort_by = $(this).val(); // Get selected sorting option
            let category_id = $('#category_id').val(); // Get category ID (hidden field)
            let currentPage = getCurrentPage(); // Get current page for pagination

            // Fetch products based on the sort option and current page
            fetchPage(currentPage, sort_by, category_id);
        });

        // Pagination handler
        $(document).on('click', '#pagination-container a', function (e) {
            e.preventDefault(); // Prevent the default behavior of the link

            // Safely extract page number from href
            let href = $(this).attr('href');
            if (href && href.includes('page=')) {
                let page = href.split('page=')[1]; // Extract page number
                fetchPage(page); // Fetch the products for the new page
            }
        });

        // Function to get the current page number (needed for pagination)
        function getCurrentPage() {
            let currentPage = $('.pagination .active a').attr('href');
            if (currentPage && currentPage.includes('page=')) {
                return parseInt(currentPage.split('page=')[1]);
            }
            return 1; // Default to page 1 if no active page
        }

        // Function to fetch products based on sorting, category, and page
        function fetchPage(page, sort_by = $('#sort_by').val(), category_id = $('#category_id').val()) {
            $.ajax({
                url: "{{ route('sort.by') }}", // AJAX route to fetch sorted products
                method: "GET",
                data: {sort_by: sort_by, category_id: category_id, page: page}, // Pass sorting, category, and page data
                success: function (res) {
                    if (res.html) {
                        // Remove the old pagination before adding the new one
                        $('#pagination-container').empty();

                        // Replace the product list and pagination with new data
                        $('#search-result').html(res.html);

                        // Add the new pagination links
                        $('#pagination-container').html(res.pagination);
                    }
                },
                error: function (err) {
                    console.error('Error:', err); // Log any errors
                }
            });
        }
    });

</script> --}}
