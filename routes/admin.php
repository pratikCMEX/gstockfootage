<?php

use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\AffiliateController;
use App\Http\Controllers\Admin\AffiliateSettingController;
use App\Http\Controllers\Admin\AuthAdmin;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\Admin\BlogsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CollectionController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\ContentMasterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\LicenseController;
use App\Http\Controllers\Admin\PrivacyPolicyController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\SocialLinksController;
use App\Http\Controllers\Admin\SubscriptionPlanController;
use App\Http\Controllers\Admin\TermConditionController;
use App\Http\Controllers\Admin\TestimonialsController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\VideoStreamController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WalletTransactionsController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Affiliate\AffiliateAuthController;
use App\Http\Controllers\Affiliate\AffiliateProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\NoCache;
use App\Models\WebPages;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;



Route::post('admin/vide_batch/{batch}', [BatchController::class, 'uploadMultipleVideos'])->name('batch.video_upload');
Route::post('admin/image_upload/{batch}', [BatchController::class, 'uploadFiles'])->name('batch.image_upload');
Route::post('admin/batch/get_file_metadata', [BatchController::class, 'getFileMetadata']);
Route::post('/generate-ai-content', [BatchController::class, 'generateAiContent']);
Route::post('admin/batch/save_file_metadata', [BatchController::class, 'saveFileMetadata']);
Route::post('admin/batch/rename', [BatchController::class, 'UpdateBatchName']);
Route::post('admin/batch/delete', [BatchController::class, 'DeleteBatch']);
Route::middleware([AdminAuth::class, NoCache::class])->group(function () {
    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::post('admin/update_profile', [ProfileController::class, 'update_profile'])->name('admin.update_profile');
    Route::post('admin/update_password', [ProfileController::class, 'update_password'])->name('admin.update_password');
    Route::post('admin/check_password', [ProfileController::class, 'check_password'])->name('admin.check_password');

    Route::get('admin/banner', [BannerController::class, 'addUpdate'])->name('admin.banner');
    Route::post('admin/banner_store', [BannerController::class, 'store'])->name('admin.banner_store');

    Route::get('admin/batch', [BatchController::class, 'index'])->name('admin.batch');
    Route::get('admin/add_new_img/{id}', [BatchController::class, 'add_new_img'])->name('admin.add_new_img');
    Route::post('admin/store_batch', [BatchController::class, 'store'])->name('admin.storeBatch');
    Route::post('admin/batch/{batch}', [BatchController::class, 'uploadMultiple'])->name('batch.upload');
    Route::post('admin/batch_delete', [BatchController::class, 'deleteMultiple'])->name('batch.delete_multiple');
    Route::post('admin/batch/check_brief_code', [BatchController::class, 'checkBriefCode'])->name('batch.check_brief_code');
    // Route::post('admin/batch/{batch}', [BatchController::class, 'uploadMultipleVideos'])->name('batch.video_upload');

    Route::get('admin/testimonials', [TestimonialsController::class, 'index'])->name('admin.testimonials');
    Route::get('admin/add_testimonials', [TestimonialsController::class, 'add'])->name('admin.testimonials_add');
    Route::post('admin/store_testimonials', [TestimonialsController::class, 'store'])->name('admin.testimonials_store');
    Route::get('admin/edit_testimonials/{id}', [TestimonialsController::class, 'edit'])->name('admin.testimonials_edit');
    Route::post('admin/update_testimonials', [TestimonialsController::class, 'update'])->name('admin.testimonials_update');
    Route::post('admin/delete_testimonial', [TestimonialsController::class, 'delete'])->name('admin.testimonials_delete');
    Route::post('admin/delete_multiple_testimonials', [TestimonialsController::class, 'deleteMultiple'])->name('admin.delete_multiple_testimonials');
    Route::post('admin/change_active_status', [TestimonialsController::class, 'change_active_status'])->name('admin.change_active_status');

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
    Route::post('admin/delete_multiple_license', [LicenseController::class, 'deleteMultiple'])->name('admin.delete_multiple_license');

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
    Route::post('admin/check_subscription_plan_is_exist', [SubscriptionPlanController::class, 'checkSubcriptionPlanIsExist'])->name('admin.subscription_plan_check_exist');
    Route::post('admin/delete_multiple_subscription_plan', [SubscriptionPlanController::class, 'deleteMultiple'])->name('admin.delete_multiple_subscription_plan');

    Route::get('admin/user', [UserController::class, 'index'])->name('admin.user');
    Route::get('admin/add_user', [UserController::class, 'addUser'])->name('admin.user_add');
    Route::post('admin/store_user', [UserController::class, 'store'])->name('admin.user_store');
    Route::get('admin/edit_user/{id}', [UserController::class, 'edit'])->name('admin.user_edit');
    Route::post('admin/update_user', [UserController::class, 'update'])->name('admin.user_update');
    Route::post('admin/delete_user', [UserController::class, 'delete'])->name('admin.user_delete');
    Route::post('admin/delete_multiple_user', [UserController::class, 'deleteMultiple'])->name('admin.delete_multiple_user');
    Route::post('admin/check_user_is_exist', [UserController::class, 'checkUserIsExist'])->name('admin.user_check_exist');
    Route::post('admin/check_user_is_valid', [UserController::class, 'checkUserValid'])->name('admin.user_check_valid');

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

    Route::get('admin/product/priority', [ProductController::class, 'priority'])->name('admin.product_priority');
    Route::post('admin/product/update-priority', [ProductController::class, 'updatePriority'])->name('admin.product.updatePriority');

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

    Route::get('admin/blog', [BlogsController::class, 'index'])->name('admin.blog');
    Route::get('admin/blog/add', [BlogsController::class, 'add'])->name('admin.blog_add');
    Route::post('admin/blog/store', [BlogsController::class, 'store'])->name('admin.blog_store');
    Route::get('admin/blog/edit/{id}', [BlogsController::class, 'edit'])->name('admin.blog_edit');
    Route::post('admin/blog/update', [BlogsController::class, 'update'])->name('admin.blog_update');
    Route::post('admin/delete_blog', [BlogsController::class, 'delete'])->name('admin.blog_delete');
    Route::post('admin/delete_multiple_blog', [BlogsController::class, 'deleteMultiple'])->name('admin.delete_multiple_blog');


    // reports
    Route::get('admin/order_history', [ReportsController::class, 'order_history'])->name('admin.order_history');
    Route::get('/admin/order_detail/{id}', [ReportsController::class, 'detail'])->name('admin.order_detail');
    Route::get('admin/user_subscriptions_list', [ReportsController::class, 'user_subscriptions_report'])->name('admin.user_subscriptions_report');
    Route::get('admin/most_sold_product_report', [ReportsController::class, 'most_sold_product_report'])->name('admin.most_sold_product_report');
    Route::get('admin/most_viewed_product_report', [ReportsController::class, 'most_viewed_product_report'])->name('admin.most_viewed_product_report');
    Route::get('admin/live_cart_report', [ReportsController::class, 'live_cart_report'])->name('admin.live_cart_report');
    Route::get('admin/user_wise_order_report', [ReportsController::class, 'user_wise_order_report'])->name('admin.user_wise_order_report');


    Route::get('admin/content', [ContentMasterController::class, 'index'])->name('admin.content');
    Route::post('admin/content/store', [ContentMasterController::class, 'store'])->name('admin.content_store');

    Route::get('admin/about_us', [AboutUsController::class, 'index'])->name('admin.about_us');
    Route::post('admin/about_us/store', [AboutUsController::class, 'store'])->name('admin.about_us_save');

    Route::get('admin/social_links', [SocialLinksController::class, 'index'])->name('admin.social_links');
    Route::post('admin/social_links/store', [SocialLinksController::class, 'store'])->name('admin.social_links_store');



    Route::get('admin/contact_us', [ContactUsController::class, 'index'])->name('admin.contact_us');
    Route::post('admin/delete_contact_us', [ContactUsController::class, 'delete'])->name('admin.contact_us_delete');
    Route::post('admin/delete_multiple_contacts', [ContactUsController::class, 'deleteMultiple'])->name('admin.delete_multiple_contact');

    Route::get('admin/transaction', [WalletTransactionsController::class, 'index'])->name('admin.transaction');
    Route::get('admin/transaction_delete', [WalletTransactionsController::class, 'delete'])->name('admin.transaction_delete');

    Route::get('admin/userplan', [PlanController::class, 'index'])->name('admin.userplan');
    Route::get('admin/userplan_delete', [PlanController::class, 'delete'])->name('admin.userplan_delete');

    // In routes/web.php inside admin middleware group
    Route::get('admin/affiliate-setting', [AffiliateSettingController::class, 'index'])
        ->name('admin.affiliate.setting');

    Route::post('admin/affiliate-setting/update', [AffiliateSettingController::class, 'update'])
        ->name('admin.affiliate.setting.update');

    Route::get('admin/affiliates', [AffiliateController::class, 'index'])->name('admin.affiliates.list');
    Route::get('admin/affiliates/create', [AffiliateController::class, 'create'])->name('admin.affiliates.create');
    Route::post('admin/affiliates/store', [AffiliateController::class, 'store'])->name('admin.affiliates.store');
    Route::get('admin/affiliates/{id}/edit', [AffiliateController::class, 'edit'])->name('admin.affiliates.edit');
    Route::put('admin/affiliates/{id}/update', [AffiliateController::class, 'update'])->name('admin.affiliates.update');
    // Route::post('admin/affiliates/{id}/toggle-status', [AffiliateController::class, 'toggleStatus'])->name('admin.affiliates.toggle_status');
    Route::post('admin/affiliates/toggle-status', [AffiliateController::class, 'toggleStatus'])->name('admin.affiliates.toggle_status');
    // Route::delete('admin/affiliates/{id}/delete', [AffiliateController::class, 'destroy'])->name('admin.affiliates.destroy');
    Route::post('admin/affiliates/delete', [AffiliateController::class, 'destroy'])->name('admin.affiliates.delete');
});

Route::get('admin/', [AuthAdmin::class, 'showLogin'])
    ->name('admin.login')->middleware(NoCache::class);

Route::post('admin/', [AuthAdmin::class, 'checkLogin'])
    ->name('admin.login.post')->middleware(NoCache::class);

Route::get('admin/logout', [AuthAdmin::class, 'logout'])
    ->name('admin.logout');


Route::prefix('affiliate')->name('affiliate.')->group(function () {

    Route::middleware('affiliate.auth')->group(function () { //  use string alias
        Route::get('dashboard', [AffiliateAuthController::class, 'dashboard'])->name('dashboard');
        Route::get('referrals', [AffiliateAuthController::class, 'referrals'])->name('referrals');
        Route::get('commission_history', [AffiliateAuthController::class, 'commission_history'])->name('commission_history');
        Route::get('pending_payments', [AffiliateAuthController::class, 'pending_payments'])->name('pending_payments');
        Route::post('logout', [AffiliateAuthController::class, 'logout'])->name('logout');

          Route::get('my_profile', [AffiliateProfileController::class, 'index'])->name('my_profile');
          Route::post('update_profile', [AffiliateProfileController::class, 'update_profile'])->name('update_profile');
    });

});
