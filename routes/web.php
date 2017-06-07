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
    return redirect('/login');
});

Route::group([ 'middleware' => 'auth'], function()
{
    Route::get('profile', 'ProfileController@getProfile');
    Route::post('profile', 'ProfileController@postProfile');
    Route::get('exercises', 'ExercisesController@getExercises');
    Route::post('exercises', 'ExercisesController@postExercises');
    Route::get('exercise', 'ExerciseController@getExercise');
    Route::post('exercise', 'ExerciseController@postExercise');
    Route::get('addExercise', 'ExerciseController@getAddExercise');
    Route::post('addExercise', 'ExerciseController@postAddExercise');
    Route::get('tasks', 'TasksController@getTasks');
    Route::post('tasks', 'TasksController@postTasks');
    Route::get('task', 'TaskController@getTask');
    Route::post('task', 'TaskController@postTask');
    Route::get('addTask', 'TaskController@getAddTask');
    Route::post('addTask', 'TaskController@postAddTask');
    Route::get('performances', 'PerformancesController@getPerformances');
    Route::post('performances', 'PerformancesController@postPerformances');
    Route::get('students', 'StudentsController@getStudents');
    Route::post('students', 'StudentsController@postStudents');
    Route::get('student', 'StudentController@getStudent');
    Route::post('student', 'StudentController@postStudent');
    Route::get('teachers', 'TeachersController@getTeachers');
    Route::post('teachers', 'TeachersController@postTeachers');
    Route::get('teacher', 'TeacherController@getTeacher');
    Route::post('teacher', 'TeacherController@postTeacher');
    Route::get('addStudent', 'AddStudentController@getAddStudent');
    Route::post('addStudent', 'AddStudentController@postAddStudent');

    Route::get('sightReading', 'SightReadingController@getSightReading');
    Route::post('sightReading', 'SightReadingController@postSightReading');

    Route::get('getMusicXML', 'GetMusicXMLController@getMusicXML');
});

Auth::routes(

);

Route::get('/home', 'HomeController@index');
