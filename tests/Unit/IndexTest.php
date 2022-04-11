<?php

it('lists sitemaps for all localizations', function () {
    $index = $this->get('/sitemaps/index.xml');

    expect($index)->toHaveSelector('sitemapindex', count: 1);
    expect($index)->toHaveSelector('loc', count: 1, text: 'https://example.org/sitemaps/en.xml');
    expect($index)->toHaveSelector('loc', count: 1, text: 'https://example.org/sitemaps/de.xml');
});
