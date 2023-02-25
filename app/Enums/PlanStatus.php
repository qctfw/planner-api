<?php

namespace App\Enums;

enum PlanStatus: string
{
    case ToDo = 'todo';
    case InProgress = 'inprogress';
    case Review = 'review';
    case Done = 'done';
}
