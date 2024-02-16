<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketsStatusController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\LogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Redirect Homepage to login
Route::redirect('/', '/login', 301);

// Route::get('/', function () {
//     return view('welcome');
// });

//Route for authentication Handling
Auth::routes();

//Route to User's Dashboard
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//Route to display Frequently asked Questions
Route::get('/faq', [FaqsController::class,'index']);

//Route to display Page to Create Ticket
Route::get('/tickets', [TicketController::class,'create']);
//Route to Handle ticket Storage
Route::post('/tickets', [TicketController::class,'store']);
//Route to display authenticated User's Tickets
Route::get('/mytickets', [TicketController::class,'userTickets']);
//Route to display more information on a single ticket
Route::get('/tickets/{ticket_id}', [TicketController::class,'show']);

//Route to Handle new comments storage
Route::post('/comment', [CommentController::class,'store']);

//Route to Show View for User to Update Settings
Route::get('/settings', [UserSettingsController::class,'create']);
//Route to Handle User Settings Update
Route::post('/settings', [UserSettingsController::class,'updateTelephone']);


//Admin routes( they should all be prefix with /admin in the Url)
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    //Route to display all tickets
    Route::get('tickets', [TicketController::class,'index']);
    //Routes to close a ticket
    Route::post('close_ticket/{ticket_id}', [TicketsStatusController::class,'close']);
    //Change Ticket Visibility to Public
    Route::post('public_ticket/{ticket_id}', [TicketController::class,'ticketVisibilityPublic']);
    //Change Ticket Visibility to Private
    Route::post('private_ticket/{ticket_id}', [TicketController::class,'ticketVisibilityPrivate']);

    //Route to display Page to Create Ticket
    Route::get('/category', [CategoryController::class,'create']);
    //Route to Handle ticket Storage
    Route::post('/category', [CategoryController::class,'store']);
    //Route to Delete Category
    Route::post('category/delete/{id}', [CategoryController::class,'delete']);

    //Route To Display New Admin Page
    Route::get('/users', [AdminController::class,'create']);
    //Route to store New Admin User
    Route::post('/users', [AdminController::class,'store']);
    //Rotue to delete new Admin User
    Route::post('/users/{id}', [AdminController::class,'delete']);
    
    //Route to view Audit Logs
    Route::get('logs', [LogController::class,'index']);
});
