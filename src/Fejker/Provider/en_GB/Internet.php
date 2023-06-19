<?php

declare(strict_types=1);

namespace Fejker\Provider\en_GB;

class Internet extends \Fejker\Provider\Internet
{
    protected static array $freeEmailDomain = ['gmail.com', 'yahoo.com', 'hotmail.com', 'gmail.co.uk', 'yahoo.co.uk', 'hotmail.co.uk'];
    protected static array $tld = ['com', 'com', 'com', 'com', 'com', 'com', 'biz', 'info', 'net', 'org', 'co.uk'];
}
