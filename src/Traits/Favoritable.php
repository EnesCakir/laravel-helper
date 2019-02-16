<?php

namespace EnesCakir\Helper\Traits;

use App\Models\User;
use Carbon\Carbon;
use Auth;

trait Favoritable
{
    public function favorite($favorite = true, $single = false)
    {
        if ($favorite) {
            if ($single) {
                static::favorited()->update(['favorited_at' => null]);
            }
            $this->favorited_at = Carbon::now();
            $this->favorited_by = Auth::id();
        } else {
            $this->favorited_at = null;
            $this->favorited_by = null;
        }
        return $this->save();
    }

    public function isFavorited()
    {
        return !is_null($this->favorited_at);
    }

    public function scopeFavorited($query, $favorite = true)
    {
        if ($favorite) {
            $query->whereNotNull('favorited_at');
        } else {
            $query->whereNull('favorited_at');
        }
    }

    public function getFavoritedAtLabelAttribute()
    {
        return date('d.m.Y H:i', strtotime($this->attributes['favorited_at']));
    }

    public function favoriter()
    {
        return $this->belongsTo(User::class, 'favorited_by');
    }
}
