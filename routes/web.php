<?php

use App\Jobs\AnotherQueueJob;
use App\Jobs\FailingJob;
use App\Jobs\LongJob;
use App\Jobs\OptimizeVideoJob;
use App\Jobs\ProcessVideoJob;
use App\Jobs\RiskyJob;
use App\Jobs\SleepJob;
use App\Jobs\DeleteWhenMissingModelsDemoJob;
use App\Jobs\ReleaseVideoJob;
use App\Jobs\TimeoutDemoJob;
use App\Jobs\AttemptDemoJob;
use App\Models\Video;
use App\Notifications\VideoHasBeenProcessedNotification;
use App\User;
use Illuminate\Http\Request;











/*
 * Let's start with the basics
 */
Route::get('101', function () {

    dispatch(new SleepJob(3));

    Log::info('request done');

    return 'Your first job has been dispatched';
});











/*
 * Queued jobs are testable
 */












/*
 * Something not worth creating a job?
 */
Route::get('closure', function () {

    dispatch(function () {
        Log::info('Start sleeping in closure...');

        sleep(3);

        Log::info('That was enough sleep for now!');
    });

    return 'ok';
});








/*
 * We can handle failures
 */
Route::get('failing-job', function () {

    dispatch(new FailingJob());

    // a queue:work --tries=3
});











/*
 * Let's try that again!
 */
Route::get('attempts', function () {
    dispatch(new AttemptDemoJob());
});














/*
 * When models go missing
 */
Route::get('delete-missing-models', function () {

    $video = Video::create();

    dispatch(new DeleteWhenMissingModelsDemoJob($video));

    $video->delete();
});














/*
 * Wait a minute mister postman!
 */
Route::get('delayed-dispatch', function () {
    Log::info('Dispatching job...');

    dispatch(new SleepJob())->delay(now()->addSeconds(10));
});
















/*
 * Don't work for too long
 */
Route::get('timeout', function () {
    dispatch(new TimeoutDemoJob(5));

    dispatch(new TimeoutDemoJob(10));
});


















/*
 * Chain 'm together
 */
Route::get('one-after-the-other', function () {
    SleepJob::withChain([
        new OptimizeVideoJob(),
        new ReleaseVideoJob(),
    ])->dispatch();
});













/*
 * 🔥🔥🔥 Let's see what's on the horizon, back to the slides 🔥🔥🔥
 */












/*
 * let's try to install it into a fresh project
 */

















/*
 * Let's explore horizon
 */


















/*
 * Let's start some some jobs
 */
Route::get('dispatch/{numberOfJobs}', function (Request $request) {
    foreach (range(1, $request->numberOfJobs) as $i) {
        dispatch(new SleepJob());
    }

    return "Dispatched {$request->numberOfJobs} jobs...";
});











/*
 * Let's tag some jobs
 */
Route::get('dispatch-video/{numberOfJobs}', function (Request $request) {

    foreach (range(1, $request->numberOfJobs) as $i) {
        $video = Video::inRandomOrder()->first();

        dispatch(new ProcessVideoJob($video));
    }
});














/*
 * Other classes (like events and notification get tagged too
 */
Route::get('notification/{numberOfJobs}', function (Request $request) {
    foreach (range(1, $request->numberOfJobs) as $i) {
        $user = User::inRandomOrder()->first();

        $video = Video::inRandomOrder()->first();

        $user->notify(new VideoHasBeenProcessedNotification($video));
    }
});








/*
 * What happens when jobs fail?
 */
Route::get('risky-job/{numberOfJobs}', function (Request $request) {
    foreach (range(1, $request->numberOfJobs) as $i) {
        $video = Video::inRandomOrder()->first();

        dispatch(new RiskyJob($video));
    }
});















/*
 * Let's balance! What is the difference between `simple` and `auto`?
 */
Route::get('balance-jobs/{numberOfJobs}', function (Request $request) {
    foreach (range(1, $request->numberOfJobs) as $i) {
        dispatch(new SleepJob());
    }
});

Route::get('balance-jobs-2/{numberOfJobs}', function (Request $request) {
    foreach (range(1, $request->numberOfJobs) as $i) {
        dispatch(new AnotherQueueJob());
    }
});











/*
 * What happens when a job takes a while to finish?
 */
Route::get('long-jobs/{numberOfJobs}', function (Request $request) {
    foreach (range(1, $request->numberOfJobs) as $i) {
        dispatch(new LongJob());
    }
});











/*
 * Who's allowed to take a look at horizon?
 */















/*
 * Let's take a look at a real life use case: Oh Dear!
 */





















/*
 * Let's wrap it up, back to the slides!
 */















Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
