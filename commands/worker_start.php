<?php

use App\Services\JobSeeker;
use React\EventLoop\Loop;
use React\EventLoop\TimerInterface;

$loop = Loop::get();

$loop->addPeriodicTimer(0.2, function (TimerInterface $timer) use ($loop) {
    $jobSeeker = new JobSeeker();

    /** in case you want to not stop the worker */
    //$jobSeeker->seek();
    //$jobSeeker->run();

    if ($jobSeeker->seek()) {
        $jobSeeker->run();
        echo 'job is running...';
        echo PHP_EOL;
    } else {
        $loop->cancelTimer($timer);
        echo 'job running ends!';
        echo PHP_EOL;
    }
});

$loop->run();