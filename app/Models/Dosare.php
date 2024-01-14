<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Dosare extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    public $table = 'dosares';

    public static $searchable = [
        'company_name',
    ];

    protected $dates = [
        'incident_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'id_card',
        'asig_paper',
        'aditional_files',
        'aditional_photos',
    ];

    public const STATUS_SELECT = [
        'open'               => 'deschis',
        'pendindg-documents' => 'In asteptare documente',
        'closed'             => 'inchis',
    ];

    protected $fillable = [
        'status',
        'name',
        'first_name',
        'email_id',
        'company_name',
        'cui',
        'incident_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function email()
    {
        return $this->belongsTo(User::class, 'email_id');
    }

    public function getIncidentDateAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setIncidentDateAttribute($value)
    {
        $this->attributes['incident_date'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getIdCardAttribute()
    {
        $file = $this->getMedia('id_card')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function getAsigPaperAttribute()
    {
        return $this->getMedia('asig_paper')->last();
    }

    public function getAditionalFilesAttribute()
    {
        return $this->getMedia('aditional_files');
    }

    public function getAditionalPhotosAttribute()
    {
        $files = $this->getMedia('aditional_photos');
        $files->each(function ($item) {
            $item->url       = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview   = $item->getUrl('preview');
        });

        return $files;
    }
}
