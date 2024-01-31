<?php

namespace common\models;

use common\components\behaviors\StatusBehavior;
use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\db\Expression;


/**
 * This is the model class for table "blog".
 *
 * @property int $id
 * @property string $title
 * @property string|null $text
 * @property string $url
 * @property string $date_create
 * @property string $date_update
 * @property int $status_id
 * @property int $sort
 */
class Blog extends ActiveRecord
{
    const STATUS_LIST = ['off', 'on'];
    public $tags_array;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blog';
    }

    public function behaviors()
    {
        return [
           'timestampBehavior' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'date_create',
                'updatedAtAttribute' => 'date_update',
                'value' => new Expression('NOW()'),
            ],
            'statusBehavior' => [
                'class' => StatusBehavior::class,
                'statusList' => self::STATUS_LIST,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'url'], 'required'],
            [['text'], 'string'],
            [['url'], 'unique'],
            [['status_id', 'sort'], 'integer'],
            [['sort'], 'integer', 'max' => 99, 'min' => 1],
            [['title', 'url'], 'string', 'max' => 150],
            [['tags_array', 'date_create', 'date_update'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Идентификатор',
            'title' => 'Заголовок',
            'text' => 'Текст',
            'url' => 'ЧПУ',
            'status_id' => 'Статус идентификатора',
            'sort' => 'Сортировка',
            'tags_array' => 'Теги',
            'author.username' => 'Имя автора',
            'author.email' => 'Почта автора',
            'tagsAsString' => 'Теги',
            'date_create' => 'Создано',
            'date_update' => 'Обновлено',
        ];
    }



    public function getAuthor() {
        return $this->hasOne(User::className(), ['id' => 'status_id']);
    }

    public function getBlogTag() {
       return $this->hasMany(BlogTag::className(),['blog_id' => 'id']);
    }

    public function getTags() {
        return $this->hasMany(Tag::className(),['id' => 'tag_id'])->via('blogTag');
    }

    public function getTagsAsString() {
        $arr = ArrayHelper::map($this->tags, 'id', 'name');
        return implode(', ', $arr);
    }


    public function afterFind() {
        parent::afterFind();
        $this->tags_array = $this->tags;
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert,$changedAttributes);

        $arr = ArrayHelper::map($this->tags, 'id', 'id');

        foreach ($this->tags_array as $one) {
            if (!in_array($one, $arr)) {
                $model = new BlogTag();
                $model->blog_id = $this->id;
                $model->tag_id = $one;
                $model->save();
            }
            if (isset($arr[$one])) {
                unset($arr[$one]);
            }
        }
        BlogTag::deleteAll(['tag_id'=>$arr]);
    }
}
