<?php
use yii\widgets\Menu;
use yii\helpers\Html;
use app\models\categories;
use app\models\consignments;
use yii\widgets\Pjax;
use app\models\ConsignmentsSearch;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

?>
<div id='header'>
<header>        
<div class="sh"></div>
<div class="sh1"></div>
<div class="sh"></div>
<nav class="menu" style="font-size: 12pt;">    
        <?php 
        $category_ = categories::find()->where(['ID_category' => $ID_category])->one();
        $this->title = $category_->name;
        $categories_s = categories::find()->indexBy('ID_category')->asArray()->all();

        if (isset($_GET['ID_category'])){
            $id = (int)$_GET['ID_category'];
            // крошки
            $breadcrumbs_array = breadcrumbs_($categories_s,$id);
            $breadcrumbs='';
            $flag = 0;
            if($breadcrumbs_array){
                foreach ($breadcrumbs_array as $id => $name)
                {
                    $breadcrumbs .= "<a style='color:black;' href='/categories/all/{$id}'>{$name}</a> / ";
                    $flag++;
                }
                $breadcrumbs = rtrim($breadcrumbs, " / ");
                $breadcrumbs = preg_replace("#(.+)?<a.+>(.+)</a>$#", "$1$2", $breadcrumbs);
            }
        }
        ?>            
        <?php
            $id_group = 20;        
            try{
                $identity = Yii::$app->user->identity;
                $id_group = $identity->Groups_ID_group;
                }
              catch (Exception $e){       
            }
        $items = getItems($id_group);
        echo Menu::widget([
            'items' => $items,
            'options' => [
            ],   
            'itemOptions' => [    
                'tag' => false
            ]
        ]);?>      
    </nav> 
</header>			
</div>
<article class="content">
<?php \yii\widgets\Pjax::begin(); ?>
<p class="ss" style="margin:5% 0px 0px 10px; color: #5d5f5d; font-size:130%">  <?php if ($flag>1):?> <?= $breadcrumbs?> <?php endif;?></p>
<h1 style="margin-bottom: 20px;"><?= $category_->name?></h1>
<?php if(!empty($categories)):?>
<div class="container" style="text-align: center;">
        <div class="row">
            <?php foreach ($categories as $category):?>
            <div class ="col-md-3" >           
                    <a href="<?=\yii\helpers\Url::to(['categories/all', 'ID_category' => $category['ID_category']])?>">	
                        <?=Html::img("@web/images/{$category->img}",
                                ['alt'=> $category->name, 'title' => "Открыть категорию"])?>
                            <h3 style="font-family: Times New Roman; font-size: 14pt; margin-bottom: 30px;"><?= $category->name?></h3>
                    </a>           
            </div>
            <?php endforeach;?>
        </div>
</div>
<?php \yii\widgets\Pjax::end(); ?>
<?php else :?>
 
<?php if (Yii::$app->user->can('controlProducts')):?>
    <div class="vvt panel pi">
      <a href="<?=\yii\helpers\Url::to(['products/add' , 'ID_category' => $ID_category])?>"><button style="width:230px">Добавить продукт</button></a>
    </div>
<?php endif;?>

<?php
$searchModel = new ConsignmentsSearch();
$dataProvider = $searchModel->search(Yii::$app->request->get());
?>
<?php \yii\widgets\Pjax::begin(); ?>
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
                        'attribute' => 'productName',
                        'value' => function($model) {
                             return $model->productsIDProduct->name; //здесь по идее можно писать любой код для подготовки вывода данных в колонке
                        }
                    ] ,
                          
                    'shipping_price',
                    [
                        'attribute' => 'storage_life',
                        'format' =>['date', 'php:Y-m-d'],
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
<?php \yii\widgets\Pjax::end(); ?>
<?php endif;?>
</article>

<?php $this->registerJs("

$('#mymodal-win').on('hidden.bs.modal', function (event) { 
location.reload(true);
});

");
?>