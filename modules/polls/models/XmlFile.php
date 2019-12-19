<?php

namespace app\modules\polls\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use XMLReader;


class XmlFile extends Model
{
  /**
   * @var UploadedFile
   */
  public $xmlFile;
  public $xmlName;
  public $error;
  public $answersCount;
  public $questionsCount;

  public function rules()
  {
    return [
      [["xmlFile"], "file", "skipOnEmpty" => false, "extensions" => "xml"],
    ];
  }

  public function attributeLabels()
  {
    return [
      "xmlFile" => "Загрузить XML файл:"
    ];
  }

  public function upload($name)
  {
    $xml = $this->xmlFile[0];
    $this->xmlName = \Yii::$app->params["uploadXml"] . $name;
    try {
      $xml->saveAs($this->xmlName, false);
      return true;
    } catch (\Exception $e) {
      $this->error = $e;
      return false;
    }
  }

  public function parseAndLoadToDb($pollId, $fileName = null)
  {
    if ($reader = new XMLReader()) {
      if ($fileName) {
        $name = \Yii::$app->params["uploadXml"] . $fileName;
      } else {
        $name = $this->xmlName;
      }
      if ($reader->open($name)) {
        $questionsCount = 0;
        $answersCount = 0;
        $transaction = Yii::$app->db->beginTransaction();
        while ($reader->read()) {
          if ($reader->nodeType == XMLReader::ELEMENT) {
            if ($reader->localName == "vopros") {
              $q = new Questions();
              $q->poll_id = $pollId;
              $q->title = $reader->getAttribute("text");
              $q->limit = $reader->getAttribute("limit");
              $q->input_type = $reader->getAttribute("type_id");
              $q->order = $reader->getAttribute("sort");
              if (!$q->save()) {
                $transaction->rollback();
                $this->error = "Error while saving question № " . $reader->getAttribute("order") . " in DB";
              }
              $questionsCount++;
            }
          }
          if ($reader->nodeType == XMLReader::ELEMENT) {
            if ($reader->localName == "otvet") {
              $a = new Answers();
              $a->poll_id = $pollId;
              $a->question_id = $q->id;
              $a->title = $reader->getAttribute("otvet_text");
              $a->code = $reader->getAttribute("otvet_cod");
              $a->order = $reader->getAttribute("otvet_sort");
              if (!$a->save()) {
                $transaction->rollback();
                $this->error = "Error while saving answer № " . $reader->getAttribute("order") . " / question № " .
                  $q->order;
              }
              $answersCount++;
            }
          }
        }
        $transaction->commit();
        $reader->close();
        $this->questionsCount = $questionsCount;
        $this->answersCount = $answersCount;
        return true;
      }
      $this->error = 'Could`t open xml file';
      return false;
    }
    return false;
  }

}