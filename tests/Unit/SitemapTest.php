<?php

it('lists all pages', function () {
    expect($this)
        ->get('/sitemaps/en.xml')
        ->toHaveSelector('urlset', count: 1)
        ->toHaveSelector('url > loc', text: 'https://example.org')
    ;
});

it('references localizations', function () {
    $en = ['rel' => 'alternate', 'reflang' => 'en', 'href' => 'https://example.org'];
    $de = ['rel' => 'alternate', 'reflang' => 'de', 'href' => 'https://example.org/de'];

    expect($this)
        ->get('/sitemaps/en.xml')
        ->toHaveSelector('url > link', attributes: $en)
        ->toHaveSelector('url > link', attributes: $de)
    ;
});

it('ignores pages in other localizations', function () {
    expect($this)
        ->get('/sitemaps/en.xml')
        ->not()
        ->toHaveSelector('loc', text: 'https://example.org/de')
    ;
});

it('ignores error pages', function () {
    expect($this)
        ->get('/sitemaps/en.xml')
        ->not()
        ->toHaveSelector('loc', text: 'https://example.org/error')
    ;
});

it('ignores specified templates', function () {
    expect($this)
        ->withOption('tillprochaska.localized-sitemap.ignore-templates', ['ignore'])
        ->get('/sitemaps/en.xml')
        ->not()
        ->toHaveSelector('loc', text: 'https://example.org/ignore')
    ;
});
