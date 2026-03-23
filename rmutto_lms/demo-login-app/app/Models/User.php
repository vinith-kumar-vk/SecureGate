<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        'language_preference',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'dob' => 'date',
            'password' => 'hashed',
            'receive_notifications' => 'boolean',
            'email_sms_notification' => 'boolean',
            'approve_policy' => 'boolean',
        ];
    }
}
