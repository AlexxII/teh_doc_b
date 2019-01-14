<?php


namespace app\modules\tehdoc\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

class Images extends ActiveRecord        // модель для добавления загрузки изображений
  // и добавления путей в БД с привязкой к id оборудования
{
  public $imageFiles;


  public static function tableName()
  {
    return 'teh_image_tbl';
  }


  public function attributeLabels()
  {
    return [
        'imageFiles' => 'Изображения:',
        'eq_id' => 'Оборудование:',
        'image_path' => 'Изображения:',
    ];
  }


  public function rules()
  {
    // TODO Посмотреть безопасность image_path!
    return [
        [['image_path', 'eq_id'], 'safe'],
        [['imageFiles'], 'file',
            'extensions' => 'jpg, gif, png, jpeg',
            'maxFiles' => 10,
        ]
    ];
  }


  public function uploadImage($id)
  {
    if (empty($this->imageFiles)) {
      return false;
    }
    $flag = false;
    // store the source file name
    foreach ($this->imageFiles as $image) {
      $ext = $image->extension;
      $image_path = \Yii::$app->security->generateRandomString() . ".{$ext}";   // для сохранения в БД
      $path = \Yii::$app->params['uploadPath'] . $image_path;
      if ($image->saveAs($path, false)) {
        $model = new Images();
        $model->eq_id = $id;
        $model->image_path = $image_path;
        $model->save();
        $flag = true;
      }
    }
    return $flag;
  }


  public function uploadImageEx()
  {
    if (empty($this->imageFiles)) {
      return false;
    }
    $flag = false;
    // store the source file name
    foreach ($this->imageFiles as $image) {
      $ext = $image->extension;
      $image_path = \Yii::$app->security->generateRandomString() . ".{$ext}";   // для сохранения в БД
      $path = \Yii::$app->params['uploadPath'] . $image_path;
      if ($image->saveAs($path, false)) {
        $flag = true;
      }
    }
    return $flag;
  }


  public function getImageFile()
  {
    return isset($this->image_path) ? \Yii::$app->params['uploadPath'] . $this->image_path : null;
  }


  public function getImageUrlEx()
  {
// return a default image placeholder if your source img is not found
    $filePath = \Yii::$app->params['uploadPath'] . $this->image_path;
    if(file_exists($filePath)) {
      $image_path = isset($this->image_path) ? $this->image_path : 'image_not_found.jpg';
    } else {
      $image_path = 'image_not_found.jpg';
    }
    return \Yii::$app->params['uploadUrl'] . $image_path;
  }


  public function getImageUrl()
  {
    $image_path = isset($this->image_path) ? $this->image_path : 'default_photo.jpg';
    return \Yii::$app->params['uploadUrl'] . $image_path;
  }


  public static function getDefaultPhotoUrl()
  {
//  return a default image placeholder if your source avatar is not found
    return \Yii::$app->params['uploadUrl']. '/' . 'image_not_found.jpg';
  }

}