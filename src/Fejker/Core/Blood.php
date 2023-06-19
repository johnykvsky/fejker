<?php

declare(strict_types=1);

namespace Fejker\Core;

use Fejker\Extension\Helper;
use Fejker\Extension\BloodExtension;

final class Blood implements BloodExtension
{
    private array $bloodTypes = ['A', 'AB', 'B', 'O'];
    private array $bloodRhFactors = ['+', '-'];

    public function bloodType(): string
    {
        return Helper::randomElement($this->bloodTypes);
    }

    public function bloodRh(): string
    {
        return Helper::randomElement($this->bloodRhFactors);
    }

    public function bloodGroup(): string
    {
        return sprintf(
            '%s%s',
            $this->bloodType(),
            $this->bloodRh(),
        );
    }
}
