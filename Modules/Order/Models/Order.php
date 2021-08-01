<?php

namespace Modules\Order\Models;


use Modules\Base\BaseModel;

class Order extends BaseModel
{
    const PENDING_STATUS = 'pending';
    const APPROVED_STATUS = 'approved';

    protected $table = 'orders';

}
