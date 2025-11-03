<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class EmployeeDocument extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_id',
        'document_type',
        'document_name',
        'file_path',
        'notes',
    ];

    /**
     * Document type configurations
     */
    public static function getDocumentTypes(): array
    {
        return [
            'all' => ['name' => 'All Documents', 'icon' => 'fas fa-folder', 'color' => '#4B5563'],
            'warning' => ['name' => 'Warnings', 'icon' => 'fas fa-exclamation-triangle', 'color' => '#DC2626'],
            'appreciation' => ['name' => 'Appreciation', 'icon' => 'fas fa-trophy', 'color' => '#059669'],
            'medical' => ['name' => 'Medical', 'icon' => 'fas fa-briefcase-medical', 'color' => '#7C3AED'],
            'contract' => ['name' => 'Contracts', 'icon' => 'fas fa-file-contract', 'color' => '#2563EB'],
            'evaluation' => ['name' => 'Evaluations', 'icon' => 'fas fa-chart-bar', 'color' => '#EA580C'],
            'promotion' => ['name' => 'Promotions', 'icon' => 'fas fa-chart-line', 'color' => '#CA8A04'],
            'resignation' => ['name' => 'Resignations', 'icon' => 'fas fa-door-open', 'color' => '#78716C'],
            'other' => ['name' => 'Other', 'icon' => 'fas fa-box', 'color' => '#18458f'],
        ];
    }

    /**
     * Get document type configuration
     */
    public function getTypeConfigAttribute(): array
    {
        $types = self::getDocumentTypes();
        return $types[$this->document_type] ?? $types['other'];
    }

    /**
     * Get document type badge color
     */
    public function getTypeBadgeColorAttribute(): string
    {
        return $this->type_config['color'];
    }

    /**
     * Get document type icon
     */
    public function getTypeIconAttribute(): string
    {
        return $this->type_config['icon'];
    }

    /**
     * Get document type name
     */
    public function getTypeNameAttribute(): string
    {
        return $this->type_config['name'];
    }

    /**
     * Get the employee that owns the document.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Check if the file exists in storage.
     */
    public function fileExists(): bool
    {
        return Storage::disk('private')->exists($this->file_path);
    }

    /**
     * Get the file size in human-readable format.
     */
    public function getFileSizeAttribute(): ?string
    {
        if (!$this->fileExists()) {
            return null;
        }

        $bytes = Storage::disk('private')->size($this->file_path);
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Get the file extension.
     */
    public function getFileExtensionAttribute(): string
    {
        return pathinfo($this->file_path, PATHINFO_EXTENSION);
    }

    /**
     * Get icon class based on file extension.
     */
    public function getFileIconAttribute(): string
    {
        return match($this->file_extension) {
            'pdf' => 'fas fa-file-pdf text-red-500',
            'doc', 'docx' => 'fas fa-file-word text-blue-500',
            'xls', 'xlsx' => 'fas fa-file-excel text-green-500',
            'jpg', 'jpeg', 'png', 'gif' => 'fas fa-file-image text-purple-500',
            'zip', 'rar' => 'fas fa-file-archive text-yellow-500',
            default => 'fas fa-file text-gray-500',
        };
    }
}
