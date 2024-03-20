<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "warehouse".
 *
 * @property int $id
 * @property string|null $title
 * @property string $address
 */
class Warehouse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'warehouse';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address'], 'required'],
            [['title'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'address' => 'Address',
        ];
    }

    public static function getList() {
        return ArrayHelper::map(self::find()->all(),'id', 'title');
    }
}
