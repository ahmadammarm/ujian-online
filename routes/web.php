<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseQuestionController;
use App\Http\Controllers\CourseStudentController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentAnswerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {

        // Route untuk role teacher mengakses halaman courses
        Route::resource('courses', CourseController::class)
            ->middleware('role:teacher');

        // Route untuk role teacher mengakses halaman question
        Route::get('/course/question/create/{course}', [CourseQuestionController::class, 'create'])
            ->middleware('role:teacher')
            ->name('course.question.create');

        // Route untuk role teacher menyimpan data question
        Route::post('/course/question/create/save/{course}', [CourseQuestionController::class, 'store'])
            ->middleware('role:teacher')
            ->name('course.question.store');

        // Route untuk role teacher mengakses halaman question
        Route::resource('courses_questions', CourseQuestionController::class)
            ->middleware('role:teacher');



        // Route untuk role teacher mengakses halaman students
        Route::get('/course/students/show/{course}', [CourseStudentController::class, 'index'])
            ->middleware('role:teacher')
            ->name('course.students.index');


        // Route untuk role teacher mengakses halaman students
        Route::get('/course/students/create/{course}', [CourseStudentController::class, 'create'])
            ->middleware('role:teacher')
            ->name('course.students.create');

        // Route untuk role teacher menyimpan data students
        Route::post('/course/students/save/{course}', [CourseStudentController::class, 'store'])
            ->middleware('role:teacher')
            ->name('course.students.store');


        // Route untuk role student mengakses halaman learning
        Route::get('/learning', [LearningController::class, 'index'])
            ->middleware('role:student')
            ->name('learning.index');

        // Route untuk role student mengakses halaman learning
        Route::get('/learning/finished/{course}', [LearningController::class, 'learning_finished'])
            ->middleware('role:student')
            ->name('learning.finished.course');


        // Route untuk role student mengakses halaman learning raport
        Route::get('/learning/rapport/{course}', [LearningController::class, 'learning_rapport'])
            ->middleware('role:student')
            ->name('learning.rapport.course');


        // Route untuk role student mengakses halaman learning course 
        Route::get('/learning/{course}/{question}', [LearningController::class, 'learning'])
            ->middleware('role:student')
            ->name('learning.course');

        // Route untuk role student menyimpan data jawaban
        Route::post('/learning/{course}/{question}', [StudentAnswerController::class, 'store'])
            ->middleware('role:student')
            ->name('learning.course.answer.store');
    });
});

require __DIR__ . '/auth.php';
