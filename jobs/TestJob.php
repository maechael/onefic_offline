<?php

namespace app\jobs;

/**
 * Class TestJob.
 */
class TestJob extends \yii\base\BaseObject implements \yii\queue\RetryableJobInterface
{
    public $test;
    public $job;

    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
        $test2 = $this->test;
        $job2 = $this->job;
    }

    /**
     * @inheritdoc
     */
    public function getTtr()
    {
        return 60;
    }

    /**
     * @inheritdoc
     */
    public function canRetry($attempt, $error)
    {
        return $attempt < 3;
    }
}
