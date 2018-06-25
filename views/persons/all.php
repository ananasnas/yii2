<?php
use yii\widgets\Menu;
use yii\grid\GridView;
use app\models\personsSearch;
use yii\widgets\Pjax;
use app\models\organizations;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Лица';   
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
        $url_=\yii\helpers\Url::to(['persons/create']);
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
    <?php if(Yii::$app->user->can('managementEmployees')):?> 
    <h1 style="text-align:center; margin-top:10px; margin-bottom: 30px;">Сотрудники</h1>
    <?php else:?>
    <h1 style="text-align:center; margin-top:10px; margin-bottom: 30px;">Контактные лица</h1>
    <?php endif;?>
<?php
$searchModel = new personsSearch();
$dataProvider = $searchModel->search(Yii::$app->request->get());
?>


<?php if(Yii::$app->user->can('managementEmployees')):?>
<?php Pjax::begin(['id'=>'pjax1', 'timeout' => false]); ?>  
<?= GridView::widget([
            'dataProvider' => $dataProvider,  
            'filterModel' => $searchModel,
          
       
            'id'=>'usong-grid',
            'tableOptions' => [
                'class' => 'table table-hover table-condensed table-bordered mytab_',
               ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'surname',
                'name',
                'middle_name',
              
                
                    [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                   
                    
                    'update' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::toRoute(['update','id' => $model->ID_person]), [
                                    'title' => Yii::t('yii', 'update'),
                                  
                                 'data-toggle' => 'modal',
              'data-pjax' => 'w0',   
              'data-target' => '#mymodal-win',
                              'onclick'  =>"$('#mymodel-win .modal-dialog .modal-content .modal-body').load($(this).attr('href'))"
                        
                                ]);
                        },
                
                'view' => function ($url, $model) {
          return Html::a(
            '<span class="glyphicon glyphicon-eye-open"></span>', 
            $url, [
              'data-toggle' => 'modal',
              'data-pjax' => 'w0',   
              'data-target' => '#mymodal-win',
              'onclick' => "$('#mymodel-win .modal-dialog .modal-content .modal-body').load($(this).attr('href'))",
            ]
          );
        },
                 'delete' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['delete','id' => $model->ID_person]), [
                                    'title' => Yii::t('yii', 'Delete'),
                                    'data-confirm' => Yii::t('yii', 'Вы уверены, что хотите удалить запись?'),
                                    'data-pjax' => 'w0',                          
                                ]);
                        }
                        ],
                        'template' => '{view} {update} {delete}',
                    ],
                            ],                               
        ]);
?>
<?php Pjax::end(); ?>
<?php else:?>
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

                'surname',
                'name',
                'middle_name',
                
                [
                    'attribute' => 'org',
                    'label' => 'Организация',
                    'value' => function($model) {
                             return $model->organizationsIDOrganization->name; //здесь по идее можно писать любой код для подготовки вывода данных в колонке
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
<?php endif;?>

</article>
