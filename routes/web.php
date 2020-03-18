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

Route::pattern('id', '^[0-9]+$');

Route::get('/','FrontController@ucitajNaslovnuStranu');
Route::get('/kategorija/{id}','FrontController@ucitajStranuZaOdredjenuKategoriju');
Route::get('/vest/{id}','FrontController@ucitajStranuZaJednuVest');
Route::get('/tag/{id}','FrontController@ucitajStranuZaJedanTag');
Route::get('/kontakt','KontaktController@ucitajKontaktStranu');
Route::get('/pretraga/{tekst}','FrontController@ucitajStranuZaPretragu');
Route::get('/login','AuthController@index');
Route::get('/komentari/{id}','KomentariController@ucitajStranu');
Route::get('/komentariZaVest/{id}','KomentariController@getKomentare');
Route::post('/login','AuthController@doLogin');
Route::post('/register','AuthController@register');
Route::post('/kontakt','KontaktController@store');

Route::middleware(['isLoggedIn'])->group(function (){

    Route::get('/logout','AuthController@logout');
    Route::get('/mojiKomentari','KomentariController@ucitajStranuZaMojeKomentare');
    Route::get('/dohvatiMojeKomentare','KomentariController@ucitajMojeKomentare');
    Route::get('/profil/{id}','AuthController@ucitajProfil');
    Route::post('/komentar','KomentariController@store');
    Route::put('/profil/{id}','AuthController@update');
    Route::delete('/obrisiKomentar/{id}','KomentariController@destroy');

});

Route::middleware(['isLoggedIn', 'admin'])->prefix('/admin')->group(function () {

    Route::resource('/vesti','Admin\VestiController');
    Route::resource('/korisnici','Admin\KorisniciController');
    Route::resource('/tagovi','Admin\TagoviController');
    Route::resource('/kategorije','Admin\KategorijeController');

    Route::get('/komentari/{id}','Admin\AdminFrontController@ucitajKomentareZaJednuVestZaAdmin');
    Route::get('/aktivnosti','Admin\AktivnostiController@index');
    Route::get('/aktivnosti/json/{datum?}','Admin\AktivnostiController@getAktivnosti');

});
