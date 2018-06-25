<?php

namespace app\controllers;

use Yii;
use app\models\Products;
use app\models\productsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new productsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
            if(Yii::$app->user->can('managementProducts')){
                $model = new Products();

                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    session('создание продукта');
                    return $this->redirect(['view', 'id' => $model->ID_product]);
                } else {
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }
            }
            else{
            throw new ForbiddenHttpException('Access denied');    
        }
    }

    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('managementProducts')){
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                     session('обновление продукта');
                return $this->redirect(['view', 'id' => $model->ID_product]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
        else{
            throw new ForbiddenHttpException('Access denied');    
        }
    }

    /**
     * Deletes an existing Products model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('managementProducts')){
            $id_ = $id;
           $product = Products::findOne($id_);
           $product->WasDel = '1';
           $product->save();   
           session('удаление продукта');
           return $this->redirect(Yii::$app->request->referrer);
        }
        else{
            throw new ForbiddenHttpException('Access denied');    
        }
    }

    /**
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionView($ID_product){
        $ID_product = Yii::$app->request->get('ID_product');        
        $product = products::find()->where(['ID_product' => $ID_product]) -> one();
        return $this->render('view', compact('product'));
    }
        public function actionAdd($ID_category){  
       if(Yii::$app->user->can('managementProducts')){
            $select_1 = products::find()->select(['unit'])->distinct()->asArray()->all();

            $array =[];
            foreach ($select_1 as $mas)
                {
                    foreach($mas as $el)
                    {
                        array_push($array, $el);
                    }
                }           

               $ID_category = Yii::$app->request->get('ID_category');    
               $product = new products();
               if($product->load(Yii::$app->request->post()))
               {  
                  $product->Categories_ID_category=$ID_category;
                  $product->unit=$array[$product->unit];   
                  $product->insert();
                  session('добавление продукта');
                  $this->refresh();
               }

            return $this->render('add', compact('product', 'ID_category'));
        }
        else{
            throw new ForbiddenHttpException('Access denied');    
        }
        }
}
