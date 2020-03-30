<?php

namespace Tests;

use App\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use PHPUnit\Framework\Assert;
use Illuminate\Testing\TestResponse;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setup();

        $this->withOutExceptionHandling();

        TestResponse::macro('props', function ($key = null) {
            $props = json_decode(json_encode($this->original->getData()['page']['props']), JSON_OBJECT_AS_ARRAY);

            if ($key) {
                return Arr::get($props, $key);
            }

            return $props;
        });

        TestResponse::macro('assertHasProp', function ($key) {
            Assert::assertTrue(Arr::has($this->props(), $key));

            return $this;
        });

        TestResponse::macro('assertPropValue', function ($key, $value) {
            $this->assertHasProp($key);

            if (is_callable($value)) {
                $value($this->props($key));
            } else {
                Assert::assertEquals($this->props($key), $value);
            }

            return $this;
        });

        TestResponse::macro('assertInertiaViewIs', function ($component) {
            $page = json_decode(json_encode($this->original->getData()['page']), JSON_OBJECT_AS_ARRAY);

            Assert::assertEquals($page['component'], $component);

            return $this;
        });
    }

    public function assertJsonFragment(array $haystack, array $needle)
    {
        $actual = json_encode(Arr::sortRecursive(
            (array) $haystack
        ));

        foreach (Arr::sortRecursive($needle) as $key => $value) {
            $expected = $this->jsonSearchStrings($key, $value);

            Assert::assertTrue(
                Str::contains($actual, $expected),
                'Unable to find JSON fragment: '.PHP_EOL.PHP_EOL.
                '['.json_encode([$key => $value]).']'.PHP_EOL.PHP_EOL.
                'within'.PHP_EOL.PHP_EOL.
                "[{$actual}]."
            );
        }

        return $this;
    }

    public function login($params = [])
    {
        $user = factory(User::class)->create($params);

        $this->actingAs($user);

        return $user;
    }

    protected function jsonSearchStrings($key, $value)
    {
        $needle = substr(json_encode([$key => $value]), 1, -1);

        return [
            $needle.']',
            $needle.'}',
            $needle.',',
        ];
    }
}
