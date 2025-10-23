<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\HasLocalizedAttributes;

class Category extends Model
{
    use HasFactory, SoftDeletes, HasLocalizedAttributes;

    protected $appends = [
        'admin_label',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'name_ar',
        'description',
        'description_ar',
    ];

    /**
     * Get the sub categories for the category.
     */
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function getDisplayNameAttribute(): ?string
    {
        return $this->getLocalizedValue('name');
    }

    public function getDisplayDescriptionAttribute(): ?string
    {
        return $this->getLocalizedValue('description');
    }

    public function getAdminLabelAttribute(): string
    {
        return $this->formatBilingualLabel('name');
    }

    protected function formatBilingualLabel(string $attribute): string
    {
        $english = $this->getAttribute("{$attribute}_en") ?? $this->getAttribute($attribute) ?? '';
        $arabic = $this->getAttribute("{$attribute}_ar") ?? '';

        if ($english && $arabic && $english !== $arabic) {
            return "{$english} ({$arabic})";
        }

        return $english ?: $arabic ?: '';
    }
}
