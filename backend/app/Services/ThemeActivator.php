<?php
namespace App\Services;

class ThemeActivator
{
    protected $moduleManager;

    public function __construct(ModuleManager $moduleManager)
    {
        $this->moduleManager = $moduleManager;
    }

    public function activate(array $themeMetadata)
    {
        if (!empty($themeMetadata['required_features'])) {
            foreach ($themeMetadata['required_features'] as $featureKey) {
                // map featureKey to module slug (simple mapping: feature_customer -> customer)
                $parts = explode('_', $featureKey);
                $moduleSlug = $parts[0] ?? $featureKey;
                $this->moduleManager->enable($moduleSlug);
                // set runtime feature flags in DB/cache in real app
            }
        }
        return true;
    }
}
