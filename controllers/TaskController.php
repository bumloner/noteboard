<?php

namespace app\controllers;

use Yii;
use app\models\Task;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{
    /**
     * {@inheritdoc}
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
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => false,
                        'roles' => ['?'],
                        'denyCallback' => function($rule, $action) {
                            return $this->redirect(Url::toRoute(['/site/login']));
                        }
                    ],
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->redirect(['/']);
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->redirect(['update', 'id' => $id]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($note_id)
    {
        $model = new Task();

        /** получаем данные о заметке, которой принадлежит задача
         *
         * Примечание: здесь не используется User::isOwnerOfTask(),
         *  т.к. данные о заметке используются в текущем методе
         */
        if (($note = \app\models\Note::findOne($note_id)) === null) {
            throw new NotFoundHttpException('Note of task not found.');
        }

        // проверка, принадлежит ли заметка текущему пользователю
        if (Yii::$app->user->getIdentity()->isOwnerOfNote($note)) {
            $model->note_id = $note_id;
        } else {
            throw new ForbiddenHttpException('You cannot create task for this note.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/']);
        }

        return $this->render('create', [
            'model' => $model,
            'note_name' => $note['name'],
        ]);
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/']);
        }

        // получаем данные о заметке, которой принадлежит текущая задача
        if (($note = \app\models\Note::findOne($model->note_id)) === null) {
            throw new NotFoundHttpException('Note of task not found.');
        }

        return $this->render('update', [
            'model' => $model,
            'note_name' => $note['name'],
        ]);
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            // проверка, принадлежит ли задача текущему пользователю
            if (Yii::$app->user->getIdentity()->isOwnerOfTask($model)) {
                return $model;
            }
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
