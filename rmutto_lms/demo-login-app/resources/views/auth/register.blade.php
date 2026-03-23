@extends('layouts.app')

@section('title', 'Sign Up')

@push('styles')
<style>
    .register-wrapper .label-field.checkbox-field {
        flex-direction: row;
        align-items: center;
        gap: 10px;
    }

    .register-wrapper .label-field.checkbox-field input[type="checkbox"] {
        width: 18px;
        height: 18px;
        min-width: 18px;
        margin: 0;
        padding: 0;
        accent-color: var(--deep-navy);
        cursor: pointer;
    }

    .register-wrapper .label-field.checkbox-field label {
        margin-bottom: 0;
        display: inline;
        cursor: pointer;
    }
</style>
@endpush

@section('content')
<div class="login-wrapper register-wrapper" style="margin: 40px auto;">
    <div class="login-card" style="padding: 60px 80px;">
        <!-- Title -->
        <h1 class="login-title" style="color: #333; font-size: 26px; margin-bottom: 40px; font-weight: 700;">Sign Up and Start Learning!</h1>

            <form action="{{ route('register.post') }}" method="POST" class="auth-form" id="registerForm" enctype="multipart/form-data">
                @csrf

                <!-- Role Toggle -->
                <div class="role-toggle-container">
                    <div class="role-toggle">
                        <input type="radio" id="role-learner" name="role" value="learner" {{ old('role', 'learner') === 'learner' ? 'checked' : '' }}>
                        <label for="role-learner" class="toggle-btn" id="label-learner">Learner</label>
                        
                        <input type="radio" id="role-guide" name="role" value="guide" {{ old('role') === 'guide' ? 'checked' : '' }}>
                        <label for="role-guide" class="toggle-btn" id="label-guide">Guide</label>
                        
                        <div class="toggle-slider"></div>
                    </div>
                </div>

                @if ($errors->any())
                    <div style="color: red; margin-bottom: 20px; font-size: 14px;">
                        @foreach ($errors->all() as $error)
                            <div>- {{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="form-grid">
                    <!-- BASIC INFORMATION (Shared) -->
                    <h3 style="grid-column: 1 / -1; margin-top: 20px; margin-bottom: 15px; color: #333;">Basic Information</h3>
                    
                    <!-- Row 1 -->
                    <div class="label-field">
                        <label for="first_name">First Name<span style="color:red">*</span></label>
                        <input type="text" id="first_name" name="first_name" placeholder="John" required>
                    </div>
                    <div class="label-field">
                        <label for="last_name">Last Name<span style="color:red">*</span></label>
                        <input type="text" id="last_name" name="last_name" placeholder="Doe" required>
                    </div>

                    <!-- Row 2 -->
                    <div class="label-field">
                        <label for="email">Email Address<span style="color:red">*</span></label>
                        <input type="email" id="email" name="email" placeholder="123@gmail.com" required>
                    </div>
                    <div class="label-field">
                        <label for="dob">Date of Birth<span style="color:red">*</span></label>
                        <input type="date" id="dob" name="dob" required>
                    </div>

                    <!-- Row 3 -->
                    <div class="label-field">
                        <label for="address">Address / Province<span style="color:red">*</span></label>
                        <input type="text" id="address" name="address" placeholder="Enter your address" required>
                    </div>
                    <div class="label-field">
                        <label for="phone">Phone Number<span style="color:red">*</span></label>
                        <input type="text" id="phone" name="phone" placeholder="000-0000 0000" required>
                    </div>

                    <!-- Row 4 -->
                    <div class="label-field">
                        <label for="id_number">ID Number<span style="color:red">*</span></label>
                        <input type="text" id="id_number" name="id_number" placeholder="Enter your ID number" required>
                    </div>
                    <div class="label-field">
                        <label for="country">Country<span style="color:red">*</span></label>
                        <select id="country" name="country">
                            <option value="Malaysia">Malaysia</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <!-- Row 5 -->
                    <div class="label-field" style="grid-column: 1 / -1;">
                        <label for="password">Create Password<span style="color:red">*</span></label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="label-field" style="grid-column: 1 / -1;">
                        <label for="password_confirmation">Confirm Password<span style="color:red">*</span></label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <!-- LEARNER SECTION -->
                    <div id="learner-section" style="grid-column: 1 / -1;">
                        <h3 style="margin-top: 30px; margin-bottom: 15px; color: #333;">Educational Information</h3>
                        
                        <div class="label-field">
                            <label for="education_level">Current Level of Education<span style="color:red">*</span></label>
                            <select id="education_level" name="education_level">
                                <option value="">Select an option</option>
                                <option value="primary">Primary School</option>
                                <option value="secondary">Secondary School</option>
                                <option value="highschool">High School</option>
                                <option value="diploma">Diploma</option>
                                <option value="bachelor">Bachelor's Degree</option>
                                <option value="master">Master's Degree</option>
                                <option value="phd">PhD</option>
                            </select>
                        </div>
                        <div class="label-field">
                            <label for="educational_institution">Educational Institutions</label>
                            <input type="text" id="educational_institution" name="educational_institution" placeholder="e.g., University Name">
                        </div>
                        <div class="label-field">
                            <label for="subject_faculty">Subject / Faculty</label>
                            <input type="text" id="subject_faculty" name="subject_faculty" placeholder="e.g., Computer Science">
                        </div>

                        <h3 style="margin-top: 30px; margin-bottom: 15px; color: #333;">Learning Interests and Goals</h3>
                        
                        <div class="label-field">
                            <label for="interest_category">Subject Category of Interest<span style="color:red">*</span></label>
                            <select id="interest_category" name="interest_category">
                                <option value="">Select a category</option>
                                <option value="programming">Programming</option>
                                <option value="design">Design</option>
                                <option value="business">Business</option>
                                <option value="languages">Languages</option>
                                <option value="mathematics">Mathematics</option>
                                <option value="science">Science</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="label-field">
                            <label for="learning_objectives">Learning Objectives<span style="color:red">*</span></label>
                            <textarea id="learning_objectives" name="learning_objectives" placeholder="Describe your learning goals" style="height: 80px;"></textarea>
                        </div>
                        <div class="label-field">
                            <label for="knowledge_level">Original Level of Knowledge</label>
                            <select id="knowledge_level" name="knowledge_level">
                                <option value="">Select level</option>
                                <option value="beginner">Beginner</option>
                                <option value="intermediate">Intermediate</option>
                                <option value="advanced">Advanced</option>
                            </select>
                        </div>

                        <h3 style="margin-top: 30px; margin-bottom: 15px; color: #333;">Payment & Notifications</h3>
                        
                        <div class="label-field">
                            <label for="payment_info">Payment Information</label>
                            <input type="text" id="payment_info" name="payment_info" placeholder="Enter payment details if applicable">
                        </div>
                        <div class="label-field">
                            <label for="receipt_info">Receipt/Tax Invoice Information</label>
                            <input type="text" id="receipt_info" name="receipt_info" placeholder="Enter receipt/invoice details if needed">
                        </div>
                        <div class="label-field checkbox-field" style="grid-column: 1 / -1;">
                            <input type="checkbox" id="receive_notifications" name="receive_notifications">
                            <label for="receive_notifications">Receive new information and courses</label>
                        </div>
                        <div class="label-field checkbox-field" style="grid-column: 1 / -1;">
                            <input type="checkbox" id="email_sms_notification" name="email_sms_notification">
                            <label for="email_sms_notification">Allow Email/SMS notifications</label>
                        </div>
                    </div>

                    <!-- GUIDE/INSTRUCTOR SECTION -->
                    <div id="guide-section" style="grid-column: 1 / -1; display: none;">
                        <h3 style="margin-top: 30px; margin-bottom: 15px; color: #333;">Professional Information</h3>
                        
                        <div class="label-field">
                            <label for="current_position">Current Position / Career<span style="color:red">*</span></label>
                            <input type="text" id="current_position" name="current_position" placeholder="e.g., Senior Software Engineer">
                        </div>
                        <div class="label-field">
                            <label for="organization">Associated Organization / Institution</label>
                            <input type="text" id="organization" name="organization" placeholder="e.g., Tech Company Name">
                        </div>
                        <div class="label-field">
                            <label for="teaching_experience">Teaching Experience (Years)<span style="color:red">*</span></label>
                            <input type="number" id="teaching_experience" name="teaching_experience" placeholder="e.g., 5" min="0">
                        </div>
                        <div class="label-field">
                            <label for="bio">Brief History / Bio<span style="color:red">*</span></label>
                            <textarea id="bio" name="bio" placeholder="Tell us about yourself" style="height: 100px;"></textarea>
                        </div>

                        <h3 style="margin-top: 30px; margin-bottom: 15px; color: #333;">Expertise</h3>
                        
                        <div class="label-field">
                            <label for="teaching_subjects">Category of Subjects to Teach<span style="color:red">*</span></label>
                            <select id="teaching_subjects" name="teaching_subjects">
                                <option value="">Select a subject category</option>
                                <option value="programming">Programming</option>
                                <option value="design">Design</option>
                                <option value="business">Business</option>
                                <option value="languages">Languages</option>
                                <option value="mathematics">Mathematics</option>
                                <option value="science">Science</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="label-field">
                            <label for="teaching_language">Taught Language<span style="color:red">*</span></label>
                            <select id="teaching_language" name="teaching_language">
                                <option value="">Select a language</option>
                                <option value="english">English</option>
                                <option value="malay">Malay</option>
                                <option value="chinese">Chinese</option>
                                <option value="spanish">Spanish</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="label-field">
                            <label for="certificates">Graduate / Certificate<span style="color:red">*</span></label>
                            <input type="text" id="certificates" name="certificates" placeholder="e.g., Bachelor's in Computer Science">
                        </div>
                        <div class="label-field">
                            <label for="portfolio">Portfolio / Past Works</label>
                            <input type="text" id="portfolio" name="portfolio" placeholder="e.g., Portfolio URL or description">
                        </div>

                        <h3 style="margin-top: 30px; margin-bottom: 15px; color: #333;">Identity Confirmation</h3>
                        
                        <div class="label-field">
                            <label for="id_copy">Copy of ID Card / Passport<span style="color:red">*</span></label>
                            <input type="file" id="id_copy" name="id_copy" accept="image/*,.pdf" required>
                        </div>
                        <div class="label-field">
                            <label for="profile_photo">Profile Photograph<span style="color:red">*</span></label>
                            <input type="file" id="profile_photo" name="profile_photo" accept="image/*" required>
                        </div>
                        <div class="label-field">
                            <label for="qualification_cert">Certificate of Qualification<span style="color:red">*</span></label>
                            <input type="file" id="qualification_cert" name="qualification_cert" accept="image/*,.pdf" required>
                        </div>

                        <h3 style="margin-top: 30px; margin-bottom: 15px; color: #333;">Payment & Tax Information</h3>
                        
                        <div class="label-field">
                            <label for="bank_account">Bank Account Information<span style="color:red">*</span></label>
                            <input type="text" id="bank_account" name="bank_account" placeholder="Enter bank account details">
                        </div>
                        <div class="label-field">
                            <label for="tax_id">Taxpayer Identification Number<span style="color:red">*</span></label>
                            <input type="text" id="tax_id" name="tax_id" placeholder="Enter tax ID number">
                        </div>
                        <div class="label-field">
                            <label for="taxpayer_type">Taxpayer Type<span style="color:red">*</span></label>
                            <select id="taxpayer_type" name="taxpayer_type">
                                <option value="">Select type</option>
                                <option value="individual">Individual</option>
                                <option value="corporate">Corporate</option>
                            </select>
                        </div>
                    </div>

                    <!-- Policy Approval (Shared) -->
                    <div class="label-field checkbox-field" style="grid-column: 1 / -1; margin-top: 20px;">
                        <input type="checkbox" id="approve_policy" name="approve_policy" required>
                        <label for="approve_policy">I approve the policy <span style="color:red">*</span></label>
                    </div>
                </div>

                <p class="tc-text">By signing up, you agree to our Terms, Data Policy & Cookies Policy.</p>

                <div class="form-actions row-actions" style="margin-top: 30px; justify-content: center; gap: 20px;">
                    <button type="submit" class="btn btn-primary" style="max-width: 280px;">Save & Continue</button>
                    <a href="{{ route('login') }}" class="btn btn-secondary" style="max-width: 280px; text-decoration: none; color: #4b5563;">Cancel</a>
                </div>
            </form>

            <div class="signup-container" style="margin-top: 30px;">
                <p>Already have an Account? <a href="{{ route('login') }}" class="signup-link">Sign in</a></p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const registerForm = document.getElementById('registerForm');
        const roleRadios = document.querySelectorAll('input[name="role"]');
        const learnerSection = document.getElementById('learner-section');
        const guideSection = document.getElementById('guide-section');

        const learnerRequiredFields = [
            'education_level',
            'interest_category',
            'learning_objectives',
        ];

        const guideRequiredFields = [
            'current_position',
            'teaching_experience',
            'bio',
            'teaching_subjects',
            'teaching_language',
            'certificates',
            'id_copy',
            'profile_photo',
            'qualification_cert',
            'bank_account',
            'tax_id',
            'taxpayer_type',
        ];

        function setRequiredState(fieldName, shouldRequire) {
            const field = registerForm.querySelector(`[name="${fieldName}"]`);
            if (!field) {
                return;
            }

            if (shouldRequire) {
                field.setAttribute('required', 'required');
            } else {
                field.removeAttribute('required');
            }
        }

        function setSectionEnabled(sectionElement, shouldEnable) {
            const controls = sectionElement.querySelectorAll('input, select, textarea');
            controls.forEach((control) => {
                control.disabled = !shouldEnable;
            });
        }

        function updateSections() {
            const selectedRole = document.querySelector('input[name="role"]:checked')?.value;
            
            if (selectedRole === 'learner') {
                learnerSection.style.display = 'block';
                guideSection.style.display = 'none';

                learnerRequiredFields.forEach((fieldName) => setRequiredState(fieldName, true));
                guideRequiredFields.forEach((fieldName) => setRequiredState(fieldName, false));

                setSectionEnabled(learnerSection, true);
                setSectionEnabled(guideSection, false);
            } else if (selectedRole === 'guide') {
                learnerSection.style.display = 'none';
                guideSection.style.display = 'block';

                learnerRequiredFields.forEach((fieldName) => setRequiredState(fieldName, false));
                guideRequiredFields.forEach((fieldName) => setRequiredState(fieldName, true));

                setSectionEnabled(learnerSection, false);
                setSectionEnabled(guideSection, true);
            }
        }

        roleRadios.forEach(radio => {
            radio.addEventListener('change', updateSections);
        });

        // Initialize sections on page load
        updateSections();
    });
</script>
@endsection

