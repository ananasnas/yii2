<?php

namespace app\controllers;

use Yii;
use app\models\Orders_consignments;
use app\models\Orders_consignmentsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Orders_consignmentsController implements the CRUD actions for Orders_consignments model.
 */
class Orders_consignmentsController extends Controller
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
     * Lists all Orders_consignments models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Orders_consignmentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Orders_consignments model.
     * @param integer $ID_orders_consignments
     * @param integer $Consignments_ID_consignment
     * @param integer $Orders_ID_order
     * @param integer $Products_ID_product
     * @return mixed
     */
    public function actionView($ID_orders_consignments, $Consignments_ID_consignment, $Orders_ID_order, $Products_ID_product)
    {
        return $this->render('view', [
            'model' => $this->findModel($ID_orders_consignments, $Consignments_ID_consignment, $Orders_ID_order, $Products_ID_product),
        ]);
    }

    /**
     * Creates a new Orders_consignments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Orders_consignments();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID_orders_consignments' => $model->ID_orders_consignments, 'Consignments_ID_consignment' => $model->Consignments_ID_consignment, 'Orders_ID_order' => $model->Orders_ID_order, 'Products_ID_product' => $model->Products_ID_product]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Orders_consignments model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $ID_orders_consignments
     * @param integer $Consignments_ID_consignment
     * @param integer $Orders_ID_order
     * @param integer $Products_ID_product
     * @return mixed
     */
    public function actionUpdate($ID_orders_consignments, $Consignments_ID_consignment, $Orders_ID_order, $Products_ID_product)
    {
        $model = $this->findModel($ID_orders_consignments, $Consignments_ID_consignment, $Orders_ID_order, $Products_ID_product);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID_orders_consignments' => $model->ID_orders_consignments, 'Consignments_ID_consignment' => $model->Consignments_ID_consignment, 'Orders_ID_order' => $model->Orders_ID_order, 'Products_ID_product' => $model->Products_ID_product]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Orders_consignments model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $ID_orders_consignments
     * @param integer $Consignments_ID_consignment
     * @param integer $Orders_ID_order
     * @param integer $Products_ID_product
     * @return mixed
     */
    public function actionDelete($ID_orders_consignments, $Consignments_ID_consignment, $Orders_ID_order, $Products_ID_product)
    {
        $this->findModel($ID_orders_consignments, $Consignments_ID_consignment, $Orders_ID_order, $Products_ID_product)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Orders_consignments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $ID_orders_consignments
     * @param integer $Consignments_ID_consignment
     * @param integer $Orders_ID_order
     * @param integer $Products_ID_product
     * @return Orders_consignments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID_orders_consignments, $Consignments_ID_consignment, $Orders_ID_order, $Products_ID_product)
    {
        if (($model = Orders_consignments::findOne(['ID_orders_consignments' => $ID_orders_consignments, 'Consignments_ID_consignment' => $Consignments_ID_consignment, 'Orders_ID_order' => $Orders_ID_order, 'Products_ID_product' => $Products_ID_product])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
