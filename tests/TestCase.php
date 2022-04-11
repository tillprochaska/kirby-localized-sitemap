<?php

namespace TillProchaska\KirbyLocalizedSitemap\Tests;

use Kirby\Cms\App;
use TillProchaska\KirbyTestUtils\TestCase as BaseTestCase;

/**
 * @internal
 * @coversNothing
 */
class TestCase extends BaseTestCase
{
    protected function beforeKirbyInit(): void
    {
        // Register plugin
        if (null === App::plugin('tillprochaska/localized-sitemap-tests')) {
            App::plugin('tillprochaska/localized-sitemap-tests', [
                'pageModels' => [
                    'home' => TestPage::class,
                    'error' => TestPage::class,
                    'ignore' => TestPage::class,
                    'localized-site' => LocalizedSitePage::class,
                ],
            ]);
        }
    }

    protected function kirbyProps(): array
    {
        return [
            'roots' => [
                'index' => __DIR__.'/support/kirby',
            ],
            'urls' => [
                'index' => 'https://example.org',
            ],
        ];
    }
}
