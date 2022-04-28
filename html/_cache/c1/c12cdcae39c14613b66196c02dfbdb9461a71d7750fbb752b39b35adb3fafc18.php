<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* Layouts/header.twig */
class __TwigTemplate_8c3bcdccb02c28ecac65e266ded699f6e77938f4b4b04ce60cf85fe36ccda161 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <link rel=\"stylesheet\" type=\"text/css\" href=\"/html/css/main.css\">
        <link rel=\"stylesheet\" type=\"text/css\" href=\"/html/css/font-awesome.min.css\">
        <meta charset=\"UTF-8\">
        <title></title>
    </head>";
    }

    public function getTemplateName()
    {
        return "Layouts/header.twig";
    }

    public function getDebugInfo()
    {
        return array (  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "Layouts/header.twig", "/var/www/php.529252.ru/www/app/View/Layouts/header.twig");
    }
}
