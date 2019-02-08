<?php

namespace EnesCakir\Helper\Traits;

trait Selectable
{
    public function getSelectName()
    {
        return 'name';
    }

    public static function toSelect($placeholder = null, $key = null, $value = null)
    {
        $instance = new static;
        $keyName = $key
            ? $key
            : $instance->getKeyName();
        $valueName = $value
            ? $value
            : $instance->getSelectName();

        $result = static::orderBy($valueName)->get()->pluck($valueName, $keyName);

        return $placeholder
            ? collect(['' => $placeholder])->union($result)
            : $result;
    }
}