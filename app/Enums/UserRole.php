<?php

namespace App\Enums;

enum UserRole: int
{
    case User = 0;
    case Operator = 1;
    case Admin = 2;
}
