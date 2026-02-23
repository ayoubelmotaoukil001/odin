<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes ;

class Link extends Model
{
    use SoftDeletes ;
    use HasFactory ;

    protected $fillable = ['title' ,'url' ,'category_id'  ,'user_id'];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }


    public function sharedWith()
    {
        return $this->belongsToMany(User::class, 'link_user')
                    ->withPivot('permission')
                    ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function sharedWithUsers()
    {
        return $this->belongsToMany(User::class, 'link_user')
                    ->withPivot('permession') 
                    ->withTimestamps();
    }

//**unsderstaand this */
    public function isFavoritedBy($user): bool
    {
        if (!$user) return false;
        return $this->belongsToMany(User::class, 'favorites')->where('user_id', $user->id)->exists();
    }

}
