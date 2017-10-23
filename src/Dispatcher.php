<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 23/10/2017
 * Time: 15:06
 */

namespace Com\NickelIT\UniqueableJobs;


use Illuminate\Queue\DatabaseQueue;
use Illuminate\Queue\QueueManager;

class Dispatcher extends \Illuminate\Bus\Dispatcher
{
    /**
     * @param mixed $command
     * @return bool
     */
    public function isUniqueable($command)
    {
        $job_clazz = get_class($command);
        $clazz = new \ReflectionClass($job_clazz);
        return in_array(Uniqueable::class, $clazz->getTraitNames()) || $clazz->hasMethod('unique');
    }

    /**
     * @param mixed $command
     * @return mixed
     */
    public function dispatch($command)
    {
        /** @var QueueManager $v */
        $v = app('queue');
        if ($v->connection() instanceof DatabaseQueue && $this->isUniqueable($command)) {
            if ($command->unique_apply) {
                if (\DB::table('jobs')->where('model_clazz', '=', $command->unique_clazz)
                        ->where('model_id', '=', $command->unique_id)
                        ->where('job_clazz', '=', get_class($command))
                        ->count() > 0) {
                    return;
                }
            }
        }

        return parent::dispatch($command);
    }
}