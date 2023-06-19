<?php

declare(strict_types=1);

namespace Fejker\Provider\pl_PL;

class PhoneNumber extends \Fejker\Provider\PhoneNumber
{
    protected static array $formats = [
        '+48 ## ### ## ##',
        '0048 ## ### ## ##',
        '### ### ###',
        '+48 ### ### ###',
        '0048 ### ### ###',
        '#########',
        '(##) ### ## ##',
        '+48(##)#######',
        '0048(##)#######',
    ];
}
