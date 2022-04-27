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

/* Layouts/footer.twig */
class __TwigTemplate_5e774d583c77de7aa491880c428a906aae1c1242e1235db659ff30b420338222 extends \Twig\Template
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
        echo "<script>
    function validateForm() {
        var pass = document.forms[\"reg_form\"][\"password\"].value;
        var pass_ = document.forms[\"reg_form\"][\"password_\"].value;
        if (pass !== pass_) {
            alert(\"Пароли не совпадают\");
            return false;
        }
        document.getElementById('spinner').style.display = '';
        document.getElementById('button_change').disabled = true;

    }
</script>";
    }

    public function getTemplateName()
    {
        return "Layouts/footer.twig";
    }

    public function getDebugInfo()
    {
        return array (  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "Layouts/footer.twig", "/var/www/php.529252.ru/www/app/View/Layouts/footer.twig");
    }
}
