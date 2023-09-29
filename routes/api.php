<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', 'AuthController@me');
    Route::post('logout', 'AuthController@logout');

    // role
    Route::prefix('role')->group(function () {
        Route::post('getAll', 'RoleController@getAll');
        Route::post('getByID', 'RoleController@getByID');
        Route::post('post', 'RoleController@post');
        Route::post('update', 'RoleController@update');
        Route::post('delete', 'RoleController@delete');
    });

    // user
    Route::prefix('user')->group(function () {
        Route::post('getAll', 'UserController@getAll');
        Route::post('getByID', 'UserController@getByID');
        Route::post('post', 'UserController@post');
        Route::post('update', 'UserController@update');
        Route::post('delete', 'UserController@delete');
    });

    // bizpars
    Route::prefix('bizpar')->group(function () {
        Route::post('getAll', 'BizparController@getAll');
        Route::post('getByType', 'BizparController@getByType');
        Route::post('getByKey', 'BizparController@getByKey');
        Route::post('post', 'BizparController@post');
        Route::post('update', 'BizparController@update');
        Route::post('delete', 'BizparController@delete');
    });

    // article
    Route::prefix('article')->group(function () {
        Route::post('getAll', 'ArticlesController@getAll');
        Route::post('getByID', 'ArticlesController@getByID');
        Route::post('post', 'ArticlesController@post');
        Route::post('uploadImage', 'ArticlesController@uploadImage');
        Route::post('removeImage', 'ArticlesController@removeImage');
        Route::post('update', 'ArticlesController@update');
        Route::post('delete', 'ArticlesController@delete');
    });

    // benefit
    Route::prefix('benefit')->group(function () {
        Route::post('getAll', 'BenefitsController@getAll');
        Route::post('getByID', 'BenefitsController@getByID');
        Route::post('post', 'BenefitsController@post');
        Route::post('uploadImage', 'BenefitsController@uploadImage');
        Route::post('removeImage', 'BenefitsController@removeImage');
        Route::post('update', 'BenefitsController@update');
        Route::post('delete', 'BenefitsController@delete');
    });

    // feedback
    Route::prefix('feedback')->group(function () {
        Route::post('getAll', 'FeedbacksController@getAll');
        Route::post('getByID', 'FeedbacksController@getByID');
        Route::post('post', 'FeedbacksController@post');
        Route::post('uploadImage', 'FeedbacksController@uploadImage');
        Route::post('removeImage', 'FeedbacksController@removeImage');
        Route::post('update', 'FeedbacksController@update');
        Route::post('delete', 'FeedbacksController@delete');
    });

    // permission
    Route::prefix('permission')->group(function () {
        Route::post('getAll', 'PermissionController@getAll');
        Route::post('getByID', 'PermissionController@getByID');
        Route::post('post', 'PermissionController@post');
        Route::post('update', 'PermissionController@update');
        Route::post('delete', 'PermissionController@delete');
    });

    // role permission
    Route::prefix('rolepermission')->group(function () {
        Route::post('getAll', 'RolePermissionController@getAll');
        Route::post('checkRolePermission', 'RolePermissionController@checkRolePermission');
        Route::post('post', 'RolePermissionController@post');
        Route::post('update', 'RolePermissionController@update');
        Route::post('delete', 'RolePermissionController@delete');
    });

    // category
    Route::prefix('category')->group(function () {
        Route::post('getAll', 'CategoryController@getAll');
        Route::post('getByID', 'CategoryController@getByID');
        Route::post('uploadImage', 'CategoryController@uploadImage');
        Route::post('removeImage', 'CategoryController@removeImage');
        Route::post('post', 'CategoryController@post');        
        Route::post('update', 'CategoryController@update');
        Route::post('delete', 'CategoryController@delete');
    });

    // theme
    Route::prefix('theme')->group(function () {
        Route::post('getAll', 'ThemesController@getAll');
        Route::post('getByID', 'ThemesController@getByID');
        Route::post('uploadImage', 'ThemesController@uploadImage');
        Route::post('removeImage', 'ThemesController@removeImage');
        Route::post('post', 'ThemesController@post');
        Route::post('update', 'ThemesController@update');
        Route::post('delete', 'ThemesController@delete');
    });

    // song
    Route::prefix('song')->group(function () {
        Route::post('getAll', 'SongsController@getAll');
        Route::post('getByID', 'SongsController@getByID');
        Route::post('uploadImage', 'SongsController@uploadImage');
        Route::post('removeImage', 'SongsController@removeImage');
        Route::post('post', 'SongsController@post');
        Route::post('update', 'SongsController@update');
        Route::post('delete', 'SongsController@delete');
    });

    // invitation
    Route::prefix('invitation')->group(function () {
        Route::post('getAll', 'InvitationsController@getAll');
        Route::post('getByID', 'InvitationsController@getByID');
        Route::post('uploadImage', 'InvitationsController@uploadImage');
        Route::post('removeImage', 'InvitationsController@removeImage');
        Route::post('post', 'InvitationsController@post');
        Route::post('update', 'InvitationsController@update');
        Route::post('delete', 'InvitationsController@delete');
    });

    // event
    Route::prefix('event')->group(function () {
        Route::post('getAll', 'EventsController@getAll');
        Route::post('getByID', 'EventsController@getByID');
        Route::post('uploadImage', 'EventsController@uploadImage');
        Route::post('removeImage', 'EventsController@removeImage');
        Route::post('post', 'EventsController@post');
        Route::post('update', 'EventsController@update');
        Route::post('delete', 'EventsController@delete');
    });

    // gallery
    Route::prefix('gallery')->group(function () {
        Route::post('getAll', 'GalleryController@getAll');
        Route::post('getByID', 'GalleryController@getByID');
        Route::post('uploadImage', 'GalleryController@uploadImage');
        Route::post('removeImage', 'GalleryController@removeImage');
        Route::post('post', 'GalleryController@post');
        Route::post('update', 'GalleryController@update');
        Route::post('delete', 'GalleryController@delete');
    });

    // comment
    Route::prefix('comment')->group(function () {
        Route::post('getAll', 'CommentsController@getAll');
        Route::post('getByID', 'CommentsController@getByID');
        Route::post('uploadImage', 'CommentsController@uploadImage');
        Route::post('removeImage', 'CommentsController@removeImage');
        Route::post('post', 'CommentsController@post');
        Route::post('update', 'CommentsController@update');
        Route::post('delete', 'CommentsController@delete');
    });

    // guest
    Route::prefix('guest')->group(function () {
        Route::post('getAll', 'GuestsController@getAll');
        Route::post('getByID', 'GuestsController@getByID');
        Route::post('getQuantity', 'GuestsController@getQuantity');
        Route::post('bulkUpload', 'GuestsController@bulkUpload');
        Route::post('bulkDownload', 'GuestsController@bulkDownload');
        Route::post('uploadImage', 'GuestsController@uploadImage');
        Route::post('removeImage', 'GuestsController@removeImage');
        Route::post('post', 'GuestsController@post');
        Route::post('update', 'GuestsController@update');
        Route::post('delete', 'GuestsController@delete');
    });

    // bride
    Route::prefix('bride')->group(function () {
        Route::post('getAll', 'BridesController@getAll');
        Route::post('getByID', 'BridesController@getByID');
        Route::post('uploadImage', 'BridesController@uploadImage');
        Route::post('removeImage', 'BridesController@removeImage');
        Route::post('post', 'BridesController@post');
        Route::post('update', 'BridesController@update');
        Route::post('delete', 'BridesController@delete');
    });

    // parents
    Route::prefix('parent')->group(function () {
        Route::post('getAll', 'ParentsController@getAll');
        Route::post('getByID', 'ParentsController@getByID');
        Route::post('uploadImage', 'ParentsController@uploadImage');
        Route::post('removeImage', 'ParentsController@removeImage');
        Route::post('post', 'ParentsController@post');
        Route::post('update', 'ParentsController@update');
        Route::post('delete', 'ParentsController@delete');
    });

    // special thanks
    Route::prefix('specialthanks')->group(function () {
        Route::post('getAll', 'SpecialThanksController@getAll');
        Route::post('getByID', 'SpecialThanksController@getByID');
        Route::post('uploadImage', 'SpecialThanksController@uploadImage');
        Route::post('removeImage', 'SpecialThanksController@removeImage');
        Route::post('post', 'SpecialThanksController@post');
        Route::post('update', 'SpecialThanksController@update');
        Route::post('delete', 'SpecialThanksController@delete');
    });
});

Route::prefix('auth')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
});

Route::prefix('public')->group(function () {
    Route::post('counter', 'PublicController@counter');
    Route::post('category', 'PublicController@category');
    Route::post('benefit', 'PublicController@benefit');
    Route::post('article', 'PublicController@article');
    Route::post('articleByID', 'PublicController@articleByID');
    Route::post('invitationByID', 'PublicController@invitationByID');
    Route::post('invitationByLink', 'PublicController@invitationByLink');
    Route::post('commentByInvID', 'PublicController@commentByInvID');
    Route::post('commentPost', 'PublicController@commentPost');
    Route::post('guestByInvID', 'PublicController@guestByInvID');
    Route::post('guestPost', 'PublicController@guestPost');
    Route::post('getBizparByType', 'PublicController@getBizparByType');
    Route::post('invitationReceipt', 'PublicController@invitationReceipt');
});
