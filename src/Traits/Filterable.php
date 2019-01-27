<?php

namespace EnesCakir\Helper\Traits;

use Illuminate\Http\Request;
use EnesCakir\Helper\Base\Filter;

trait Filterable
{
    public function scopeFilter($query, Filter $filter)
    {
        return $filter->apply($query);
    }
}
