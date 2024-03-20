<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_in_order".
 *
 * @property int $id
 * @property int|null $created_at
 * @property float|null $price
 * @property int|null $product_id
 * @property int|null $order_id
 */
class ProductInOrder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_in_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'product_id', 'order_id'], 'integer'],
            [['price'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'price' => 'Price',
            'product_id' => 'Product ID',
            'order_id' => 'Order ID',
        ];
    }
}
