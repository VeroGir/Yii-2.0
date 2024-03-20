<?php

namespace frontend\models;



use common\models\Documents;

class User extends \common\models\User
{
    public function fields()
    {
        return [
            'id',
            'username',
            'email',
            'passport' => function($model) {
                return $model->id == 4 ? $model->username : 'none';
            }
        ];
    }

    public function extraFields()
    {
        return [
            'documents'
        ];
    }

    public function getDocuments() {
        return $this->hasMany(Documents::class, ['user_id'=>'id']);
    }

}