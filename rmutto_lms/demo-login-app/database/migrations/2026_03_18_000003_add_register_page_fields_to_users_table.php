<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Shared registration fields
            $table->string('role', 20)->default('learner')->after('email');
            $table->string('first_name')->nullable()->after('role');
            $table->string('last_name')->nullable()->after('first_name');
            $table->date('dob')->nullable()->after('last_name');
            $table->string('address')->nullable()->after('dob');
            $table->string('phone', 30)->nullable()->after('address');
            $table->string('id_number')->nullable()->after('phone');
            $table->string('country', 100)->nullable()->after('id_number');

            // Learner fields
            $table->string('education_level', 50)->nullable()->after('country');
            $table->string('educational_institution')->nullable()->after('education_level');
            $table->string('subject_faculty')->nullable()->after('educational_institution');
            $table->string('interest_category', 50)->nullable()->after('subject_faculty');
            $table->text('learning_objectives')->nullable()->after('interest_category');
            $table->string('knowledge_level', 50)->nullable()->after('learning_objectives');
            $table->text('payment_info')->nullable()->after('knowledge_level');
            $table->text('receipt_info')->nullable()->after('payment_info');
            $table->boolean('receive_notifications')->default(false)->after('receipt_info');
            $table->boolean('email_sms_notification')->default(false)->after('receive_notifications');

            // Guide fields
            $table->string('current_position')->nullable()->after('email_sms_notification');
            $table->string('organization')->nullable()->after('current_position');
            $table->unsignedSmallInteger('teaching_experience')->nullable()->after('organization');
            $table->text('bio')->nullable()->after('teaching_experience');
            $table->string('teaching_subjects', 100)->nullable()->after('bio');
            $table->string('teaching_language', 50)->nullable()->after('teaching_subjects');
            $table->string('certificates')->nullable()->after('teaching_language');
            $table->text('portfolio')->nullable()->after('certificates');
            $table->string('id_copy_path')->nullable()->after('portfolio');
            $table->string('profile_photo_path')->nullable()->after('id_copy_path');
            $table->string('qualification_cert_path')->nullable()->after('profile_photo_path');
            $table->text('bank_account')->nullable()->after('qualification_cert_path');
            $table->string('tax_id')->nullable()->after('bank_account');
            $table->string('taxpayer_type', 30)->nullable()->after('tax_id');

            // Shared consent
            $table->boolean('approve_policy')->default(false)->after('taxpayer_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'first_name',
                'last_name',
                'dob',
                'address',
                'phone',
                'id_number',
                'country',
                'education_level',
                'educational_institution',
                'subject_faculty',
                'interest_category',
                'learning_objectives',
                'knowledge_level',
                'payment_info',
                'receipt_info',
                'receive_notifications',
                'email_sms_notification',
                'current_position',
                'organization',
                'teaching_experience',
                'bio',
                'teaching_subjects',
                'teaching_language',
                'certificates',
                'portfolio',
                'id_copy_path',
                'profile_photo_path',
                'qualification_cert_path',
                'bank_account',
                'tax_id',
                'taxpayer_type',
                'approve_policy',
            ]);
        });
    }
};
