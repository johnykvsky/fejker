<?php

namespace Fejker\Test\Fixture\Enum;

enum BackedEnum: string
{
    case Assigned = 'assigned';

    case Pending = 'unassigned';

    case Deleted = 'removed';
}
