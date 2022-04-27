<?php

namespace Base;

use App\Model\User;

/**
 * Class View
 * @package Base
 *
 */
class View
{

    private $templatePath = '';
    private $data = [];

    public function __construct()
    {
        $this->templatePath = PROJECT_ROOT_DIR . DIRECTORY_SEPARATOR . 'app/View';
    }

    public function assign(string $name, $value)
    {
        $this->data[$name] = $value;
    }

    public function render(string $tpl, $data = []): string
    {
        $this->data += $data;
        extract($this->data);
        $template_file = new \SplFileInfo($this->templatePath . DIRECTORY_SEPARATOR . $tpl);
        ob_start();
        if ($template_file->getExtension() == "twig") {

            $loader = new \Twig_Loader_Filesystem($this->templatePath . DIRECTORY_SEPARATOR);
            $twig = new \Twig_Environment($loader, array(
                'cache' => '_cache',
            ));
            echo $twig->render($tpl, $this->data);
        } else {
            include $this->templatePath . DIRECTORY_SEPARATOR . $tpl;
        }
        return ob_get_clean();
    }

    public function __get($varName)
    {
        return $this->data[$varName] ?? null;
    }

}
