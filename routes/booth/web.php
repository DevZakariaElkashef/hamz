<?php

use App\Http\Controllers\Booth\Admin\AttributeController;
use App\Http\Controllers\Booth\Admin\BrandController;
use App\Http\Controllers\Booth\Admin\CategoryController;
use App\Http\Controllers\Booth\Admin\CouponController;
use App\Http\Controllers\Booth\Admin\HomeController;
use App\Http\Controllers\Booth\Admin\ImageController;
use App\Http\Controllers\Booth\Admin\InvoiceController;
use App\Http\Controllers\Booth\Admin\OptionController;
use App\Http\Controllers\Booth\Admin\OrderController;
use App\Http\Controllers\Booth\Admin\OrderItemController;
use App\Http\Controllers\Booth\Admin\ProductController;
use App\Http\Controllers\Booth\Admin\ReportController;
use App\Http\Controllers\Booth\Admin\SectionController;
use App\Http\Controllers\Booth\Admin\SliderController;
use App\Http\Controllers\Booth\Admin\StoreController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('booth.home');

// images
    Route::delete('delete-image', [ImageController::class, 'destroy'])->name('images.destroy');
// images

    Route::as('booth.')->group(function () {
        /**start Slider Routes */
        Route::resource('sliders', SliderController::class);
        Route::get('search-sliders', [SliderController::class, 'search'])->name('sliders.search');
        Route::get('sliders-toggle-status/{slider}', [SliderController::class, 'toggleStatus'])->name('slider.toggleStatus');
        Route::get('sliders-toggle-fixed-status/{slider}', [SliderController::class, 'toggleFixedStatus'])->name('slider.toggleFixedStatus');
        Route::delete('delete-sliders', [SliderController::class, 'delete'])->name('sliders.delete');
        /**end Slider Routes */

        /**start Slider Routes */
        Route::resource('sections', SectionController::class);
        Route::get('search-sections', [SectionController::class, 'search'])->name('sections.search');
        Route::get('sections-toggle-status/{section}', [SectionController::class, 'toggleStatus'])->name('sections.toggleStatus');
        Route::get('sections-export', [SectionController::class, 'export'])->name('sections.export');
        Route::post('sections-import', [SectionController::class, 'import'])->name('sections.import');
        Route::delete('delete-sections', [SectionController::class, 'delete'])->name('sections.delete');
        /**end Slider Routes */

        /**start Slider Routes */
        Route::resource('stores', StoreController::class);
        Route::get('search-stores', [StoreController::class, 'search'])->name('stores.search');
        Route::get('stores-toggle-status/{store}', [StoreController::class, 'toggleStatus'])->name('stores.toggleStatus');
        Route::get('stores-export', [StoreController::class, 'export'])->name('stores.export');
        Route::post('stores-import', [StoreController::class, 'import'])->name('stores.import');
        Route::get('stores-by-section', [StoreController::class, 'getStoresBySection'])->name('stores.bySection');
        Route::delete('delete-stores', [StoreController::class, 'delete'])->name('stores.delete');
        /**start Slider Routes */

        /**start Slider Routes */
        Route::resource('coupons', CouponController::class);
        Route::get('search-coupons', [CouponController::class, 'search'])->name('coupons.search');
        Route::get('coupons-toggle-status/{coupon}', [CouponController::class, 'toggleStatus'])->name('coupon.toggleStatus');
        Route::get('coupons-export', [CouponController::class, 'export'])->name('coupons.export');
        Route::post('coupons-import', [CouponController::class, 'import'])->name('coupons.import');
        Route::delete('delete-coupons', [CouponController::class, 'delete'])->name('coupons.delete');
        /**end Slider Routes */

        /**start Slider Routes */
        Route::resource('categories', CategoryController::class);
        Route::get('search-categories', [CategoryController::class, 'search'])->name('categories.search');
        Route::get('categories-toggle-status/{category}', [CategoryController::class, 'toggleStatus'])->name('categories.toggleStatus');
        Route::get('categories-export', [CategoryController::class, 'export'])->name('categories.export');
        Route::post('categories-import', [CategoryController::class, 'import'])->name('categories.import');
        Route::get('categories-by-store', [CategoryController::class, 'getCategoriesBystore'])->name('categories.byStore');
        Route::get('categories-by-section', [CategoryController::class, 'getCategoriesBySection'])->name('categories.bySection');
        Route::delete('delete-categories', [CategoryController::class, 'delete'])->name('categories.delete');

        /**start Slider Routes */
        Route::resource('brands', BrandController::class);
        Route::get('search-brands', [BrandController::class, 'search'])->name('brands.search');
        Route::get('brands-toggle-status/{brand}', [BrandController::class, 'toggleStatus'])->name('brands.toggleStatus');
        Route::get('brands-export', [BrandController::class, 'export'])->name('brands.export');
        Route::post('brands-import', [BrandController::class, 'import'])->name('brands.import');
        Route::get('brands-by-store', [BrandController::class, 'getBrandsBystore'])->name('brands.byStore');
        Route::get('brands-by-section', [BrandController::class, 'getbrandsBySection'])->name('brands.bySection');
        Route::delete('delete-brands', [BrandController::class, 'delete'])->name('brands.delete');

        /**start Slider Routes */
        Route::resource('attributes', AttributeController::class);
        Route::get('search-attributes', [AttributeController::class, 'search'])->name('attributes.search');
        Route::get('attributes-toggle-status/{attribute}', [AttributeController::class, 'toggleStatus'])->name('attributes.toggleStatus');
        Route::get('attributes-export', [AttributeController::class, 'export'])->name('attributes.export');
        Route::post('attributes-import', [AttributeController::class, 'import'])->name('attributes.import');
        Route::delete('delete-attributes', [AttributeController::class, 'delete'])->name('attributes.delete');

        /**start Slider Routes */
        Route::resource('options', OptionController::class);
        Route::get('search-options', [OptionController::class, 'search'])->name('options.search');
        Route::get('options-toggle-status/{option}', [OptionController::class, 'toggleStatus'])->name('options.toggleStatus');
        Route::get('options-export', [OptionController::class, 'export'])->name('options.export');
        Route::post('options-import', [OptionController::class, 'import'])->name('options.import');
        Route::get('options-by-attribute', [OptionController::class, 'getOptionsByAttribute'])->name('options.byAttribute');
        Route::delete('delete-options', [OptionController::class, 'delete'])->name('options.delete');

        /**start Slider Routes */
        Route::resource('products', ProductController::class);
        Route::get('search-products', [ProductController::class, 'search'])->name('products.search');
        Route::get('products-toggle-status/{product}', [ProductController::class, 'toggleStatus'])->name('products.toggleStatus');
        Route::get('products-export', [ProductController::class, 'export'])->name('products.export');
        Route::post('products-import', [ProductController::class, 'import'])->name('products.import');
        Route::get('/fetch-products/{product}', [ProductController::class, 'fetchProductDetails'])->name('booth.product.details');
        Route::delete('delete-products', [ProductController::class, 'delete'])->name('products.delete');
        /**end Slider Routes */

        /**start Slider Routes */
        Route::resource('orders', OrderController::class);
        Route::get('search-orders', [OrderController::class, 'search'])->name('orders.search');
        Route::get('orders-toggle-status/{product}', [OrderController::class, 'toggleStatus'])->name('orders.toggleStatus');
        Route::get('orders-export', [OrderController::class, 'export'])->name('orders.export');
        Route::post('orders-update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::post('orders-update-payment', [OrderController::class, 'updatePayment'])->name('orders.updatePayment');
        Route::delete('delete-orders', [OrderController::class, 'delete'])->name('orders.delete');
        /**end Slider Routes */

        /**start Slider Routes */
        Route::resource('orderitems', OrderItemController::class);
        /**end Slider Routes */

        /**start Slider Routes */
        Route::get('orders-invoice/{order}', [InvoiceController::class, 'show'])->name('invoices.show');
        /**end Slider Routes */

        /**Start Slider Routes */
        Route::get('/reports/product-sales', [ReportController::class, 'allProductSalesReport'])->name('reports.allProductSales');
        Route::get('/reports/product-sales-search', [ReportController::class, 'searchAllProductSalesReport'])->name('reports.allProductSalesSearch');
        Route::get('/reports/product-sales-export', [ReportController::class, 'exportAllProductSalesReport'])->name('reports.allProductSalesExport');
        /**end Slider Routes */

        /**end Slider Routes */
        Route::get('/reports/vendor-sales', [ReportController::class, 'allVendorSalesReport'])->name('reports.allVendorSales');
        Route::get('/reports/vendor-sales-search', [ReportController::class, 'searchAllVendorSalesReport'])->name('reports.allVendorSalesSearch');
        Route::get('/reports/vendor-sales-export', [ReportController::class, 'exportAllVendorSalesReport'])->name('reports.allVendorSalesExport');
        /**end Slider Routes */

        /**end Slider Routes */
        Route::get('/reports/order-status', [ReportController::class, 'orderStatusReport'])->name('reports.orderStatus');
        Route::get('/reports/order-status-export', [ReportController::class, 'exportOrderStatusReport'])->name('reports.orderStatusExport');
        /**end Slider Routes */

        /**end Slider Routes */
        Route::get('/reports/order-details', [ReportController::class, 'allOrderDetailsReport'])->name('reports.allOrderDetails');
        Route::get('/reports/order-details-search', [ReportController::class, 'searchAllOrderDetailsReport'])->name('reports.allOrderDetailsSearch');
        Route::get('/reports/order-details-export', [ReportController::class, 'exportAllOrderDetailsReport'])->name('reports.allOrderDetailsExport');
        /**end Slider Routes */

        /**end Slider Routes */
        Route::get('/reports/customer-activity', [ReportController::class, 'customerActivityReport'])->name('reports.customerActivity');
        Route::get('/reports/customer-activity-search', [ReportController::class, 'searchCustomerActivityReport'])->name('reports.customerActivitySearch');
        Route::get('/reports/customer-activity-export', [ReportController::class, 'exportCustomerActivityReport'])->name('reports.customerActivityExport');
        /**end Slider Routes */

        /**end Slider Routes */
        Route::get('/reports/low-stock-alerts', [ReportController::class, 'lowStockAlertsReport'])->name('reports.lowStockAlerts');
        Route::get('/reports/low-stock-alerts-search', [ReportController::class, 'searchLowStockAlertsReport'])->name('reports.lowStockAlertsSearch');
        Route::get('/reports/low-stock-alerts-export', [ReportController::class, 'exportLowStockAlertsReport'])->name('reports.lowStockAlertsExport');
        /**end Slider Routes */
    });
});
