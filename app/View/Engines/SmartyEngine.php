<?php

namespace App\View\Engines;

use Illuminate\View\Engines\EngineInterface;
use Smarty;

class SmartyEngine implements EngineInterface
{
    protected $smarty;

    public function __construct()
    {
        $this->smarty = new Smarty();
        $this->smarty->setTemplateDir(resource_path('views/smarty'));
        $this->smarty->setCompileDir(storage_path('framework/views/smarty'));
        $this->smarty->setCacheDir(storage_path('framework/cache/smarty'));
        $this->smarty->setConfigDir(storage_path('framework/config/smarty'));

        // Create directories if they don't exist
        @mkdir(storage_path('framework/views/smarty'), 0755, true);
        @mkdir(storage_path('framework/cache/smarty'), 0755, true);
        @mkdir(storage_path('framework/config/smarty'), 0755, true);
    }

    public function get($path, array $data = [])
    {
        // Assign all data to Smarty
        foreach ($data as $key => $value) {
            $this->smarty->assign($key, $value);
        }

        // Get the template file name
        $template = basename($path, '.smarty') . '.tpl';

        return $this->smarty->fetch($template);
    }

    public function getSmarty()
    {
        return $this->smarty;
    }
}
