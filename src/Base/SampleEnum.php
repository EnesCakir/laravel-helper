<?php

namespace EnesCakir\Helper\Base;

class SampleEnum extends Enum
{
    const WAITING = 1;
    const ONROAD = 2;
    const ARRIVED = 3;
    const DELIVERED = 4;

    protected static $statusTexts = [
        1 => 'Bekleniyor',
        2 => 'Yolda',
        3 => 'Bize Ulaştı',
        4 => 'Teslim Edildi',
    ];
}
