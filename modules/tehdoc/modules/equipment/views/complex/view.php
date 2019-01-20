<?php
use yii\helpers\Html;
//use yii\widgets\DetailView;
use yii\widgets\DetailView;

$this->title = $modelComplex->complex_title;
$this->params['breadcrumbs'][] = ['label' => 'Тех.документация', 'url' => ['/tehdoc']];
$this->params['breadcrumbs'][] = ['label' => 'Комплекты', 'url' => ['/tehdoc/equipment/complex']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tool-view">

  <h3><?= Html::encode($this->title) ?></h3>

  <p>
    <?= Html::a('Изменить', ['update', 'id' => $modelComplex->id], ['class' => 'btn btn-primary btn-sm']) ?>
    <?= Html::a('Удалить', ['delete', 'id' => $modelComplex->id], [
      'class' => 'btn btn-danger btn-sm',
      'data' => [
        'confirm' => 'Вы уверены, что хотите удалить объект?',
        'method' => 'post',
      ],
    ]) ?>
  </p>


  <?= DetailView::widget([
    'model' => $modelComplex,
    'attributes' => [
      'id',
      'complex_title',
      [
        'label' => 'Категория',
        'value' => $modelComplex->category ? $modelComplex->category->name : '-',
      ],
      'complex_serial',
      'complex_manufact',
      'complex_model',
      [
        'label' => 'Дата производства:',
        'format' => 'raw',
        'value' => function($data){
          if ($data->complex_factdate != null) {
            return date('jS M y', strtotime($data->complex_factdate));
          } else {
            return '-';
          }
        }
      ],

    ],
  ]) ?>

  <?php
  if (!empty($modelsTool)) {
    echo '<div class="tool-view">';
    echo '<h2>В состав Комплекта входят:</h2>';
    foreach ($modelsTool as $modelTool) {
      echo '<div class="container-fluid col-lg-6 col-md-6">';
      echo DetailView::widget([
        'model' => $modelTool,
        'attributes' => [
          "eq_title",
          [
            'label' => 'Категория:',
            'value' => $modelTool->categoryTitle,
          ],
          "eq_manufact",
          "eq_model",
          "eq_serial",
          [
            'label' => 'Дата производства:',
            'format' => 'raw',
            'value' => function($data){
              if ($data->eq_factdate != null) {
                return date('jS M y', strtotime($data->eq_factdate));
              } else {
                return '-';
              }
            }
          ],
          [
            'label' => 'Место размещения:',
            'value' => $modelTool->placementTitle,
          ],
          [
            'label' => 'Изображения:',
            'format' => 'raw',
            'value' => $modelTool->photos ? '<a href="#" style="color: #3f51b5">' . count($modelTool->photos) . ' штук(и)' . '</a>' : 'отсутствуют',
          ]
        ],
      ]);
      echo '</div>';
      echo '<div class="w3-col m5 l5 container w3-center">';
      if ($photos = $modelTool->photos) {
        $ph = null;
        foreach ($photos as $photo) {
          $ph[] = ['img' => $photo->getImageUrl()];
        }
      }
      echo '<hr>';
      echo '</div>';
    }
    echo '</div>';
  }
  ?>
</div>