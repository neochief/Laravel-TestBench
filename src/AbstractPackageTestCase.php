<?php

declare(strict_types=1);

/*
 * This file is part of Laravel TestBench.
 *
 * (c) Graham Campbell <hello@gjcampbell.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\TestBench;

use GrahamCampbell\TestBenchCore\HelperTrait;
use GrahamCampbell\TestBenchCore\LaravelTrait;
use GrahamCampbell\TestBenchCore\MockeryTrait;
use Orchestra\Testbench\TestCase;

/**
 * This is the abstract package test case class.
 *
 * @author Graham Campbell <hello@gjcampbell.co.uk>
 */
abstract class AbstractPackageTestCase extends TestCase
{
    use HelperTrait;
    use LaravelTrait;
    use MockeryTrait;

    /**
     * Setup the application environment.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app): void
    {
        $app->config->set('app.key', 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA');

        $app->config->set('cache.driver', 'array');

        $app->config->set('database.default', 'sqlite');
        $app->config->set('database.connections.sqlite', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        $app->config->set('mail.driver', 'log');

        $app->config->set('session.driver', 'array');
    }

    /**
     * Get the package service providers.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return string[]
     */
    protected function getPackageProviders($app): array
    {
        $provider = static::getServiceProviderClass($app);

        if ($provider) {
            return array_merge(static::getRequiredServiceProviders(), [$provider]);
        }

        return static::getRequiredServiceProviders($app);
    }

    /**
     * Get the required service providers.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return string[]
     */
    protected static function getRequiredServiceProviders($app): array
    {
        return [];
    }

    /**
     * Get the service provider class.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return string
     */
    protected static function getServiceProviderClass($app): string
    {
        // This may be overwritten, and must be overwritten
        // if used with the service provider test case trait.
        return '';
    }
}
