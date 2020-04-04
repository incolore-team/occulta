<?php

namespace Core\Type\Enum;

class Status
{
    //0 首次入库 1 系统库 2 业务员库 3 已丢失库 4 已删除库
    const SignUp        = 0;
    const System        = 1;
    const User          = 2;
    const Lost          = 3;
    const Deleted       = 4;
}
