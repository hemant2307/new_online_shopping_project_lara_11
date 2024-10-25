<?php

use App\Http\Controllers\admin\adminController;
use App\Http\Controllers\admin\brandController;
use App\Http\Controllers\admin\categoryController;
use App\Http\Controllers\admin\discountController;
use App\Http\Controllers\admin\orderController;
use App\Http\Controllers\admin\productController;
use App\Http\Controllers\admin\productImagecontroller;
use App\Http\Controllers\admin\productSubCategoryController;
use App\Http\Controllers\admin\shippingController;
use App\Http\Controllers\admin\subCategoryController;
use App\Http\Controllers\admin\tempImageController;
use App\Http\Controllers\cartController;
use App\Http\Controllers\frontController;
use App\Http\Controllers\shopController;
use App\Http\Controllers\user\userController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('clear', function () {
    Artisan::call('route:cache');
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize');
    Artisan::call('optimize:clear');
    return 'Routes, View, Config cache and optimize cleared!';
});



// front-page routes starts here

Route::get('home-page',[frontController::class , 'index'])->name('front.home');
// shop-pages routes here
Route::get('shop-page/{categoryslug?}/{subcategoryslug?}/',[shopController::class , 'index'])->name('front.shop');
Route::get('product-page/{slug}',[shopController::class , 'getProduct'])->name('shop.product');
Route::get('cart/',[cartController::class , 'cart'])->name('shop.cart');
Route::POST('add-to-cart/',[cartController::class , 'addToCart'])->name('shop.addToCart');
Route::POST('update-cart/',[cartController::class , 'updatecart'])->name('shop.updateCart');
Route::get('delete-cart-item/',[cartController::class , 'deleteCartItem'])->name('shop.deleteCartItem');
Route::get('checkout/',[cartController::class , 'checkout'])->name('shop.checkout');
Route::POST('checkout-process/',[cartController::class , 'checkOutProcess'])->name('shop.checkOutProcess');
Route::POST('get-order-summery/',[cartController::class , 'getOrderSummery'])->name('shop.getOrderSummery');
Route::POST('apply-discount/',[cartController::class , 'applyDiscount'])->name('shop.apply-discount');
Route::POST('remove-discount/',[cartController::class , 'removeCoupon'])->name('shop.removeCoupon');
Route::get('Thank-You/{orderId}',[cartController::class , 'thankyou'])->name('shop.cart.thankyou');


// front-page routes end here



// user routes here
Route::group(['prefix' => 'user'],function(){
        Route::group(['middleware' => 'guest'],function(){
            Route::get('user-register',[userController::class , 'register'])->name('user.register');
            Route::POST('user-register-process',[userController::class , 'saveUser'])->name('user.saveUser');

            Route::get('user-login',[userController::class , 'login'])->name('user.login');
            Route::POST('user-authentication',[userController::class , 'authentication'])->name('user.authentication');

    });
        Route::group(['middleware' => 'auth'],function(){
            Route::get('user-dashboard',[userController::class , 'dashboard'])->name('user.user-dashboard');
            Route::get('user-logout',[userController::class , 'logout'])->name('user.logout');

     // User's myOrders route here
            Route::get('user-myorders',[userController::class , 'myOrders'])->name('user.myorders');
            Route::get('user-myorder-detail/{orderId}',[userController::class , 'orderDetail'])->name('user.myorder-detail');
    });

});


// admin routes here
Route::group(['prefix' => 'admin'],function(){
    Route::group(['middleware' => 'admin.guest'],function(){
        Route::get('admin-login',[adminController::class , 'login'])->name('admin.login');
        Route::POST('admin-authentication',[adminController::class , 'authentication'])->name('admin.authentication');
    });

    Route::group(['middleware' => 'admin.auth'],function(){
        Route::get('admin-dashboard',[adminController::class , 'dashboard'])->name('admin.admin-dashboard');
        Route::get('admin-logout',[adminController::class , 'logout'])->name('admin.logout');

     // category routes here
        Route::get('create-category',[categoryController::class , 'create'])->name('admin.category.create');
        Route::POST('store-category',[categoryController::class , 'store'])->name('admin.category.store');
        Route::get('list-category',[categoryController::class , 'list'])->name('admin.category.list');
        Route::get('edit-category/{id}/edit',[categoryController::class , 'edit'])->name('admin.category.edit');
        Route::POST('update-category/{id}',[categoryController::class , 'update'])->name('admin.category.update');
        Route::get('delete-category/{id}',[categoryController::class , 'delete'])->name('admin.category.delete');

    //    temp-image route here
        Route::POST('upload-temp-image',[tempImageController::class , 'create'])->name('temp-images.create');

     // slug route here
        Route::get('/getSlug',function(Request $request){
            $slug = "";
            if(!empty($request->title)){
                $slug = Str::slug($request->title);
            }
            return response()->json([
                'status' => true,
                'slug' => $slug
            ]);
        })->name('getSlug');
    // slug route end here


    // sub-category routes here
        Route::get('create-sub-category',[subCategoryController::class , 'create'])->name('admin.sub-category.create');
        Route::POST('store-sub-category',[subCategoryController::class , 'store'])->name('admin.sub-category.store');
        Route::get('list-sub-category',[subCategoryController::class , 'list'])->name('admin.sub-category.list');
        Route::get('edit-sub-category/{id}/edit',[subCategoryController::class , 'edit'])->name('admin.sub-category.edit');
        Route::POST('update-sub-category/{id}',[subCategoryController::class , 'update'])->name('admin.sub-category.update');
        Route::get('delete-sub-category/{id}',[subCategoryController::class , 'delete'])->name('admin.sub-category.delete');

    // subCategory-Product route here  (using it inside the product route)
          Route::get('subcategory-product',[productSubCategoryController::class , 'index'])->name('productSubCategory.index');

    // Brands routes here
        Route::get('create-brand',[brandController::class , 'create'])->name('admin.brand.create');
        Route::POST('store-brand',[brandController::class , 'store'])->name('admin.brand.store');
        Route::get('list-brand',[brandController::class , 'list'])->name('admin.brand.list');
        Route::get('edit-brand/{id}/edit',[brandController::class , 'edit'])->name('admin.brand.edit');
        Route::POST('update-brand/{id}',[brandController::class , 'update'])->name('admin.brand.update');
        Route::get('delete-brand/{id}',[brandController::class , 'delete'])->name('admin.brand.delete');

    // shipping-charges routes here
        Route::get('create-shipping',[shippingController::class , 'create'])->name('admin.shipping.create');
        Route::POST('store-shipping',[shippingController::class , 'store'])->name('admin.shipping.store');
        Route::get('edit-shipping/{id}',[shippingController::class , 'edit'])->name('admin.shipping.edit');
        Route::POST('update-shipping/{id}',[shippingController::class , 'update'])->name('admin.shipping.update');
        Route::get('delete-shipping',[shippingController::class , 'delete'])->name('admin.shipping.delete');
        Route::get('list-shipping',[shippingController::class , 'list'])->name('admin.shipping.list');

    // products route here
        Route::get('create-product',[productController::class , 'create'])->name('admin.product.create');
        Route::POST('store-product',[productController::class , 'store'])->name('admin.product.store');
        Route::get('list-product',[productController::class , 'list'])->name('admin.product.list');
        Route::get('edit-product/{id}/product',[productController::class , 'edit'])->name('admin.product.edit');
        Route::POST('update-product/{id}/product',[productController::class , 'update'])->name('admin.product.update');
        Route::delete('delete-product/{id}/product',[productController::class , 'destroy'])->name('admin.product.destroy');
        Route::POST('update-product-images/',[productImagecontroller::class , 'update'])->name('admin.product.image.update');
        Route::delete('delete-product-images/',[productImagecontroller::class , 'destroy'])->name('admin.product.image.destroy');

    // related product route
        Route::get('related-product/',[productController::class , 'getProduct'])->name('admin.product.getproduct');

    // orders route here
    Route::get('list-order-table',[orderController::class , 'tableOrders'])->name('admin.order.table.list');
        Route::get('list-order',[orderController::class , 'list'])->name('admin.order.list');
        Route::get('detail-order/{orderId}',[orderController::class , 'Orderdetail'])->name('admin.order.detail');
        Route::POST('order/change/Order-Status/{orderId}',[orderController::class , 'changeOrderStatus'])->name('admin.order.changeOrderStatus');


        // Route::get('edit-order',[orderController::class , 'edit'])->name('admin.order.edit');
        // Route::get('update-order',[orderController::class , 'update'])->name('admin.order.update');
        // Route::get('delete-order',[orderController::class , 'delete'])->name('admin.order.delete');


    // discount routes here
        Route::get('list-discount',[discountController::class , 'list'])->name('admin.discount.list');
        Route::get('create-discount',[discountController::class , 'create'])->name('admin.discount.create');
        Route::POST('store-discount',[discountController::class , 'store'])->name('admin.discount.store');
        Route::get('edit-discount/{id}',[discountController::class , 'edit'])->name('admin.discount.edit');
        Route::POST('update-discount/{id}',[discountController::class , 'update'])->name('admin.discount.update');
        Route::delete('delete-discount/{id}',[discountController::class , 'delete'])->name('admin.discount.delete');


    });


});
