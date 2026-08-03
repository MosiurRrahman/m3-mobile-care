<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate dynamic sitemap.xml for search engine indexing.
     */
    public function index(): Response
    {
        $urls = [
            [
                'loc' => url('/'),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'daily',
                'priority' => '1.0',
            ],
            [
                'loc' => route('book.form'),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.9',
            ],
            [
                'loc' => route('track.form'),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'daily',
                'priority' => '0.8',
            ],
        ];

        $content = view('sitemap', compact('urls'))->render();

        return response($content, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }
}
