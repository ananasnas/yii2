<?php
use yii\widgets\Menu;
use yii\grid\GridView;
use app\models\consignments;
use app\models\consignmentsSearch;
use yii\widgets\Pjax;
use yii\helpers\Html;
    
$this->title = 'Партии';   
?>
<div id='header'>   
        <header>        
	<div class="sh"></div>
	<div class="sh1"></div>
	<div class="sh"></div>
        <nav class="menu" style="font-size: 12pt;">                
                 
<?php
$items;

if(!\Yii::$app->user->isGuest){
    $identity = Yii::$app->user->identity;
    $items = getMenu($identity);  
}

echo Menu::widget([
    'items' => $items,
    'options' => [
    ],   
    'itemOptions' => [    
        'tag' => false
    ]
]);
?>         
            </nav> 
        </header>			
</div>
<article class="content">
    
    <div style="text-align: right; margin-right: 5px; color: dimgray;">
        <p style="margin-bottom: -4px;">Вы вошли под именем:</p>
        <?=$identity->surname;?>
        <?=$identity->name;?>
    </div>
    

    <div class="vvt panel pi">
        <?php 
        $url_=\yii\helpers\Url::to(['consignments/create']);
        ?>
        <?=Html::a(
            '<button class="btn btn-lg btn-block">Добавить</button>', 
            $url_, [
              'data-toggle' => 'modal',
              'data-target' => '#mymodal-win',
              'onclick' => "$('#mymodel-win .modal-dialog .modal-content .modal-body').load($(this).attr('href'))",
              'style' => 'text-decoration: none;',
            ]
          );?>
    </div> 

<h1 style="text-align:center; margin-top:10px; margin-bottom: 30px;">Партии</h1>

<?php
$searchModel = new consignmentsSearch();
$dataProvider = $searchModel->search(Yii::$app->request->get());
?>
<?php Pjax::begin(); ?>
<?= GridView::widget([
            'dataProvider' => $dataProvider,  
            'filterModel' => $searchModel,
            'id'=>'usong-grid',
            'tableOptions' => [
                'class' => 'table table-hover table-condensed table-bordered mytab_',
               ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                  'label' => 'Годен до:',
                  'attribute' => 'storage_life',
                ],
                
                [
                  'label' => 'Цена продажи',
                  'attribute' => 'shipping_price',
                ],
                
                [
                    'attribute' => 'productName',
                    'label' => 'Продукт',
                    'value' => function($model) {
                             return $model->productsIDProduct->name; //здесь по идее можно писать любой код для подготовки вывода данных в колонке
                    }
                ] ,
                
                    [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                   
                    
                    'update' => function ($url, $model) {
          return Html::a(
            '<span class="glyphicon glyphicon-pencil"></span>', 
            $url, [
              'data-toggle' => 'modal',
              'data-target' => '#mymodal-win',
              'onclick' => "$('#mymodel-win .modal-dialog .modal-content .modal-body').load($(this).attr('href'))",
            ]
          );
        },
                'view' => function ($url, $model) {
          return Html::a(
            '<span class="glyphicon glyphicon-eye-open"></span>', 
            $url, [
              'data-toggle' => 'modal',
              'data-target' => '#mymodal-win',
              'onclick' => "$('#mymodel-win .modal-dialog .modal-content .modal-body').load($(this).attr('href'))",
            ]
          );
        },
                        ],
                        'template' => '{view} {update} {delete}',
                    ],
                            ],                               
        ]);
?>

<?php Pjax::end(); ?>
</article>
