<?php

namespace app\modules\polls\models;

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

  public function rules()
  {
    return [
      [['xmlFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xml'],
    ];
  }

  public function attributeLabels()
  {
    return [
      "xmlFile" => "Загрузить XML файл:"
    ];
  }

  /*
    public function upload($name)
    {
      if ($this->validate()) {
        $xml = $this->xmlFile[0];
        $this->xmlName = \Yii::$app->params['uploadXml'] . $name . '.' . $xml->extension;
        return $xml->saveAs($this->xmlName, false);
      } else {
        return $this->getErrors();
      }
    }
  */

  public function upload($name)
  {
    $xml = $this->xmlFile[0];
    $this->xmlName = \Yii::$app->params['uploadXml'] . $name;
    return $xml->saveAs($this->xmlName, false);
  }

  public function parseAndLoadToDb()
  {
    if ($reader = new XMLReader()) {
      $reader->open($this->xmlName);
//      $reader->setParserProperty(XMLReader::VALIDATE, true);
//      return var_dump($reader->isValid());
      $questionData = array();
      $answerData = array();
      $count = 0;
      while ($reader->read()) {
        if ($reader->nodeType == XMLReader::ELEMENT) {
          if ($reader->localName == 'vopros') {
            $questionData[$count]['number'] = $reader->getAttribute('id');
            $questionData[$count]['limit'] = $reader->getAttribute('limit');
            $questionData[$count]['type_id'] = $reader->getAttribute('type_id');
            $reader->read();
            if ($reader->nodeType == XMLReader::ELEMENT) {
              if ($reader->localName == 'otvet') {
                $answerData[$count]['code'] = $reader->getAttribute('otvet_cod');
              }
            }
          }
        }
        $count++;
      }
      return $answerData;
    }
    $reader->close();
  }

}