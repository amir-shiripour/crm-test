<?php
namespace App\Services;

class AssetManager
{
    // Reads module's asset-manifest.json and returns HTML tags for styles/scripts
    public function renderStyles(string $moduleSlug)
    {
        $manifest = base_path('modules/' . ucfirst($moduleSlug) . '/asset-manifest.json');
        if (!file_exists($manifest)) return '';
        $json = json_decode(file_get_contents($manifest), true);
        $out = '';
        foreach (($json['css'] ?? []) as $css) {
            $out .= "<link rel=\"stylesheet\" href=\"/build/" . ltrim($css, '/') . "\">\n";
        }
        return $out;
    }

    public function renderScripts(string $moduleSlug)
    {
        $manifest = base_path('modules/' . ucfirst($moduleSlug) . '/asset-manifest.json');
        if (!file_exists($manifest)) return '';
        $json = json_decode(file_get_contents($manifest), true);
        $out = '';
        foreach (($json['js'] ?? []) as $js) {
            $out .= "<script type=\"module\" src=\"/build/" . ltrim($js, '/') . "\"></script>\n";
        }
        return $out;
    }
}
