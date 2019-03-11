<?php

namespace app\modules\tehdoc\modules\equipment\models;

use Yii;
use yii\helpers\ArrayHelper;

class Docs extends \yii\db\ActiveRecord
{
  public $docFiles;

  public static function tableName()
  {
    return 'teh_docs_tbl';
  }

  public function attributeLabels()
  {
    return [
      'docFiles' => 'Документ:',
      'doc_title' => 'Название документа:',
      'doc_date' => 'Дата документа:',
      'eq_id' => 'Оборудование:',
      'doc_path' => 'Документы:',
    ];
  }

  public function rules()
  {
    // TODO Посмотреть безопасность image_path!
    return [
      [['doc_title', 'doc_date'], 'required'],
      [['doc_path', 'eq_id'], 'safe'],
      [['doc_title'], 'string', 'max' => 255],
      [['docFiles'], 'file',
        'extensions' => 'docx, doc, ppt, pdf',
        'maxFiles' => 30,
      ]
    ];
  }

  public function uploadDocs($id)
  {
    if (empty($this->docFiles)) {
      return false;
    }
    $flag = false;
    // store the source file name
    foreach ($this->docFiles as $doc) {
      $date = date('Y-m-d H:i:s');
      $userId = Yii::$app->user->identity->ref;
      $ext = $doc->extension;

      $doc_path = \Yii::$app->security->generateRandomString() . ".{$ext}";   // для сохранения в БД
      $path = \Yii::$app->params['uploadPath'] . $doc_path;
      if ($doc->saveAs($path, false)) {
        $model = new Images();
        $model->eq_id = $id;
        $model->doc_path = $doc_path;
        $model->doc_extention = $ext;
        $model->doc_date = $ext;
        $model->upload_time = $date;
        $model->upload_user = $userId;
        $model->save();
        $flag = true;
      }
    }
    return $flag;
  }

  public function getDocFile()
  {
    return isset($this->doc_path) ? \Yii::$app->params['uploadPath'] . $this->doc_path : null;
  }

  public function getDocUrl()
  {
    $doc_path = isset($this->doc_path) ? $this->doc_path : 'default_photo.jpg';
    return \Yii::$app->params['uploadUrl'] . $doc_path;
  }

}