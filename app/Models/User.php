<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'is_active',
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
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the jobs posted by the user.
     */
    public function jobs()
    {
        return $this->hasMany(Job::class, 'posted_by');
    }

    /**
     * Get the profile associated with the user.
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Get the applications submitted by the user.
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Calculate the user's profile completion status with localized labels.
     */
    public function profileCompletionStatus(): array
    {
        $definitions = [
            [
                'key' => 'name',
                'label_key' => 'site.profile_completion.fields.name',
                'resolver' => fn(self $user) => $user->name,
            ],
            [
                'key' => 'headline',
                'label_key' => 'site.profile_completion.fields.headline',
                'resolver' => fn(self $user) => optional($user->profile)->headline,
            ],
            [
                'key' => 'location',
                'label_key' => 'site.profile_completion.fields.location',
                'resolver' => fn(self $user) => optional($user->profile)->location,
            ],
            [
                'key' => 'current_position',
                'label_key' => 'site.profile_completion.fields.current_position',
                'resolver' => fn(self $user) => optional($user->profile)->current_position,
            ],
            [
                'key' => 'experience_years',
                'label_key' => 'site.profile_completion.fields.experience_years',
                'resolver' => fn(self $user) => optional($user->profile)->experience_years,
            ],
            [
                'key' => 'skills',
                'label_key' => 'site.profile_completion.fields.skills',
                'resolver' => fn(self $user) => optional($user->profile)->skills,
            ],
            [
                'key' => 'about',
                'label_key' => 'site.profile_completion.fields.about',
                'resolver' => fn(self $user) => optional($user->profile)->about,
            ],
            [
                'key' => 'education',
                'label_key' => 'site.profile_completion.fields.education',
                'resolver' => fn(self $user) => optional($user->profile)->education,
            ],
            [
                'key' => 'linkedin_url',
                'label_key' => 'site.profile_completion.fields.linkedin_url',
                'resolver' => fn(self $user) => optional($user->profile)->linkedin_url,
            ],
            [
                'key' => 'cv_path',
                'label_key' => 'site.profile_completion.fields.cv_path',
                'resolver' => fn(self $user) => optional($user->profile)->cv_path,
            ],
        ];

        $fields = [];
        $filledCount = 0;
        $missingKeys = [];

        foreach ($definitions as $definition) {
            $value = $definition['resolver']($this);

            if (is_string($value)) {
                $value = trim($value);
            }

            $isFilled = !is_null($value) && $value !== '';

            $fields[$definition['key']] = [
                'key' => $definition['key'],
                'label_key' => $definition['label_key'],
                'label' => __($definition['label_key']),
                'filled' => $isFilled,
            ];

            if ($isFilled) {
                $filledCount++;
            } else {
                $missingKeys[] = $definition['key'];
            }
        }

        $total = count($definitions);
        $percentage = $total > 0 ? (int) round(($filledCount / $total) * 100) : 100;

        $missing = array_map(function ($key) use ($fields) {
            return [
                'key' => $key,
                'label_key' => $fields[$key]['label_key'],
                'label' => $fields[$key]['label'],
            ];
        }, $missingKeys);

        return [
            'percentage' => $percentage,
            'filled' => $filledCount,
            'total' => $total,
            'fields' => $fields,
            'missing' => $missing,
        ];
    }
}
