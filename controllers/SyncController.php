<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\Media;
use app\models\Part;
use Database\Connection;
use Database\Query\Grammars\Grammar;
use Database\Query\Grammars\MySqlGrammar;
use DbSync\ColumnConfiguration;
use DbSync\DbSync;
use DbSync\Hash\Md5Hash;
use DbSync\Hash\ShaHash;
use DbSync\Table;
use DbSync\Transfer\Transfer;
use Exception;
use PDO;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\httpclient\Client;

class SyncController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index', [
            'sync_map' => Yii::$app->params['sync_map'],
        ]);
    }

    public function actionInit()
    {
        return $this->render('init', [
            'syncMap' => Yii::$app->params['sync_map'],
        ]);
    }

    public function actionSyncAll()
    {
        if (Yii::$app->request->isAjax) {
            try {
                // to be continued
                return $this->asJson(['success' => true]);
            } catch (Exception $e) {
                return $this->asJson(['success' => false, 'message' => $e->getMessage()]);
            }
        }
    }

    public function actionSyncTable()
    {
        if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {
            $source = $_POST['source'];
            $target = $_POST['target'];

            try {
                $this->sync($source, $target);
                return $this->asJson(['success' => true]);
            } catch (Exception $e) {
                return $this->asJson(['success' => false, 'message' => $e->getMessage()]);
            }
        }
        return $this->redirect('index');
    }

    public function actionLocationSync()
    {
        if (Yii::$app->request->isAjax) {
            try {
                $this->locationSync();
                return $this->asJson(['success' => true]);
            } catch (Exception $e) {
                return $this->asJson(['success' => false, 'message' => $e->getMessage()]);
            }
        }
        return $this->redirect('index');
    }

    public function actionFicSync()
    {
        if (Yii::$app->request->isAjax) {
            try {
                $this->ficSync();
                return $this->asJson(['success' => true]);
            } catch (Exception $e) {
                return $this->asJson(['success' => false, 'message' => $e->getMessage()]);
            }
        }
        return $this->redirect('index');
    }

    public function actionMediaSync()
    {
        if (Yii::$app->request->isAjax) {
            try {
                $this->mediaSync();
                $medias = Media::find()->select(['filepath'])->all();
                //..iterate thru medias
                foreach ($medias as $media) {
                    //..check file if exists
                    //..download if not exists
                    if (!file_exists($media->filepath)) {
                        $sourceUrl = Url::to('@server') . '/' . $media->filepath;
                        if (!is_dir(dirname($media->filepath)))
                            FileHelper::createDirectory(dirname($media->filepath));
                        copy($sourceUrl, $media->filepath);
                    }
                }

                return $this->asJson(['success' => true]);
            } catch (Exception $e) {
                return $this->asJson(['success' => false, 'message' => $e->getMessage()]);
            }
        }
        return $this->redirect('index');
    }

    public function actionSubEquipmentSync()
    {
        if (Yii::$app->request->isAjax) {
            try {
                $this->subEquipmentSync();
                return $this->asJson(['success' => true]);
            } catch (Exception $e) {
                return $this->asJson(['success' => false, 'message' => $e->getMessage()]);
            }
        }
        return $this->redirect('index');
    }

    public function actionSupplierSync()
    {
        if (Yii::$app->request->isAjax) {
            try {
                $this->supplierSync();
                return $this->asJson(['success' => true]);
            } catch (Exception $e) {
                return $this->asJson(['success' => false, 'message' => $e->getMessage()]);
            }
        }
        return $this->redirect('index');
    }

    public function actionEquipmentSync()
    {
        if (Yii::$app->request->isAjax) {
            try {
                $this->equipmentSync();
                return $this->asJson(['success' => true]);
            } catch (Exception $e) {
                return $this->asJson(['success' => false, 'message' => $e->getMessage()]);
            }
        }
        return $this->redirect('index');
    }

    protected function locationSync()
    {
        try {
            $this->sync('region', 'region');
            $this->sync('province', 'province');
            $this->sync('municipality_city', 'municipality_city');
        } catch (Exception $e) {
            throw $e;
        }
    }

    protected function ficSync()
    {
        try {
            $this->sync('fic', 'fic');
            $this->sync('facility', 'facility');
            $this->sync('service', 'service');
        } catch (Exception $e) {
            throw $e;
        }
    }

    protected function mediaSync()
    {
        try {
            $this->sync('metadata', 'media');
        } catch (Exception $e) {
            throw $e;
        }
    }

    protected function subEquipmentSync()
    {
        try {
            $this->sync('equipment_type', 'equipment_type');
            $this->sync('equipment_category', 'equipment_category');
            $this->sync('processing_capability', 'processing_capability');
            $this->sync('component', 'component');
            $this->sync('part', 'part');
            $this->sync('spec_key', 'spec_key');
        } catch (Exception $e) {
            throw $e;
        }
    }

    protected function supplierSync()
    {
        try {
            $this->sync('supplier', 'supplier');
            $this->sync('branch', 'branch');
        } catch (Exception $e) {
            throw $e;
        }
    }

    protected function equipmentSync()
    {
        try {
            $this->sync('equipment', 'equipment');
            $this->sync('equipment_component', 'equipment_component');
            $this->sync('equipment_component_part', 'equipment_component_part');
            $this->sync('equipment_spec', 'equipment_spec');
        } catch (Exception $e) {
            throw $e;
        }
    }

    protected function sync($sourceTbl, $targetTbl)
    {
        $blockSize = Yii::$app->params['syncBlockSize'];
        $transferSize = Yii::$app->params['syncTransferSize'];

        $sourceDsn = Yii::$app->params['onlineDsn'];
        $sourceDb = Yii::$app->params['onlineDb'];
        $sourceUser = Yii::$app->params['onlineUser'];
        $sourcePassword = Yii::$app->params['onlinePassword'];

        $targetDsn = Yii::$app->params['localDsn'];
        $targetDb = Yii::$app->params['localDb'];
        $targetUser = Yii::$app->params['localUser'];
        $targetPassword = Yii::$app->params['localPassword'];

        $sync = new DbSync(new Transfer(new Md5Hash(), $blockSize, $transferSize));
        $sync->dryRun(false);
        $sync->delete(true);

        $sourceTable = $this->setTable($sourceDb, $sourceTbl, $sourceDsn, $sourceUser, $sourcePassword);
        $targetTable = $this->setTable($targetDb, $targetTbl, $targetDsn, $targetUser, $targetPassword);

        return $sync->sync($sourceTable, $targetTable);
    }

    private function setTable($dbName, $tableName, $dsn, $user = 'root', $password = '')
    {
        $sourceConnection = new Connection(new PDO($dsn, $user, $password), new MySqlGrammar());
        return new Table($sourceConnection, $dbName, $tableName);
    }
}
