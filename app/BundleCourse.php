<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BundleCourse extends Model
{
    use HasTranslations;

    public $translatable = ['title', 'detail'];

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        $attributes = parent::toArray();

        foreach ($this->getTranslatableAttributes() as $name) {
            $attributes[$name] = $this->getTranslation($name, app()->getLocale());
        }

        return $attributes;
    }

    protected $table = 'bundle_courses';

    protected $fillable = ['user_id', 'course_id', 'title', 'detail', 'price', 'discount_price', 'type', 'slug', 'status', 'featured', 'preview_image'];

    protected $casts = [
        'course_id' => 'array'
    ];

    public function courses()
    {
        return $this->belongsTo('App\Course', 'course_id', 'id');
    }

    public function User()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function order()
    {
        return $this->hasMany('App\Order', 'bundle_id');
    }
}
