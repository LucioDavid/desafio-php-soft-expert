<?php

namespace Src\Core\Enums;

enum SessionMessageTypes: string
{
    case OK = 'ok';
    case ERROR = 'error';
    case INFO = 'info';
}