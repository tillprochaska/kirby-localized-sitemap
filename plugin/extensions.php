<?php

use Kirby\Http\Response;
use TillProchaska\KirbyLocalizedSitemap\Sitemap;
use TillProchaska\KirbyLocalizedSitemap\Index;

return [
    'routes' => [
        [
            'pattern' => '/sitemaps/index.xml',
            'action' => function () {
                $index = new Index(site());
                return new Response($index->render(), 'application/xml');
            },
        ],
        [
            'pattern' => '/sitemaps/(:all).xml',
            'action' => function ($code): Response {
                $localization = site()->localizations()->find($code);

                if (! $localization) {
                    return site()->localized()->errorPage();
                }

                $localizedSite = site()->localized($localization);
                $sitemap = new Sitemap($localizedSite);

                return new Response($sitemap->render(), 'application/xml');
            },
        ],
    ],
];
