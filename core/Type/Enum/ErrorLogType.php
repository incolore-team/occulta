<?php

namespace Core\Type\Enum;

class ErrorLogType
{
    //0 首次入库 1 系统库 2 业务员库 3 已丢失库 4 已删除库
    const Warning        = 0;
    const Error       = 1;
    const Fatal          = 2;
    const Alarm = 3;
}
