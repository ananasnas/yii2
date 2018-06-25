<?php
use yii\widgets\Menu;
use yii\helpers\Html;
use app\models\categories;
use app\models\consignments;
use yii\widgets\Pjax;
use app\models\ConsignmentsSearch;
use yii\grid\GridView;
use app\models\User;
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
$items;
$identity= new User();
if(!\Yii::$app->user->isGuest){
    $identity = Yii::$app->user->identity;  
}
$items = getMenu($identity);  

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
<?php if(!\Yii::$app->user->isGuest):?>    
    <div style="text-align: right; margin-right: 5px; color: dimgray;">
        <p style="margin-bottom: -4px;">Вы вошли под именем:</p>
        <?=$identity->surname;?>
        <?=$identity->name;?>
    </div>
<?php endif;?>
<?php \yii\widgets\Pjax::begin(); ?>
    
<p class="ss" style="margin:5% 0px 0px 10px; color: #5d5f5d; font-size:130%">  <?php if ($flag>1):?> <?= $breadcrumbs?> <?php endif;?></p>

<?php if(!empty($categories)):?>
<h1 style="margin-bottom: 20px;"><?= $category_->name?></h1>
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

    <?php if(\Yii::$app->user->can('managementProducts')):?>
        <div class="vvt panel pi">
            <?php 
            $url_=\yii\helpers\Url::to(['categories/create','ID_category' => $ID_category]);         
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
    <?php endif;?>

<h1 style="margin-bottom: 20px;"><?= $category_->name?></h1>
<?php
$searchModel = new \app\models\consignmentsSearch();
$dataProvider = $searchModel->search(Yii::$app->request->get());
?>

<?php \yii\widgets\Pjax::begin(); ?>

<?php 
try{
    $qt = app\models\auth_assignment::findOne(['user_id' => $identity->ID_person]);
$role = $qt->item_name;
} catch (Exception $ex) {

}
?>

<?php if(Yii::$app->user->can('viewProducts')):?>
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
                    'label' => 'Продукт',
                    'value' => function($model) {
                             return $model->productsIDProduct->name; //здесь по идее можно писать любой код для подготовки вывода данных в колонке
                    }
                ] ,
                             [
                  'label' => 'Цена',
                  'attribute' => 'shipping_price',
                ],
                    [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [                
                    
                    'add' => function ($url, $model) {
          return Html::a(
            '<span class="glyphicon glyphicon-plus"></span>', 
            $url, [
              'data-toggle' => 'modal',
              'data-target' => '#mymodal-win',
              'onclick' => "$('#mymodel-win .modal-dialog .modal-content .modal-body').load($(this).attr('href'))",
            ]
          );
        },
                        ],
                        'template' => '{add}',
                    ],
                            ],                               
        ]);
?>
<?php else:?>

<?php if((Yii::$app->user->isGuest) || (Yii::$app->user->can('viewProdCou')&&($role!='admin'))) :?>
<?php
$searchModel = new \app\models\consignmentsSearch();
$dataProvider = $searchModel->search(Yii::$app->request->get());
?>
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
                    'label' => 'Продукт',
                    'value' => function($model) {
                             return $model->productsIDProduct->name; //здесь по идее можно писать любой код для подготовки вывода данных в колонке
                    }
                ] ,
                             [
                  'label' => 'Цена',
                  'attribute' => 'shipping_price',
                ],
                 
                            ],                               
        ]);
?>
<?php else:?>
    <?php if(($role=='admin')):?>
        <?php
        $searchModel = new \app\models\productsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        ?>

        <?= GridView::widget([
                    'dataProvider' => $dataProvider, 
                    'filterModel' => $searchModel,
                    'id'=>'usong-grid',
                    'tableOptions' => [
                        'class' => 'table table-hover table-condensed table-bordered mytab_',
                       ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                            'name',
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

<?php endif;?>
    <?php if(Yii::$app->user->can('managementProducts') && ($role!='admin')):?>
        <?php
        $searchModel = new \app\models\productsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        ?>

        <?= GridView::widget([
                    'dataProvider' => $dataProvider, 
                    'filterModel' => $searchModel,
                    'id'=>'usong-grid',
                    'tableOptions' => [
                        'class' => 'table table-hover table-condensed table-bordered mytab_',
                       ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                            'name',
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

<?php endif;?>
<?php endif;?>
<?php endif;?>


<?php endif;?>
</article>
