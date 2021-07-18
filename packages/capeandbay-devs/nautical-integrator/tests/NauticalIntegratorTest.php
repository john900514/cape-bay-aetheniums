<?php

namespace CapeandbayDevs\NauticalIntegrator\Tests;

use CapeandbayDevs\NauticalIntegrator\Facades\NauticalIntegrator;
use CapeandbayDevs\NauticalIntegrator\ServiceProvider;
use Orchestra\Testbench\TestCase;

class NauticalIntegratorTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'nautical-integrator' => NauticalIntegrator::class,
        ];
    }

    public function testExample()
    {
        $this->assertEquals(1, 1);
    }
}
