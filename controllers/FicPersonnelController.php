<?php

namespace app\controllers;

use Yii;
use app\models\ContactDetail;
use app\models\UserProfile;
use app\models\UserProfileSearch;
use app\models\Designation;
use app\models\Fic;
use app\models\Model;
use app\models\SignupForm;
use Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\bootstrap4\ActiveForm;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * FicPersonnelController implements the CRUD actions for UserProfile model.
 */
class FicPersonnelController extends Controller
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
        ];
    }

    /**
     * Lists all UserProfile models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserProfileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'affiliation' => new Fic(),
            'designation' => new Designation(),
            'model' => new SignupForm()
        ]);
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        $contacts = [new ContactDetail];

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $contacts = Model::createMultiple(ContactDetail::class);
                Model::loadMultiple($contacts, Yii::$app->request->post());

                // ajax validation
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ArrayHelper::merge(
                        ActiveForm::validateMultiple($contacts),
                        ActiveForm::validate($model)
                    );
                }

                // validate all models
                $valid = $model->validate();
                $valid = Model::validateMultiple($contacts) && $valid;

                if ($valid) {
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = $model->signup()) {
                            foreach ($contacts as $contact) {
                                $contact->user_profile_id = $model->_id;

                                if ($contact->isNewRecord && !($flag = $contact->save())) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }

                        if ($flag) {
                            $transaction->commit();
                            return $this->redirect(['index']);
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
            'contacts' => (empty($contacts)) ? [new ContactDetail] : $contacts,
            'fics' => Fic::getFics()
        ]);
    }

    public function actionUpdatePersonnel($id)
    {
        $oldContactIds = [];
        $profile = $this->findModel($id);
        $user = $profile->user;
        $contacts = $profile->contactDetails;

        if ($this->request->isPost) {
            if ($profile->load($this->request->post()) && $user->load($this->request->post())) {

                //Deletion of contact details
                // $user->userProfile->id = ArrayHelper::getColumn($profile->contactDetails, 'id');
                // $oldContactIds =  $user->userProfile->id;
                // $contactIds = ArrayHelper::getColumn($_POST['ContactDetail'], 'id');
                // $deletedContactIds = array_diff($oldContactIds, $contactIds);
                // if (!empty($deletedContactIds)) {
                //     ContactDetail::deleteAll(['id' => $deletedContactIds]);
                // }

                // foreach ($_POST['ContactDetail'] as $contactDetail) {
                //     $contactModel = new ContactDetail();
                //     $contactModel->contact_type = $contactDetail->contact_type;
                //     $contactModel->contact = $contactDetail->contact;
                //     $contactModel->save();
                // }

                // foreach ($newContactIds as $newContactId) {
                //     $contactDetail = new ContactDetail();
                //     $contactDetail->id = $newContactId;
                //     $contactDetail->save();
                // }

                $oldContactIds = ArrayHelper::getColumn($contacts, 'id');
                $contacts = Model::createMultiple(ContactDetail::class, $contacts);
                Model::loadMultiple($contacts, Yii::$app->request->post());
                $contacIds = ArrayHelper::getColumn($contacts, 'id');
                $deletedContactIds = array_diff($oldContactIds, $contacIds);
                if (!empty($deletedContactIds)) {
                    ContactDetail::deleteAll(['id' => $deletedContactIds]);
                }


                //   validate all models
                $valid = $profile->validate() && $user->validate();
                $valid = Model::validateMultiple($contacts) && $valid;

                if ($valid) {
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = $profile->save(false) && $user->save(false)) {
                            foreach ($contacts as $contact) {
                                $contact->user_profile_id = $profile->id;
                                if (!$flag = $contact->save(false))
                                    break;
                            }
                        }

                        if ($flag) {
                            $transaction->commit();
                            return $this->redirect(['index']);
                        } else {
                            $transaction->rollBack();
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                }
            }
        }

        return $this->render('update-personnel', [
            'profile' => $profile,
            'user' => $user,
            // 'model' => $model,
            'fics' => Fic::getFics(),
            'contacts' => (empty($contacts)) ? [new ContactDetail] : $contacts,
        ]);
    }

    /**
     * Displays a single UserProfile model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserProfile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SignupForm();


        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->signup()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }


        return $this->render('_create', [
            'model' => new SignupForm(),

        ]);
    }

    /**
     * Updates an existing UserProfile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserProfile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserProfile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return UserProfile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserProfile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
