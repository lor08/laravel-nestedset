<?php

namespace Fawest\Nestedset\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Model;
use Fawest\Nestedset\NodeTrait;
use Illuminate\Support\Str;
use Request;

class Category extends Model
{
    use NodeTrait;

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var array
     */
    protected $fillable = ['name', 'slug'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function categorize(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @param $class
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function entries(string $class): MorphToMany
    {
        return $this->morphedByMany($class, 'categorize', 'categories_relations');
    }

    /**
     * @return mixed
     */
    public static function tree(): array
    {
        return static::get()->toTree()->toArray();
    }

    public function setSlugAttribute(string|null $slug = ''): void
    {
        $slugCollections = $this->getAncestors()->pluck('slug')->toArray();

        if ($slug == '') $slug = Str::slug(Request::get('name'), '_');
        if ($cat = self::where('slug', $slug)->first()) {
            $idmax = self::max('id') + 1;
            if (isset($this->attributes['id'])) {
                if ($this->attributes['id'] != $cat->id) {
                    $slug = $slug . '_' . ++$idmax;
                }
            } else {
                if (self::where('slug', $slug)->count() > 0)
                    $slug = $slug . '_' . ++$idmax;
            }
        }

        $slugCollections[] = $slug;
        $newSlug = implode("/", $slugCollections);
        $this->attributes['slug'] = strlen($newSlug) ? $newSlug : $slug;
    }
}
