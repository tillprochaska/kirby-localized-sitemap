<?php

namespace TillProchaska\KirbyLocalizedSitemap;

use DOMDocument;
use Kirby\Cms\Site;
use TillProchaska\KirbyLocalizations\Localization;

class Index
{
    protected Site $site;
    protected DOMDocument $xml;

    public function __construct(Site $site)
    {
        $this->site = $site;
        $this->xml = new DOMDocument(version: '1.0', encoding: 'utf-8');

        $this->index = $this->xml->createElement('sitemapindex');
        $this->index->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        $this->xml->appendChild($this->index);

        foreach ($this->site->localizations() as $localization) {
            $this->addLocalization($localization);
        }
    }

    public function render(): string
    {
        return (string) $this->xml->saveXML();
    }

    public function addLocalization(Localization $localization): self
    {
        $url = kirby()->url('index').'/sitemaps/'.$localization->code().'.xml';

        $sitemap = $this->xml->createElement('sitemap');
        $loc = $this->xml->createElement('loc', $url);
        $sitemap->appendChild($loc);

        $this->index->appendChild($sitemap);

        return $this;
    }
}
