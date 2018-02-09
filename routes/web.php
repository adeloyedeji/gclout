<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/get_countries/{type}', [
    'uses'  =>  'UtilityController@get_countries',
    'as'    =>  'all.countries'
]);

Route::get('/get_states/{type}', [
    'uses'  =>  'UtilityController@get_states',
    'as'    =>  'all.states'
]);

Route::group(['middleware' => 'auth'], function() {
    Route::get('/profile/{username}', [
        'uses'  =>  'ProfilesController@index',
        'as'    =>  'profile'
    ]);
    Route::get('/profile/about/{username}', [
        'uses'  =>  'ProfilesController@about',
        'as'    =>  'profile.about'
    ]);
    Route::get('/profile/edit/profile', [
        'uses'  =>  'ProfilesController@edit',
        'as'    =>  'profile.edit',
    ]);
    Route::post('/profile/update/profile', [
        'uses'  =>  'ProfilesController@update',
        'as'    =>  'profile.update',
    ]);
    Route::post('/profile/update/intro', [
        'uses'  =>  'ProfilesController@intro',
        'as'    =>  'profile.intro'
    ]);
    Route::post('/profile/save/bio', [
        'uses'  =>  'ProfilesController@save_bio',
        'as'    =>  'profile.save.bio'
    ]);
    Route::post('/profile/save/contact', [
        'uses'  =>  'ProfilesController@save_phone',
        'as'    =>  'profile.save.contact'
    ]);
    Route::post('/profile/save/address', [
        'uses'  =>  'ProfilesController@save_address',
        'as'    =>  'profile.save.address'
    ]);
    Route::post('/profile/save/others', [
        'uses'  =>  'ProfilesController@save_others',
        'as'    =>  'profile.save.others'
    ]);
    Route::post('/profile/save/about', [
        'uses'  =>  'ProfilesController@save_about',
        'as'    =>  'profile.save.about'
    ]);
    Route::post('/profile/save/avatar', [
        'uses'  =>  'ProfilesController@save_avatar',
        'as'    =>  'profile.save.avatar'
    ]);
    Route::post('/profile/save/cover', [
        'uses'  =>  'ProfilesController@save_cover_photo',
        'as'    =>  'profile.save.cover'
    ]);
    Route::get('/check_relationship_status/{id}', [
        'uses'  =>  'FriendshipController@check',
        'as'    =>  'check',
    ]);
    Route::get('/add_friend/{id}', [
        'uses'  =>  'FriendshipController@add_friend',
        'as'    =>  'friend.add',
    ]);
    Route::get('/accept_friend/{id}', [
        'uses'  =>  'FriendshipController@accept_friend',
        'as'    =>  'friend.accept',
    ]);
    Route::get('/cancel_request/{id}', [
        'uses'  =>  'FriendshipController@cancel_request',
        'as'    =>  'friend.cancel',
    ]);
    Route::get('/get_friend_suggestions', [
        'uses'  =>  'FriendshipController@get_friend_suggestions',
        'as'    =>  'friends.suggestions'
    ]);
    Route::get('/get_unread', function() {
        return \Auth::user()->unreadNotifications;
    });
    Route::get('/notifications', [
        'uses'  =>  'HomeController@notifications',
        'as'    =>  'notifications',
    ]);
    Route::get('/general/get-categories', [
        'uses'  =>  'GeneralController@post_categories',
        'as'    =>  'post.categories'
    ]);
    Route::post('/general/store', [
        'uses'  =>  'GeneralController@store',
        'as'    =>  'general.store'
    ]);
    Route::post('/post/store', [
        'uses'  =>  'PostController@store',
        'as'    =>  'post.store',
    ]);
    Route::get('/feed/{id}', [
        'uses'  =>  'FeedController@feed',
        'as'    =>  'feed',
    ]);
    Route::get('/get_auth_user_data', function () {
        return \Auth::user();
    });
    Route::get('/get_auth_user_data/{id}', [
        'uses'  =>  'CloutController@user_data',
        'as'    =>  'user.data'
    ]);
    Route::get('/like/{id}', [
        'uses'  =>  'LikeController@like',
    ]);
    Route::get('/unlike/{id}', [
        'uses'  =>  'LikeController@unlike',
    ]);
    Route::get('/get_username/{username}', [
        'uses'  =>  'UtilityController@username_check',
        'as'    =>  'username.check'
    ]);
    Route::get('/get_lgas/bystate/{type}', [
        'uses'  =>  'UtilityController@get_lga_by_state',
        'as'    =>  'lga.state'
    ]);
    Route::get('/get_leader_profile/{role}/{state}', function() {
        return "Hello there";
    });
    Route::get('/clouts/total', [
        'uses'  =>  'CloutController@total_clout',
        'as'    =>  'clouts.total'
    ]);
    Route::get('/clout/photo-total', [
        'uses'  =>  'CloutController@total_clout_photo',
        'as'    =>  'clout.photos.total'
    ]);
    Route::get('/clouts/list/{profile}', [
        'uses'  =>  'CloutController@clout_list',
        'as'    =>  'clout.list'
    ]);
    Route::get('/get_clouts/{user_id}', [
        'uses'  =>  'CloutController@get_clouts',
        'as'    =>  'clout.get'
    ]);
    Route::get('/get_pending_clouts/{user_id}', [
        'uses'  =>  'CloutController@get_pending_clouts',
        'as'    =>  'clout.get'
    ]);
    Route::get('/get_pending_clouts_sent/{user_id}', [
        'uses'  =>  'CloutController@get_pending_clouts_sent',
        'as'    =>  'clout.get'
    ]);
    Route::get('/photos/{user}', [
        'uses'  =>  'PhotosController@index',
        'as'    =>  'photos.index'
    ]);

    Route::get('/photos/get_photo/{id}', [
        'uses'  =>  'PhotosController@get_photo',
        'as'    =>  'photos.get'
    ]);

    Route::get('/messaging/{username}', [
        'uses'  =>  'MessageController@show',
        'as'    =>  'messaging.show'
    ]);
    
    Route::get('movements/sign/{id}','MovementController@signature');

    Route::get('/press/{username}', [
        'uses'  =>  'PressController@index',
        'as'    =>  'press.index'
    ]);

    Route::get('/press/feed/{id}', [
        'uses'  =>  'PressController@press_feed',
        'as'    =>  'press.feed'
    ]);

    Route::post('/press/store', [
        'uses'  =>  'PressController@store',
        'as'    =>  'press.store'
    ]);

    Route::get('/press/like/{id}', [
        'uses'  =>  'PressController@like',
        'as'    =>  'press.like'
    ]);

    Route::get('/press/unlike/{id}', [
        'uses'  =>  'PressController@unlike',
        'as'    =>  'press.unlike'
    ]);

    Route::get('/speeches/{username}', [
        'uses'  =>  'SpeechController@index',
        'as'    =>  'speech.index'
    ]);

    Route::get('/speeches/feed/{id}', [
        'uses'  =>  'SpeechController@speech_feed',
        'as'    =>  'speech.feed'
    ]);

    Route::post('/speeches/store', [
        'uses'  =>  'SpeechController@store',
        'as'    =>  'speech.store'
    ]);

    Route::get('/speeches/like/{id}', [
        'uses'  =>  'SpeechController@like',
        'as'    =>  'speech.like'
    ]);

    Route::get('/speeches/unlike/{id}', [
        'uses'  =>  'SpeechController@unlike',
        'as'    =>  'speech.unlike'
    ]);
    
    //Route::get('polls/sign/{id}','PollController@signatures');

    Route::resource('post-comment', 'PostCommentController');
    Route::resource('intro', 'IntroController');
    Route::resource('movements', 'MovementController');
    Route::resource('polls','PollController');

    Route::resource('district','DistrictController');
    // Route::resource('press','PressReleaseController');
    // Route::resource('speeches','SpeechesController');
    Route::resource('interviews','InterviewController');
    Route::resource('budget','BudgetController');
    Route::resource('mda','MdaController');
});