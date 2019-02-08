<?php

namespace EnesCakir\Helper\Traits;

trait Selectable
{
    public function getSelectName()
    {
        return 'name';
    }

    public static function toSelect($placeholder = null)
    {
        $key = ($instance = new static)->getKeyName();
        $value = $instance->getSelectName();

        $result = static::orderBy($value)->get()->pluck($value, $key);

        return $placeholder
            ? collect(['' => $placeholder])->union($result)
            : $result;
    }
}