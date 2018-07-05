<?php

namespace frontend\modules\finance\controllers;

use Yii;
use common\models\finance\Soa;
use common\models\finance\SoaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\finance\Billing;
use yii\data\ActiveDataProvider;
use yii2tech\spreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use frontend\modules\finance\components\models\SoaForm;

/**
 * BillingreceiptController implements the CRUD actions for BillingReceipt model.
 */
class SoaController extends Controller
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
     * Lists all BillingReceipt models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->redirect('manager');
    }
    /**
     * Lists all BillingReceipt models.
     * @return mixed
     */
    public function actionManager()
    {
        $searchModel = new BillingReceiptSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single BillingReceipt model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionGetbigrid(){
        $get= Yii::$app->request->get();
        $id=$get['id'];
        $query= Billing::find()->where(['customer_id'=>$id,'soa_number'=>NULL]);
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('_bigrid', ['dataProvider'=>$dataProvider]);
        }
        else{
            return $this->render('_bigrid', ['dataProvider'=>$dataProvider]);
        }
    }
    /**
     * Creates a new BillingReceipt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {      
        $model = new SoaForm();
        if ($model->load(Yii::$app->request->post()) && $model->save()){
            Yii::$app->session->setFlash('success', 'Statement of Account Successfully Created!');
            return $this->redirect('/finance/billing/soa');
        } else {
            $query= Billing::find()->where(['customer_id'=>-1,'soa_number'=>NULL]);
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
            $model->soa_date=date("Y-m-d");
            $model->user_id= Yii::$app->user->id;
            $model->soa_number="<autogenerated>";
            $model->previous_balance=0.00;
            $model->current_amount=0.00;
            if(Yii::$app->request->isAjax){
                return $this->renderAjax('create', [
                    'model' => $model,
                    'dataProvider'=>$dataProvider
                ]);
            }else{
                return $this->render('create', [
                    'model' => $model,
                    'dataProvider'=>$dataProvider
                ]);
            }
        }
    }

    /**
     * Updates an existing BillingReceipt model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->soa_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing BillingReceipt model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BillingReceipt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BillingReceipt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BillingReceipt::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
