<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\IncidenceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DocumentIncidenceController;
use App\Http\Controllers\ImageIncidenceController;
use App\Http\Controllers\DocumentIncidenceResponseController;
use App\Http\Controllers\ResponseIncidenceController;
use Illuminate\Support\Facades\Storage;

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

Route::middleware(['jwt.verify'])->group(function() {
    //Routes api users
    Route::get('users/{id}', [UserController::class, 'getUserById']);

    //Routes api incidents
    Route::get('incidents/page/{page}/category/{categoryId}/priority/{priorityId}/user/{userId}', [IncidenceController::class, 'getIncidents']);
    Route::get('incidents/{id}', [IncidenceController::class, 'getDetailIncidenceById']);
    Route::get('incidents/users/{userId}', [IncidenceController::class, 'getIncidentsByUser']);
    Route::get('incidents/document/{id}', [DocumentIncidenceController::class, 'getDocumentIncidenceById']);
    Route::get('incidents/image/{id}', [ImageIncidenceController::class, 'getImageIncidenceById']);
    Route::get('incidents/get/totalIncidents', [IncidenceController::class, 'getTotalIncidents']);
    Route::get('incidents/get/totalOpenIncidents', [IncidenceController::class, 'getTotalOpenIncidents']);
    Route::get('incidents/get/totalCloseIncidents', [IncidenceController::class, 'getTotalCloseIncidents']);
    Route::get('incidents/get/totalIncidentsByCategory', [IncidenceController::class, 'getTotalIncidentsByCategory']);
    Route::post('incidents/{id}/response', [ResponseIncidenceController::class, 'saveIncidenceResponse']);
    Route::get('incidents/{id}/response', [ResponseIncidenceController::class, 'getResponseIncidenceDetailById']);
    Route::get('incidents/response/document/{id}', [DocumentIncidenceResponseController::class, 'getDocumentIncidenceResponseById']);

    //Routes api categories
    Route::get('categories', [CategoryController::class, 'getCategoriesAll']);

    //Routes api priorities
    Route::get('priorities', [PriorityController::class, 'getPrioritiesAll']);

    //Route download document incident
    Route::post('private/documents/{document}', function($document) {
        return response()->file(storage_path("app/private/documents/".$document));
    });

    //Route download image incident
    Route::post('private/images/{image}', function($image) {
        return response()->file(storage_path("app/private/images/".$image));
    });

    //Route download document response incidence
    Route::post('private/documents_response/{document}', function($document) {
        return response()->file(storage_path("app/private/documents_response/".$document));
    });
});

Route::middleware(['jwt.verify', 'jwt.admin'])->group(function () {
    //Routes api categories
    Route::get('categories/{page}/get', [CategoryController::class, 'getCategories']);
    Route::get('categories/active', [CategoryController::class, 'getCategoriesActive']);
    Route::get('categories/{id}/subcategories', [CategoryController::class, 'getSubcategoriesByIdCategory']);
    Route::get('categories/{id}', [CategoryController::class, 'getCategoryById']);
    Route::post('categories/create', [CategoryController::class, 'saveCategory']);
    Route::put('categories/{id}', [CategoryController::class, 'updateCategory']);
    Route::put('categories/{id}/changeState', [CategoryController::class, 'changeStateCategory']);

    //Routes api subcategories
    Route::get('subcategories/{page}/get', [SubcategoryController::class, 'getSubcategories']);
    Route::get('subcategories/{id}', [SubcategoryController::class, 'getSubcategoryById']);
    Route::post('subcategories/create', [SubcategoryController::class, 'saveSubcategory']);
    Route::put('subcategories/{id}', [SubcategoryController::class, 'updateSubcategory']);
    Route::put('subcategories/{id}/changeState', [SubcategoryController::class, 'changeStateSubcategory']);

    //Routes api priorities
    Route::get('priorities/{page}/get', [PriorityController::class, 'getPriorities']);
    Route::get('priorities/active', [PriorityController::class, 'getPrioritiesActive']);
    Route::get('priorities/{id}', [PriorityController::class, 'getPriorityById']);
    Route::post('priorities/create', [PriorityController::class, 'savePriority']);
    Route::put('priorities/{id}', [PriorityController::class, 'updatePriority']);
    Route::put('priorities/{id}/changeState', [PriorityController::class, 'changeStatePriority']);
    
    //Routes api incidents
    Route::get('incidents', [IncidenceController::class, 'getIncidents']);
    Route::post('incidents/create', [IncidenceController::class, 'saveIncidence']);
    Route::put('incidents/{id}/deleteAssignedUser', [IncidenceController::class, 'deleteAssignedUserIncidence']);
    Route::put('incidents/{id}/assignUserTechnical', [IncidenceController::class, 'assignUserTechnicalIncidence']);
    Route::get('incidents/get/supportUsers', [IncidenceController::class, 'getSupportUsersWithAssignIncidentsQuantity']);
});

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);