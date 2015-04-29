<?php
/**
 * AdminStorageController
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010-2014 SkeekS (Sx)
 * @date 29.01.2015
 * @since 1.0.0
 */
namespace skeeks\cms\controllers;

use skeeks\cms\models\searchs\Publication as PublicationSearch;
use skeeks\cms\models\StorageFile;
use skeeks\cms\modules\admin\controllers\AdminController;
use skeeks\cms\modules\admin\controllers\AdminModelEditorSmartController;
use skeeks\cms\modules\admin\controllers\AdminModelEditorController;
use Yii;
use skeeks\cms\models\User;
use skeeks\cms\models\searchs\User as UserSearch;

/**
 * Class AdminStorageFilesController
 * @package skeeks\cms\controllers
 */
class AdminStorageController extends AdminController
{
    public function init()
    {
        $this->_label                   = "Управление серверами";
        parent::init();
    }

    public function actionIndex()
    {
        $clusters = \Yii::$app->storage->getClusters();

        return $this->render($this->action->id);
    }

}
