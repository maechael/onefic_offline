<?php

namespace app\jobs;

/**
 * Class FicDataRetriever.
 */
class FicDataRetriever extends \yii\base\BaseObject implements \yii\queue\RetryableJobInterface
{
    public $url;

    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
    }

    /**
     * @inheritdoc
     */
    public function getTtr()
    {
        return 60 * 3;
    }

    /**
     * @inheritdoc
     */
    public function canRetry($attempt, $error)
    {
        return $attempt < 5;
    }
}
