<?php

namespace common\modules\blog\models;

use common\components\behaviors\StatusBehavior;
use common\models\User;
use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\helpers\Url;
use yii\image\drivers\Image;
use yii\web\UploadedFile;


/**
 * This is the model class for table "blog".
 *
 * @property int $id
 * @property string $title
 * @property string|null $text
 * @property string $url
 * @property string $image
 * @property string $date_create
 * @property string $date_update
 * @property int $status_id
 * @property int $sort
 */
class Blog extends ActiveRecord
{
    const STATUS_LIST = ['off', 'on'];
    const IMAGES_SIZE = [
        ['50','50'],
        ['800',null],
    ];
    public $tags_array;
    public $file;
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
            [['image'], 'string', 'max' => 100],
            [['file'], 'image'],
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
            'image' => 'Изображение',
            'file' => 'Изображение',
            'smallImage' => 'Миниатюра изображения',
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

    public function getImages()
    {
        return $this->hasMany(ImageManager::className(), ['item_id' => 'id'])->andWhere(['class'=>self::tableName()])->orderBy('sort');
    }

    public function getImagesLinks()
    {
        return ArrayHelper::getColumn($this->images,'imageUrl');
    }

    public function getImagesLinksData()
    {
        return ArrayHelper::toArray($this->images,[
                ImageManager::className() => [
                    'caption'=>'name',
                    'key'=>'id',
                ]]
        );
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

    public function getSmallImage() {
        if ($this->image) {
            $path = str_replace('admin.','',Url::home(true)).'uploads/images/blog/50x50/'.$this->image;
        } else {
            $path = str_replace('admin.','', Url::home(true)).'uploads/images/nophoto.svg';
        }
        return $path;
    }

    public function afterFind() {
        parent::afterFind();
        $this->tags_array = $this->tags;
    }

    public function beforeSave($insert) {

        if ($file = UploadedFile::getInstance($this, 'file')) {
            $dir = Yii::getAlias('@images'). '/blog/';

            if(!empty($this->image) && file_exists($dir.$this->image)) {
                unlink($dir.$this->image);
            }

            if(!empty($this->image) && file_exists($dir.'50x50/'. $this->image)) {
                unlink($dir.'50x50/'.$this->image);
            }

            if(!empty($this->image) && file_exists($dir.'800x/'. $this->image)) {
                unlink($dir.'800x/'.$this->image);
            }

            $this->image = strtotime('now') . '_' . Yii::$app->getSecurity()->generateRandomString(6) . '.' .
            $file->extension;
            $file->saveAs($dir.$this->image);
            $imag = Yii::$app->image->load($dir.$this->image);
            $imag->background('#fff', 0);
            $imag->resize('50', '50', Image::INVERSE);
            $imag->crop('50', '50');
            $imag->save($dir.'50x50/'.$this->image, 90);
            $imag = Yii::$app->image->load($dir.$this->image);
            $imag->background('#fff', 0);
            $imag->resize('800', null, Image::INVERSE);
            $imag->save($dir.'800x/'.$this->image, 90);
        }
        return parent::beforeSave($insert);
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

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $dir = Yii::getAlias('@images').'/blog/';
            if(file_exists($dir.$this->image)){
                unlink($dir.$this->image);
            }
            foreach (self::IMAGES_SIZE as $size){
                $size_dir = $size[0].'x';
                if($size[1] !== null)
                    $size_dir .= $size[1];
                if(file_exists($dir.$this->image)){
                    unlink($dir.$size_dir.'/'.$this->image);
                }
            }
            BlogTag::deleteAll(['blog_id'=>$this->id]);
            return true;
        } else {
            return false;
        }
    }
}





