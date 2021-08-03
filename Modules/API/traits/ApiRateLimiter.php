<?php

namespace Modules\API\traits;


use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

trait ApiRateLimiter
{
    protected $key = 'api_http_requests';

    public function initialLimiting()
    {
        $this->increaseLimit();
        $this->lock();
    }

    protected function increaseLimit()
    {
        $this->limiter()->hit(
            $this->key,
            1 * 60
        );
    }

    protected function limiter()
    {
        return app(RateLimiter::class);
    }

    protected function lock()
    {
        if ($this->hasTooManyLoginAttempts()) {
            Log::warning('Too Many Request exceeded');
            sleep($this->sleepTime());
            //we can also throw exception here
//            throw new TooManyRequestsHttpException();
            $this->lock();
        }
    }

    protected function hasTooManyLoginAttempts()
    {
        return $this->limiter()->tooManyAttempts(
            $this->key,
            config('api_config.rate_limit')
        );
    }

    protected function sleepTime(): int
    {
        return config('api_config.sleep_time');
    }
}
