<?php

namespace App\Enums;

enum HttpMethodEnum: string
{
    case Post = "post";
    case Get = 'get';
    case Delete = 'delete';
}