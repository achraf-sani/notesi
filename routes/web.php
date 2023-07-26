<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth::routes([get rid of default auth routes as we mustn't change in vendor
//     'register' => false, //Registration Route
//     'reset' => false, //Reset Password Route
//     'verify' => false, //Email Verification Route
// ]);



Route::get('/errorPage', [App\Http\Controllers\Auth\ErrorController::class, 'error'])->name('errorPage');

Route::get('/login', [App\Http\Controllers\Auth\AuthController::class, 'signin'])->name('login');//override auth
Route::get('/', [App\Http\Controllers\Auth\AuthController::class, 'welcome'])->name("welcome");
Route::get('/landing', [App\Http\Controllers\Auth\AuthController::class, 'landing'])->name("landing");
Route::post('/logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout');

Route::get('/callback', [App\Http\Controllers\Auth\AuthController::class, 'callback']);
Route::get('/home/{currentSemester}', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/currentSemester/{id}', [App\Http\Controllers\SemesterController::class, 'assignCurrentSemester'])->name('currentSemester');
Route::get('/currentSemester', [App\Http\Controllers\SemesterController::class, 'getCurrentSemester'])->name('getCurrentSemester');

Route::get("/dashboard", [App\Http\Controllers\Moderation\DashboardController::class, 'dashboard'])->name('dashboard');

Route::get("/majorsCpanel", [App\Http\Controllers\Moderation\MajorsController::class, 'getMajorsCpanel'])->name('majors');
Route::post("/addMajors", [App\Http\Controllers\Moderation\MajorsController::class, 'addMajors'])->name('addMajors');

Route::get("/modulesCpanel", [App\Http\Controllers\Moderation\ModulesController::class, 'getModulesCpanel'])->name('modules');
Route::post("/addModules", [App\Http\Controllers\Moderation\ModulesController::class, 'addModules'])->name('addModules');

Route::get("/coursesCpanel", [App\Http\Controllers\Moderation\CoursesController::class, 'getCoursesCpanel'])->name('courses');
Route::post("/addCourses", [App\Http\Controllers\Moderation\CoursesController::class, 'addCourses'])->name('addCourses');

Route::get("/studentsCpanel", [App\Http\Controllers\Moderation\StudentsController::class, 'getStudentsCpanel'])->name('students');
Route::post("/addStudents", [App\Http\Controllers\Moderation\StudentsController::class, 'addStudents'])->name('addStudents');

Route::get("/marksCpanel", [App\Http\Controllers\Moderation\MarksController::class, 'getMarksCpanel'])->name('marks');
Route::post("/addMarks", [App\Http\Controllers\Moderation\MarksController::class, 'addMarks'])->name('addMarks');

Route::get("/moderatorsCpanel", [App\Http\Controllers\Moderation\ModeratorsController::class, 'getModeratorsCpanel'])->name('moderators');
Route::get("/addModerators/{id}", [App\Http\Controllers\Moderation\ModeratorsController::class, 'addModerators'])->name('addModerators');
Route::get("/removeModerators/{id}", [App\Http\Controllers\Moderation\ModeratorsController::class, 'removeModerator'])->name('removeModerator');

Route::get("/superadminsCpanel", [App\Http\Controllers\Moderation\SuperAdminsController::class, 'getSuperadminsCpanel'])->name('superadmins');
Route::get("/addSuperadmins/{id}", [App\Http\Controllers\Moderation\SuperAdminsController::class, 'addSuperadmins'])->name('addSuperadmins');

Route::get('/our_backup_database', [App\Http\Controllers\Moderation\DatabaseController::class, 'our_backup_database'])->name('our_backup_database');

Route::get("/usersCpanel", [App\Http\Controllers\Moderation\UsersController::class, 'getUsersCpanel'])->name('users');
