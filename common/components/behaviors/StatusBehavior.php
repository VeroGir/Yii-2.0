<?php

namespace common\components\behaviors;

use yii\base\Behavior;


class StatusBehavior extends Behavior
{
    public $statusList;

    public function events()
    {
        return [

        ];
    }


    public function getStatusList() {
        return $this->statusList;
    }

    public function getStatusName() {
        $list = $this->owner->getStatusList();
        return $list[$this->owner->status_id];
    }

}