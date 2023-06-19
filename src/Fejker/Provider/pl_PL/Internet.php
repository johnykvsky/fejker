<?php

declare(strict_types=1);

namespace Fejker\Provider\pl_PL;

class Internet extends \Fejker\Provider\Internet
{
    protected static array $freeEmailDomain = ['gmail.com', 'yahoo.com', 'wp.pl', 'onet.pl', 'interia.pl', 'gazeta.pl'];
    protected static array $tld = ['pl', 'pl', 'pl', 'pl', 'pl', 'pl', 'com', 'info', 'net', 'org', 'com.pl', 'com.pl'];
}
