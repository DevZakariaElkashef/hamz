<script>
    async function fetchData(url, data, targetElement) {
        try {
            // Build query string from data object
            const params = new URLSearchParams(data).toString();

            // Send GET request with query string
            const response = await fetch(`${url}?${params}`);

            // Check if response is ok
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            // Assuming the response is HTML, use text()
            const result = await response.text();

            // Update the target element with the response HTML
            $(targetElement).html(result); // jQuery style selection
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    }

    $(document).on('change', '#sectionId', async function() {
        const sectionId = $(this).val();

        // Fetch stores, categories, and brands by section
        await fetchData("{{ route('mall.stores.bySection') }}", {
            sectionId: sectionId
        }, '#storeId');
        await fetchData("{{ route('mall.categories.bySection') }}", {
            sectionId: sectionId
        }, '#categoryId');
        await fetchData("{{ route('mall.brands.bySection') }}", {
            sectionId: sectionId
        }, '#brandId');
    });

    $(document).on('change', '#storeId', async function() {
        const storeId = $(this).val();

        // Fetch categories and brands by store
        await fetchData("{{ route('mall.categories.byStore') }}", {
            storeId: storeId
        }, '#categoryId');
        await fetchData("{{ route('mall.brands.byStore') }}", {
            storeId: storeId
        }, '#brandId');
    });
</script>
