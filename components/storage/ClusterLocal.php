<?php
/**
 * Storage
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010-2014 SkeekS (Sx)
 * @date 17.10.2014
 * @since 1.0.0
 */

namespace skeeks\cms\components\storage;

use Yii;

use \skeeks\sx\File;
use \skeeks\sx\Dir;

/**
 * Class Storage
 * @package common\components\Storage
 */
class ClusterLocal extends Cluster
{
    /**
     * @var bool
     */
    public $publicBaseUrlIsAbsolute = false;

    /**
     * Добавление файла в кластер
     *
     * @param File $tmpFile
     * @return string
     * @throws Exception
     */
    public function upload(File $tmpFile)
    {
        $clusterFileName     =  $this->_generateClusterFileName($tmpFile);

        $dir                =  $this->rootBasePath;
        $localPath          =  $this->getClusterDir($clusterFileName);

        $clusterFileSrc     = $clusterFileName;

        if ($localPath)
        {
            $clusterFileSrc = $localPath . DIRECTORY_SEPARATOR . $clusterFileSrc;
        }

        try
        {
            $dir = new Dir($dir . DIRECTORY_SEPARATOR . $localPath);
            $resultFile = $dir->newFile($clusterFileName);
            $tmpFile->move($resultFile);

        } catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }

        return $clusterFileSrc;
    }

    /**
     * Удаление файла
     *
     * @param $clusterFileSrc
     * @return bool
     * @throws Exception
     */
    public function delete($clusterFileUniqSrc)
    {
        $file = new File($this->getRootSrc($clusterFileUniqSrc));
        if ($file->isExist())
        {
            $file->remove();
        }

        return true;
    }


    /**
     * Удаление временной папки
     *
     * @param $clusterFileUniqSrc
     * @return bool|mixed
     */
    public function deleteTmpDir($clusterFileUniqSrc)
    {
        $dir = new Dir($this->rootTmpDir($clusterFileUniqSrc), false);
        if ($dir->isExist())
        {
            $dir->remove();
        }

        return true;
    }


    public function update($clusterFileUniqSrc, $file)
    {}

    /**
     * @param $clusterFileUniqSrc
     * @return string
     */
    public function getAbsoluteUrl($clusterFileUniqSrc)
    {
        if ($this->publicBaseUrlIsAbsolute)
        {
            return $this->getPublicSrc($clusterFileUniqSrc);
        } else
        {
            return \Yii::$app->request->hostInfo . $this->getPublicSrc($clusterFileUniqSrc);
        }
    }

    /**
     * Свободное место на сервере
     * @return float
     */
    public function getFreeSpace()
    {
        return (float) disk_free_space($this->rootBasePath);
    }

    /**
     * Всего столько места.
     * @return float
     */
    public function getTotalSpace()
    {
        return (float) disk_total_space($this->rootBasePath);
    }
}