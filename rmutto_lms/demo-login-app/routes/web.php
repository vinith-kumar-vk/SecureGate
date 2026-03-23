<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\LocaleController;

Route::get('/', function () {
    return view('auth.home');
})->name('home');

// Locale switching route
Route::post('/set-language/{locale}', [LocaleController::class, 'setLocale'])->name('locale.set');

Route::get('/home', function () {
    return redirect('/');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/account', function () {
    return view('auth.account');
})->name('account');

Route::get('/account-new', [AccountController::class, 'index'])->name('account.new');
Route::post('/account-update', [AccountController::class, 'update'])->name('account.update');
Route::post('/account-password', [AccountController::class, 'changePassword'])->name('account.password');

use App\Http\Controllers\DashboardController;

Route::get('/dashboard-1', [DashboardController::class, 'index'])->name('dashboard.1');

Route::get('/dashboard-2', function () {
    return view('auth.dashboard-2');
})->name('dashboard.2');

Route::get('/calendar', function () {
    return view('auth.calendar');
})->name('calendar');

Route::get('/learning', function () {
    return view('auth.learning');
})->name('learning');

Route::get('/learning-p2', function () {
    return view('auth.learning-p2');
})->name('learning.p2');

Route::get('/payment-method', function () {
    return view('auth.payment-method');
})->name('payment.method');

Route::get('/shopping-cart', function () {
    return view('auth.shopping-cart');
})->name('shopping.cart');

Route::get('/transaction', function () {
    return view('auth.transaction');
})->name('transaction');

Route::get('/refund', function () {
    return view('auth.refund');
})->name('refund');

Route::get('/courses', function () {
    return view('auth.courses');
})->name('courses');

Route::get('/quiz', function () {
    return view('auth.quiz');
})->name('quiz');

Route::get('/wallet-address', function () {
    return view('auth.wallet-address');
})->name('wallet.address');

Route::get('/search', function () {
    return view('auth.search');
})->name('search');

Route::get('/free-courses', function () {
    return view('auth.free-courses');
})->name('free.courses');

Route::get('/course-detail', function () {
    return view('auth.course-detail');
})->name('course.detail');

Route::get('/change-password', function () {
    return view('auth.change-password');
})->name('password.change');

Route::get('/reset-password', function () {
    return view('auth.reset-password');
})->name('password.reset');

Route::get('/verify', function () {
    return view('auth.verify');
})->name('verification.notice');

// POST Routes for UI Flow Demo
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'username' => ['required', 'string'],
        'password' => ['required', 'string'],
    ]);

    $loginField = filter_var($credentials['username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

    if (Auth::attempt([$loginField => $credentials['username'], 'password' => $credentials['password']])) {
        $request->session()->regenerate();

        return redirect()->route('dashboard.1');
    }

    return back()->withErrors([
        'username' => 'The provided credentials do not match our records.',
    ])->onlyInput('username');
})->name('login.post');

Route::post('/forgot-password', function () {
    return redirect()->route('verification.notice'); // Flow: Forgot -> Verify
})->name('password.email');

Route::post('/verify', function () {
    return redirect()->route('password.reset'); // Flow: Verify -> Reset Password
})->name('verification.verify');

Route::post('/reset-password', function () {
    return redirect()->route('login'); // Flow: Reset -> Login
})->name('password.update');

Route::post('/register', function (Request $request) {
    $validated = $request->validate([
        'role' => ['required', 'in:learner,guide'],
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        'dob' => ['required', 'date'],
        'address' => ['required', 'string', 'max:255'],
        'phone' => ['required', 'string', 'max:30'],
        'id_number' => ['required', 'string', 'max:255'],
        'country' => ['required', 'string', 'max:100'],
        'password' => ['required', 'confirmed', 'min:8'],
        'education_level' => ['nullable', 'string', 'max:50'],
        'educational_institution' => ['nullable', 'string', 'max:255'],
        'subject_faculty' => ['nullable', 'string', 'max:255'],
        'interest_category' => ['nullable', 'string', 'max:50'],
        'learning_objectives' => ['nullable', 'string'],
        'knowledge_level' => ['nullable', 'string', 'max:50'],
        'payment_info' => ['nullable', 'string'],
        'receipt_info' => ['nullable', 'string'],
        'current_position' => ['nullable', 'string', 'max:255'],
        'organization' => ['nullable', 'string', 'max:255'],
        'teaching_experience' => ['nullable', 'integer', 'min:0'],
        'bio' => ['nullable', 'string'],
        'teaching_subjects' => ['nullable', 'string', 'max:100'],
        'teaching_language' => ['nullable', 'string', 'max:50'],
        'certificates' => ['nullable', 'string', 'max:255'],
        'portfolio' => ['nullable', 'string'],
        'id_copy' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
        'profile_photo' => ['nullable', 'image', 'max:4096'],
        'qualification_cert' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
        'bank_account' => ['nullable', 'string'],
        'tax_id' => ['nullable', 'string', 'max:255'],
        'taxpayer_type' => ['nullable', 'string', 'max:30'],
        'approve_policy' => ['accepted'],
    ]);

    if ($validated['role'] === 'learner') {
        $request->validate([
            'education_level' => ['required', 'string', 'max:50'],
            'interest_category' => ['required', 'string', 'max:50'],
            'learning_objectives' => ['required', 'string'],
        ]);
    }

    if ($validated['role'] === 'guide') {
        $request->validate([
            'current_position' => ['required', 'string', 'max:255'],
            'teaching_experience' => ['required', 'integer', 'min:0'],
            'bio' => ['required', 'string'],
            'teaching_subjects' => ['required', 'string', 'max:100'],
            'teaching_language' => ['required', 'string', 'max:50'],
            'certificates' => ['required', 'string', 'max:255'],
            'id_copy' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
            'profile_photo' => ['required', 'image', 'max:4096'],
            'qualification_cert' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
            'bank_account' => ['required', 'string'],
            'tax_id' => ['required', 'string', 'max:255'],
            'taxpayer_type' => ['required', 'string', 'max:30'],
        ]);
    }

    $idCopyPath = $request->hasFile('id_copy')
        ? $request->file('id_copy')->store('guide-documents/id-copies', 'public')
        : null;

    $profilePhotoPath = $request->hasFile('profile_photo')
        ? $request->file('profile_photo')->store('guide-documents/profile-photos', 'public')
        : null;

    $qualificationCertPath = $request->hasFile('qualification_cert')
        ? $request->file('qualification_cert')->store('guide-documents/qualification-certs', 'public')
        : null;

    User::create([
        'name' => trim($validated['first_name'].' '.$validated['last_name']),
        'email' => $validated['email'],
        'password' => $validated['password'],
        'role' => $validated['role'],
        'first_name' => $validated['first_name'],
        'last_name' => $validated['last_name'],
        'dob' => $validated['dob'],
        'address' => $validated['address'],
        'phone' => $validated['phone'],
        'id_number' => $validated['id_number'],
        'country' => $validated['country'],
        'education_level' => $validated['education_level'] ?? null,
        'educational_institution' => $validated['educational_institution'] ?? null,
        'subject_faculty' => $validated['subject_faculty'] ?? null,
        'interest_category' => $validated['interest_category'] ?? null,
        'learning_objectives' => $validated['learning_objectives'] ?? null,
        'knowledge_level' => $validated['knowledge_level'] ?? null,
        'payment_info' => $validated['payment_info'] ?? null,
        'receipt_info' => $validated['receipt_info'] ?? null,
        'receive_notifications' => $request->boolean('receive_notifications'),
        'email_sms_notification' => $request->boolean('email_sms_notification'),
        'current_position' => $validated['current_position'] ?? null,
        'organization' => $validated['organization'] ?? null,
        'teaching_experience' => $validated['teaching_experience'] ?? null,
        'bio' => $validated['bio'] ?? null,
        'teaching_subjects' => $validated['teaching_subjects'] ?? null,
        'teaching_language' => $validated['teaching_language'] ?? null,
        'certificates' => $validated['certificates'] ?? null,
        'portfolio' => $validated['portfolio'] ?? null,
        'id_copy_path' => $idCopyPath,
        'profile_photo_path' => $profilePhotoPath,
        'qualification_cert_path' => $qualificationCertPath,
        'bank_account' => $validated['bank_account'] ?? null,
        'tax_id' => $validated['tax_id'] ?? null,
        'taxpayer_type' => $validated['taxpayer_type'] ?? null,
        'approve_policy' => true,
    ]);

    return redirect()->route('login')->with('status', 'Account created successfully. Please sign in.');
})->name('register.post');

Route::get('/all-courses', function () {
    // Temporary demo data for the category grid
    $courses = [
        ['img' => 'learning.png', 'title' => 'Veterinary Nursing Assistant Course'],
        ['img' => 'learning.png', 'title' => 'Digital Marketing Essentials'],
        ['img' => 'learning.png', 'title' => 'Beginner Mathematics Refresher'],
        ['img' => 'learning.png', 'title' => 'Introduction to Programming'],
        ['img' => 'learning.png', 'title' => 'Business Communication Skills'],
        ['img' => 'learning.png', 'title' => 'Creative Design Basics'],
        ['img' => 'learning.png', 'title' => 'Language & Communication'],
        ['img' => 'learning.png', 'title' => 'STEM Exploration Series'],
    ];

    return view('auth.category', compact('courses'));
})->name('category');

Route::get('/all', function () {
    return view('auth.all');
})->name('all');

Route::get('/modules', function () {
    return view('auth.modules');
})->name('modules');

Route::get('/recommendations', function () {
    return view('auth.recommendations');
})->name('recommendations');

Route::get('/testimonials', function () {
    return view('auth.testimonials');
})->name('testimonials');

Route::get('/reviews', function () {
    return view('auth.reviews');
})->name('reviews');
