<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Ramsey\Uuid\Uuid;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'referred_by',
        'referral_code',
        'login_2fa',
        'mnemonic',
        'banned_until',
    ];

    protected array $dates = [
        'banned_until'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string)Uuid::uuid4();
            }
        });
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'user_id', 'id');
    }
//this return just an user which is owner of companies
    public function companies()
    {
        return $this->hasMany(Company::class, 'owner_id');
    }

    // if user belongs a company project so company will listed  as a user company
    public function allCompanies()
    {
        // Fetch companies owned by the user
        $ownedCompanies = $this->companies;

        // Fetch companies where the user is involved in any project
        $projectCompanies = Company::whereHas('projects', function ($query) {
            $query->whereHas('users', function ($q) {
                $q->where('user_id', $this->id);
            });
        })->get();

        // Merge the two collections and remove duplicates
        return $ownedCompanies->merge($projectCompanies)->unique('id');
    }


    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_user')
            ->withTimestamps()
            ->withPivot('is_active');
    }

    public function processRecords()
    {
        return $this->hasMany(ProcessRecord::class, 'user_id');
    }

}
