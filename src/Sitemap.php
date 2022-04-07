<?php

namespace TillProchaska\KirbyLocalizedSitemap;

use DOMDocument;
use Kirby\Cms\Page;

class Sitemap
{
    protected DOMDocument $xml;

    public function __construct(Page $root)
    {
        $this->xml = new DOMDocument(version: '1.0', encoding: 'utf-8');

        $this->urlset = $this->xml->createElement('urlset');
        $this->urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        $this->urlset->setAttribute('xmlns:xhtml', 'http://www.w3.org/1999/xhtml');

        $ignoreTemplates = kirby()->option('tillprochaska.localized-sitemap.ignore-templates', ['error']);
        $pages = $root->index()->filterBy(fn ($page) => !in_array($page->intendedTemplate()->name(), $ignoreTemplates));

        foreach ($pages as $page) {
            $this->addPage($page);
        }

        $this->xml->appendChild($this->urlset);
    }

    public function render(): string
    {
        return (string) $this->xml->saveXML();
    }

    public function addPage(Page $page): self
    {
        $url = $this->xml->createElement('url');

        $loc = $this->xml->createElement('loc', $page->url());
        $lastmod = $this->xml->createElement('lastmod', $page->modified('Y-m-d'));

        $url->appendChild($loc);
        $url->appendChild($lastmod);

        foreach ($page->localizations() as $localization) {
            $link = $this->xml->createElement('xhtml:link');

            $link->setAttribute('rel', 'alternate');
            $link->setAttribute('reflang', $localization->code());
            $link->setAttribute('href', $page->localized($localization)->url());

            $url->appendChild($link);
        }

        $this->urlset->appendChild($url);

        return $this;
    }
}
