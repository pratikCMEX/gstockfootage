<?php

use App\Http\Controllers\Admin\AuthAdmin;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CollectionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\LicenseController;
use App\Http\Controllers\Admin\PrivacyPolicyController;
use App\Http\Controllers\Admin\SubscriptionPlanController;
use App\Http\Controllers\Admin\TermConditionController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\VideoStreamController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WalletTransactionsController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SubCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\NoCache;
use App\Models\WebPages;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

Route::middleware([AdminAuth::class, NoCache::class])->group(function () {
    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('admin/category', [CategoryController::class, 'index'])->name('admin.category');
    Route::get('admin/add_category', [CategoryController::class, 'addCategory'])->name('admin.category_add');
    Route::post('admin/store_category', [CategoryController::class, 'store'])->name('admin.category_store');
    Route::get('admin/edit_category/{id}', [CategoryController::class, 'edit'])->name('admin.category_edit');
    Route::post('admin/update_category', [CategoryController::class, 'update'])->name('admin.category_update');
    Route::post('admin/delete_category', [CategoryController::class, 'delete'])->name('admin.category_delete');
    Route::post('admin/delete_multiple_category', [CategoryController::class, 'deleteMultiple'])->name('admin.delete_multiple_category');
    Route::post('admin/check_category_is_exist', [CategoryController::class, 'checkCategoryIsExist'])->name('admin.category_check_exist');
    Route::post('admin/toggle_category_display', [CategoryController::class, 'toggleDisplay'])->name('admin.toggle_category_display');
    Route::get('/get-subcategories/{category_id}', [CategoryController::class, 'getSubCategories']);

    Route::get('admin/sub_category', [SubCategoryController::class, 'index'])->name('admin.sub_category');
    Route::get('admin/add_sub_category', [SubCategoryController::class, 'addSubCategory'])->name('admin.sub_category_add');
    Route::post('admin/store_sub_category', [SubCategoryController::class, 'store'])->name('admin.sub_category_store');
    Route::get('admin/edit_sub_category/{id}', [SubCategoryController::class, 'edit'])->name('admin.sub_category_edit');
    Route::post('admin/update_sub_category', [SubCategoryController::class, 'update'])->name('admin.sub_category_update');
    Route::post('admin/delete_sub_category', [SubCategoryController::class, 'delete'])->name('admin.sub_category_delete');
    Route::post('admin/delete_multiple_sub_category', [SubCategoryController::class, 'deleteMultiple'])->name('admin.delete_multiple_sub_category');
    Route::post('admin/check_sub_category_is_exist', [SubCategoryController::class, 'checkSubCategoryIsExist'])->name('admin.sub_category_check_exist');

    Route::get('admin/license', [LicenseController::class, 'index'])->name('admin.license');
    Route::get('admin/add_license', [LicenseController::class, 'add_license'])->name('admin.add_license');
    Route::post('admin/store_license', [LicenseController::class, 'store'])->name('admin.store_license');
    Route::get('admin/edit_license/{id}', [LicenseController::class, 'edit'])->name('admin.license_edit');
    Route::post('admin/update_license', [LicenseController::class, 'update'])->name('admin.license_update');
    Route::post('admin/delete_license', [LicenseController::class, 'delete'])->name('admin.license_delete');
    Route::post('admin/check_license_is_exist', [LicenseController::class, 'checkLicenseIsExist'])->name('admin.license_check_exist');
    Route::post('admin/change_most_popular', [LicenseController::class, 'change_most_popular'])->name('admin.change_most_popular');

    Route::get('admin/collection', [CollectionController::class, 'index'])->name('admin.collection');
    Route::get('admin/add_collection', [CollectionController::class, 'addCollection'])->name('admin.collection_add');
    Route::post('admin/store_collection', [CollectionController::class, 'store'])->name('admin.collection_store');
    Route::get('admin/edit_collection/{id}', [CollectionController::class, 'edit'])->name('admin.collection_edit');
    Route::post('admin/update_collection', [CollectionController::class, 'update'])->name('admin.collection_update');
    Route::post('admin/delete_collection', [CollectionController::class, 'delete'])->name('admin.collection_delete');
    Route::post('admin/delete_multiple_collection', [CollectionController::class, 'deleteMultiple'])->name('admin.delete_multiple_collection');
    Route::post('admin/check_collection_is_exist', [CollectionController::class, 'checkCollectionIsExist'])->name('admin.collection_check_exist');

    Route::get('admin/subscriptions', [SubscriptionPlanController::class, 'index'])->name('admin.subscriptions');
    Route::get('admin/add_subscription', [SubscriptionPlanController::class, 'create'])->name('admin.subscription_add');
    Route::post('admin/store_subscription', [SubscriptionPlanController::class, 'store'])->name('admin.subscription_store');
    Route::get('admin/edit_subscription/{id}', [SubscriptionPlanController::class, 'edit'])->name('admin.subscription_edit');
    Route::post('admin/update_subscription', [SubscriptionPlanController::class, 'update'])->name('admin.subscription_update');
    Route::post('admin/delete_subscription', [SubscriptionPlanController::class, 'delete'])->name('admin.subscription_delete');
    Route::post('admin/change_is_active', [SubscriptionPlanController::class, 'change_is_active'])->name('admin.change_is_active');

    Route::get('admin/user', [UserController::class, 'index'])->name('admin.user');
    Route::get('admin/add_user', [UserController::class, 'addUser'])->name('admin.user_add');
    Route::post('admin/store_user', [UserController::class, 'store'])->name('admin.user_store');
    Route::get('admin/edit_user/{id}', [UserController::class, 'edit'])->name('admin.user_edit');
    Route::post('admin/update_user', [UserController::class, 'update'])->name('admin.user_update');
    Route::post('admin/delete_user', [UserController::class, 'delete'])->name('admin.user_delete');
    Route::post('admin/delete_multiple_user', [UserController::class, 'deleteMultiple'])->name('admin.delete_multiple_user');
    Route::post('admin/check_user_is_exist', [UserController::class, 'checkUserIsExist'])->name('admin.user_check_exist');

    Route::get('admin/image', [ImageController::class, 'index'])->name('admin.image');
    Route::get('admin/add_image', [ImageController::class, 'addimage'])->name('admin.image_add');
    Route::post('admin/store_image', [ImageController::class, 'store'])->name('admin.image_store');
    Route::get('admin/edit_image/{id}', [ImageController::class, 'edit'])->name('admin.image_edit');
    Route::post('admin/update_image/{id}', [ImageController::class, 'update'])->name('admin.image_update');
    Route::post('admin/delete_image', [ImageController::class, 'delete'])->name('admin.image_delete');
    Route::post('admin/delete_multiple_image', [ImageController::class, 'deleteMultiple'])->name('admin.delete_multiple_image');
    Route::post('admin/toggle_image_display', [ImageController::class, 'toggleDisplay'])->name('admin.toggle_image_display');

    Route::get('admin/product', [ProductController::class, 'index'])->name('admin.product');
    Route::get('admin/add_product', [ProductController::class, 'add'])->name('admin.product_add');
    Route::post('admin/store_product', [ProductController::class, 'store'])->name('admin.product_store');
    Route::get('admin/edit_product/{id}', [ProductController::class, 'edit'])->name('admin.product_edit');
    Route::post('admin/update_product/{id}', [ProductController::class, 'update'])->name('admin.product_update');
    Route::post('admin/delete_product', [ProductController::class, 'delete'])->name('admin.product_delete');
    Route::post('admin/delete_multiple_product', [ProductController::class, 'deleteMultiple'])->name('admin.delete_multiple_product');
    Route::post('admin/toggle_product_display', [ProductController::class, 'toggleDisplay'])->name('admin.toggle_product_display');

    Route::get('admin/video', [VideoController::class, 'index'])->name('admin.video');
    Route::get('admin/add_video', [VideoController::class, 'addvideo'])->name('admin.video_add');
    Route::post('admin/store_video', [VideoController::class, 'store'])->name('admin.video_store');
    Route::get('admin/edit_video/{id}', [VideoController::class, 'edit'])->name('admin.video_edit');
    Route::post('admin/update_video/{id}', [VideoController::class, 'update'])->name('admin.video_update');
    Route::post('admin/delete_video', [VideoController::class, 'delete'])->name('admin.video_delete');
    Route::post('admin/delete_multiple_video', [VideoController::class, 'deleteMultiple'])->name('admin.delete_multiple_video');
    Route::post('admin/toggle_video_display', [VideoController::class, 'toggleDisplay'])->name('admin.toggle_video_display');

    Route::get('admin/term_conditions', [TermConditionController::class, 'index'])->name('admin.term_conditions');
    Route::post('admin/term_conditions_store', [TermConditionController::class, 'store'])->name('admin.term_conditions_store');
    Route::post('admin/term_conditions_edit', [TermConditionController::class, 'edit'])->name('admin.term_conditions_edit');

    Route::get('admin/privacy_policy', [PrivacyPolicyController::class, 'index'])->name('admin.privacy_policy');
    Route::post('admin/privacy_policy_store', [PrivacyPolicyController::class, 'store'])->name('admin.privacy_policy_store');
    Route::post('admin/privacy_policy_edit', [PrivacyPolicyController::class, 'edit'])->name('admin.privacy_policy_edit');

    Route::get('admin/video_stream', [VideoStreamController::class, 'stream'])->name('admin.video_stream');

    Route::get('admin/transaction', [WalletTransactionsController::class, 'index'])->name('admin.transaction');
    Route::get('admin/transaction_delete', [WalletTransactionsController::class, 'delete'])->name('admin.transaction_delete');

    Route::get('admin/userplan', [PlanController::class, 'index'])->name('admin.userplan');
    Route::get('admin/userplan_delete', [PlanController::class, 'delete'])->name('admin.userplan_delete');
});

Route::get('admin/', [AuthAdmin::class, 'showLogin'])
    ->name('admin.login')->middleware(NoCache::class);

Route::post('admin/', [AuthAdmin::class, 'checkLogin'])
    ->name('admin.login.post')->middleware(NoCache::class);

Route::get('admin/logout', [AuthAdmin::class, 'logout'])
    ->name('admin.logout');
