<?php

use App\Http\Controllers\BookController;
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

Route::view('BookDetail', 'pages.book_details')->name('BookDetail');
Route::view('contact', 'pages.contact')->name('contact');

// Website Pages
Route::get('/', [BookController::class, 'home'])->name('home');
Route::get('all', [BookController::class, 'AllBooksHome'])->name('all');
Route::get('Arabic', [BookController::class, 'ArabicBooks'])->name('All_Arabic_Books');
Route::get('English', [BookController::class, 'EnglishBooks'])->name('All_English_Books');
Route::get('Luganda', [BookController::class, 'LugandaBooks'])->name('All_Luganda_Books');
Route::get('final-page/{id}', [BookController::class, 'lastPage'])->name('final-page');
Route::get('about-us', [BookController::class, 'about_us'])->name('about-us');
Route::get('search/final-page/{id}', [BookController::class, 'search_lastpage'])->name('final-page');

Route::post('store-book', [BookController::class, 'store'])->name('store-book');
Route::post('store-update', [BookController::class, 'update'])->name('store-update');

// Download and view pdf and Doc file.

Route::get('/download/{file}', [BookController::class, 'download']);
Route::get('/view/{id}', [BookController::class, 'view']);

// Admin pages , Login and Dashboard.
Route::middleware(['middleware' => 'AuthCheck'])->group(function () {
    Route::get('Adminpages.Dashboard', [BookController::class, 'dashboard']);
    Route::get('auth.logout', [BookController::class, 'logout'])->name('auth.logout');
    Route::view('AddBook', 'Adminpages.AddBook')->name('AddBook');
    Route::view('AddAdhkar', 'Adminpages.AddAdhkar')->name('AddAdhkar');
    Route::view('EditBook', 'Adminpages.EditBook')->name('EditBook');
    Route::view('dashboard', 'Adminpages.Dashboard')->name('dashboard');
    Route::get('dashboard', [BookController::class, 'dashboard'])->name('dashboard');
    Route::view('BookDetails', 'Adminpages.BookDetails')->name('BookDetails');
    Route::get('delete/{id}', [BookController::class, 'delete']);
    Route::get('Edit/{id}', [BookController::class, 'updateRecord']);
    Route::get('AllBooks', [BookController::class, 'show'])->name('AllBooks');
    Route::get('contact-info', [BookController::class, 'contact_info'])->name('contact-info');
    Route::get('Edit-Adhkar/{id}', [BookController::class, 'EditAdhkar'])->name('Edit-Adhkar');
    Route::get('delete-Adhkar/{id}', [BookController::class, 'deleteAdhkar']);
    Route::get('Upload-Audio', [BookController::class, 'AudioUpload'])->name('Upload-Audio');
    Route::get('All-Audio', [BookController::class, 'AllAudios'])->name('All-Audio');
    Route::get('Edit-Audio/{id}', [BookController::class, 'EditAudio'])->name('Edit-Audio');
    Route::get('delete-Audio/{id}', [BookController::class, 'deleteAudio']);
    Route::get('AllAdhkar', [BookController::class, 'ShowAllAdhkar'])->name('AllAdhkar');
    Route::get('Add-Quran', [BookController::class, 'AddQuran'])->name('Add-Quran');
    Route::get('All-Admin-videos', [BookController::class, 'AdminVideos'])->name('All-Admin-videos');
    Route::get('Edit-Video/{id}', [BookController::class, 'EditVideo'])->name('Edit-Video');
    Route::get('delete-Video/{id}', [BookController::class, 'deleteVideo']);
    Route::get('Add-video', [BookController::class, 'AddVideo'])->name('Add-video');
    Route::get('All-Sheikhs', [BookController::class, 'AllSheikhs'])->name('All-Sheikhs');
    Route::get('Add-Sheikh', [BookController::class, 'AddSheikh'])->name('Add-Sheikh');
    Route::get('Edit-sheikh/{id}', [BookController::class, 'EditSheikhInfo']);
    Route::get('delete-sheikh/{id}', [BookController::class, 'DeleteSheikh']);
    Route::get('auth.register', [BookController::class, 'register'])->name('auth.register');
    Route::get('Edit-Quran/{id}', [BookController::class, 'EditQuran'])->name('Edit-Quran');
    Route::get('delete-Quran/{id}', [BookController::class, 'deleteQuran']);

    // System Upgrade ---> Series, UserInformation
    Route::get('editUser/{id}', [BookController::class, 'editUser']);
    Route::get('deleterUser/{id}', [BookController::class, 'deleteUser']);
    Route::get('activateUser/{id}', [BookController::class, 'activateUser']);
    Route::get('user-information', [BookController::class, 'userInformation'])->name('user-information');

    Route::get('Add-Serie',[BookController::class,'AddSerie'])->name('Add-Serie');
    Route::get('All-Series',[BookController::class,'AllSeries'])->name('All-Series');

    Route::get('edit-serie/{id}', [BookController::class, 'editSerie']);
    Route::get('delete-serie/{id}', [BookController::class, 'deleteSerie']);

});

// System Upgrade ---> Series, UserInformation

Route::post('update-user-data', [BookController::class, 'updateUserData'])->name('update-user-data');
Route::post('update-serie-data',[BookController::class,'updateSerieDate'])->name('update-serie-data');

Route::post('store-serie-created',[BookController::class,'storeSerieCreated'])->name('store-serie-created');


Route::get('auth.login', [BookController::class, 'login'])->name('auth.login');
Route::get('search-bar', [BookController::class, 'SearchBar'])->name('search-bar');
Route::get('fetchRecords/{keyword}', [BookController::class, 'fetchRecords'])->name('fetchRecords-link');
Route::get('search/{keyword}', [BookController::class, 'searchInfo'])->name('search-link');
Route::get('search-ulaamah/{keyword}', [BookController::class, 'search_Scholar'])->name('search-link');
Route::get('adhkar-details/{id}', [BookController::class, 'adhkarDetails'])->name('adhkar-details');

Route::post('fill-first-name', [BookController::class, 'fillFirstName'])->name('fill-first-name');
Route::post('auth.save', [BookController::class, 'store1'])->name('auth.save');
Route::post('auth.check', [BookController::class, 'verify'])->name('auth.check');
Route::post('send-message', [BookController::class, 'SendMessage'])->name('send-message');

//Dua and Adhkar routes

Route::get('morning-adhkar', [BookController::class, 'morning_adhkar'])->name('morning-adhkar');
Route::get('evening-adhkar', [BookController::class, 'evening_adhkar'])->name('evening-adhkar');
Route::get('Adhkar-After-Swalah', [BookController::class, 'Adhkar_After_Swalah'])->name('Adhkar-After-Swalah');
Route::get('Famous-Duas-from-the-Quran', [BookController::class, 'Famous_Duas_from_the_Quran'])->name('Famous-Duas-from-the-Quran');
Route::get('Other-Duas', [BookController::class, 'Other_Duas'])->name('Other-Duas');

Route::post('add-post', [BookController::class, 'add_post'])->name('add-post');
Route::post('update-post', [BookController::class, 'updateAdhkar'])->name('update-post');

//AUDIO Page  routes

Route::get('Ugandan-Sheikhs', [BookController::class, 'AudioPage'])->name('Ugandan-Sheikhs');
Route::get('Indvidual-Sheikh', [BookController::class, 'IndividualSheikh'])->name('Indvidual-Sheikh');
Route::get('sheikh/{name}', [BookController::class, 'SheikhLectures']);
Route::get('/download-Audio/{file}', [BookController::class, 'downloadAudio']);

Route::get('SheikhLecturesSeries/{sheikhId}/{SerieId}',[BookController::class,'SheikhLecturesSeries']);

Route::post('Audio-Upload', [BookController::class, 'UploadAudio'])->name('Audio-Upload');
Route::post('update-Audio', [BookController::class, 'UpdateAudio'])->name('update-Audio');

//Video Routes

Route::get('All-videos', [BookController::class, 'AllVideos'])->name('All-videos');
Route::get('Video-Details', [BookController::class, 'VideoDetails'])->name('Video-Details');
Route::get('search/subject/{keyword}', [BookController::class, 'SearchSubject']);
Route::get('search/sheikh/{keyword}', [BookController::class, 'SearchSheikh']);
Route::get('watch-video/{keyword}', [BookController::class, 'WatchVideo']);
Route::get('search-bar-video', [BookController::class, 'SearchBarVideo'])->name('search-bar-video');
Route::get('fetchRecordsVideo/{keyword}', [BookController::class, 'fetchRecordsVideo'])->name('fetchRecordsVideo-link');

Route::post('upload-video', [BookController::class, 'uploadVideo'])->name('upload-video');
Route::post('update-video', [BookController::class, 'UpdateVideo'])->name('update-video');

// Islamic Calendar
Route::get('showDate', [BookController::class, 'carbonDate']);

//Quran Routes

Route::get('Quran-Audio', [BookController::class, 'QuranAudio'])->name('Quran-Audio');
Route::get('surah/{name}', [BookController::class, 'SpecificReciter'])->name('surah');
Route::get('/download-Quran/{file}', [BookController::class, 'downloadQuran']);
Route::get('All-Quran', [BookController::class, 'AllQuran'])->name('All-Quran');

Route::post('upload-Quran', [BookController::class, 'UploadQuranAudio'])->name('upload-Quran');
Route::post('update-Quran', [BookController::class, 'UpdateQuranAudio'])->name('update-Quran');
Route::post('store-sheikh', [BookController::class, 'StoreSheikh'])->name('store-sheikh');
Route::post('update-sheikh-info', [BookController::class, 'UpdateSheikhInfo'])->name('update-sheikh-info');
