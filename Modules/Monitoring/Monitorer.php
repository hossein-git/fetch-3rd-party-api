<?php

namespace Modules\Monitoring;


use Illuminate\Support\Facades\Log;

abstract class Monitorer
{

    /**
     * @var mixed
     */
    protected $input_class;
    protected $channel = '';

    public function __construct($class)
    {
        $this->input_class = $class;
        $this->channel = config('monitoring.log_jobs_diver');
    }

    protected function getPreCall(string $method): void
    {
        $this->input_class->preCall($method, function ($methodName = '', $arguments = []) {
            $info = $this->makeView($methodName, $arguments);
            Log::channel($this->channel)->info($info);
        });
    }

    protected function makeView($methodName, $arguments, $result = null): string
    {
        return view('monitoring::sample')
            ->with(
                [
                    'class' => $this->input_class::class,
                    'methodName' => $methodName,
                    'arguments' => $arguments,
                    'result' => $result,
                ]
            )
            ->render();
    }

    protected function getPostCall(string $method): void
    {
        $this->input_class->postCall($method, function ($methodName = '', $arguments = [], $result = null) {
            //TODO mange big result
            $result = is_string($result) || is_int($result) ? $result : '--';
            $info = $this->makeView($methodName, $arguments, $result);
            Log::channel($this->channel)->info($info);
        });
    }
}
