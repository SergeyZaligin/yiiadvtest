<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use common\components\behaviors\StatusBehavior;
use yii\db\Expression;
/**
 * This is the model class for table "blog".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property string $url
 * @property int $status_id
 * @property int $sort
 */
class Blog extends \yii\db\ActiveRecord
{
    
    const STATUS_LIST = [1 => 'Активна', 0 => 'Неактивна'];
    
    public $tagsArray;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog';
    }


    public function behaviors()
    {
        return [
            'timestampBehavior' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'date_create',
                'updatedAtAttribute' => 'date_update',
                'value' => new Expression('NOW()'),
            ],
            'statusBehavior' =>[
                'class' => StatusBehavior::className(),
                'statusList' => self::STATUS_LIST,
            ],
            
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'text', 'url'], 'required'],
            [['text'], 'string'],
            [['status_id', 'sort'], 'integer'],
            [['sort'], 'integer', 'max' => 99, 'min' => 1],
            [['title'], 'string', 'max' => 150],
            [['url'], 'string', 'max' => 255],
            [['url'], 'unique'],
            [['tagsArray', 'date_create', 'date_update'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'text' => 'Контент',
            'url' => 'ЧПУ',
            'status_id' => 'Статус',
            'sort' => 'Сортировка',
            'tagsArray' => 'Тэги',
            'date_create' => 'Дата создания',
            'date_update' => 'Дата обновления',
        ];
    }
    
    
    
    /**
     * Один автор относится к одному блогу
     * @return type
     */
    public function getAuthor() 
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    
    /**
     * 
     * @return type
     */
    public function getBlogTag() 
    {
        return $this->hasMany(BlogTag::className(), ['blog_id' => 'id']);
    }
    
    public function getTags() 
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->via('blogTag');
    }
    
    public function afterFind() 
    {
        parent::afterFind();
        $this->tagsArray = $this->tags;
    }
    
    public function getTagsAsString() 
    {
        $arr = ArrayHelper::map($this->tags,'id','name');
        return implode(',', $arr);
    }
    
    public function afterSave($insert, $changedAttributes) 
    {
        parent::afterSave($insert, $changedAttributes);
        
        //Тут Вася и Петя а кирпич в $this->tagsArray
        $arr = ArrayHelper::map($this->tags,'id','id');
        
        foreach ($this->tagsArray as $item)
        {
            if(!in_array($item, $arr))
            {
                $model = new BlogTag();
                $model->blog_id = $this->id;
                $model->tag_id = $item;
                $model->save();
            }
            
            if(isset($arr[$item]))
            {
                unset($arr[$item]);
            }
        }
        
        BlogTag::deleteAll(['tag_id' => $arr]);
    }
}
