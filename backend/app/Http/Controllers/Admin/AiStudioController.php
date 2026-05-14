<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AiStudioController extends Controller
{
    public static function pages(): array
    {
        return [
            'product' => ['Add/Edit Product With AI', 'Generate product titles, descriptions, specifications, labels, and SEO content with AI.'],
            'templates' => ['Prompt Templates', 'Manage reusable AI prompt templates for catalog, marketing, and support workflows.'],
            'usage' => ['Token Usage', 'Track AI token usage, estimated cost, and recent AI activity.'],
            'configuration' => ['AI Configuration', 'Configure model provider, API keys, model selection, and safety settings.'],
        ];
    }

    public function product() { return $this->render('product'); }
    public function templates() { return $this->render('templates'); }
    public function usage() { return $this->render('usage'); }
    public function configuration() { return $this->render('configuration'); }

    protected function render(string $page)
    {
        $pages = self::pages();
        abort_unless(isset($pages[$page]), 404);

        return view('admin.ai-studio.page', [
            'slug' => $page,
            'page' => $pages[$page],
            'pages' => $pages,
        ]);
    }
}
