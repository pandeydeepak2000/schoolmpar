<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate dynamic XML sitemap for search engines.
     */
    public function index(): Response
    {
        $schools = School::where('status', 'approved')
            ->where(function ($q) {
                $q->where('is_active', true)
                  ->orWhereNull('is_active')
                  ->orWhere('is_active', 1);
            })
            ->select('id', 'slug', 'updated_at', 'created_at')
            ->latest('updated_at')
            ->get();

        $staticPages = [
            [
                'url'        => route('home'),
                'lastmod'    => now()->toAtomString(),
                'changefreq' => 'daily',
                'priority'   => '1.0',
            ],
            [
                'url'        => route('school.compare.public'),
                'lastmod'    => now()->toAtomString(),
                'changefreq' => 'weekly',
                'priority'   => '0.8',
            ],
            [
                'url'        => route('pages.about'),
                'lastmod'    => now()->subDays(5)->toAtomString(),
                'changefreq' => 'monthly',
                'priority'   => '0.8',
            ],
            [
                'url'        => route('pages.contact'),
                'lastmod'    => now()->subDays(5)->toAtomString(),
                'changefreq' => 'monthly',
                'priority'   => '0.8',
            ],
            [
                'url'        => route('pages.faq'),
                'lastmod'    => now()->subDays(3)->toAtomString(),
                'changefreq' => 'weekly',
                'priority'   => '0.8',
            ],
            [
                'url'        => route('pages.privacy'),
                'lastmod'    => now()->subDays(30)->toAtomString(),
                'changefreq' => 'yearly',
                'priority'   => '0.5',
            ],
            [
                'url'        => route('pages.terms'),
                'lastmod'    => now()->subDays(30)->toAtomString(),
                'changefreq' => 'yearly',
                'priority'   => '0.5',
            ],
        ];

        $content = view('sitemap', [
            'staticPages' => $staticPages,
            'schools'     => $schools,
        ])->render();

        return response($content, 200)
            ->header('Content-Type', 'application/xml; charset=utf-8');
    }
}
