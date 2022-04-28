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

/* User/_register.twig */
class __TwigTemplate_2ed67d87fb0e12dd03f6a6734515b5a72714d69345130b586a0f51a8ef113b6a extends \Twig\Template
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
        $this->loadTemplate("Layouts/header.twig", "User/_register.twig", 1)->display($context);
        echo "  
<body>
    <div class=\"registration-cssave\">
        <form action=\"";
        // line 4
        echo ((($context["isRegister"] ?? null)) ? ("/user/register") : ("/user/login"));
        echo " \" method=\"post\" name=\"reg_form\" onsubmit=\"return validateForm()\" >
            <div class=\"registration-title\">
                <div class=\"title-div\">
                    <h3 class=\"text-center\">
                        ";
        // line 8
        if (($context["isRegister"] ?? null)) {
            // line 9
            echo "                            <a href=\"/user/login\">Вход</a>
                        ";
        } else {
            // line 11
            echo "                            Вход
                        ";
        }
        // line 13
        echo "                    </h3>
                </div>
                <div class=\"title-div\">
                    <h3 class=\"text-center\">
                        ";
        // line 17
        if (($context["isRegister"] ?? null)) {
            // line 18
            echo "                            Регистрация
                        ";
        } else {
            // line 20
            echo "                            <a href=\"/user/register\">Регистрация</a>
                        ";
        }
        // line 22
        echo "                    </h3>
                </div>
            </div>
            ";
        // line 25
        if (($context["isRegister"] ?? null)) {
            // line 26
            echo "                <div class=\"form-group\">
                    <input class=\"form-control item\" type=\"text\" name=\"name\" maxlength=\"15\" minlength=\"4\" id=\"name\" placeholder=\"Имя\" required>
                </div>
            ";
        }
        // line 30
        echo "            <div class=\"form-group\">
                <input class=\"form-control item\" type=\"email\" name=\"email\" id=\"email\" placeholder=\"Email\" required>
            </div>
            <div class=\"form-group\">
                <input class=\"form-control item\" type=\"password\" name=\"password\" minlength=\"4\" id=\"password\" placeholder=\"Пароль\" required>
            </div>
            ";
        // line 36
        if (($context["isRegister"] ?? null)) {
            // line 37
            echo "                <div class=\"form-group\">
                    <input class=\"form-control item\" type=\"password\" name=\"password_\" minlength=\"4\" id=\"password_\" placeholder=\"Пароль\" required>
                </div>
            ";
        }
        // line 41
        echo "            <div class=\"form-group\">
                <button class=\"btn btn-primary btn-block create-account\" type=\"submit\">  ";
        // line 42
        echo ((($context["isRegister"] ?? null)) ? ("Регистрация") : ("Вход"));
        echo " </button>
            </div>

            ";
        // line 45
        if (($context["error"] ?? null)) {
            // line 46
            echo "                <br>
                <span style=\"color: red\">";
            // line 47
            echo twig_escape_filter($this->env, ($context["error"] ?? null), "html", null, true);
            echo "</span>
            ";
        }
        // line 49
        echo "        </form>
    </div>
</body>
";
        // line 52
        $this->loadTemplate("Layouts/footer.twig", "User/_register.twig", 52)->display($context);
    }

    public function getTemplateName()
    {
        return "User/_register.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  129 => 52,  124 => 49,  119 => 47,  116 => 46,  114 => 45,  108 => 42,  105 => 41,  99 => 37,  97 => 36,  89 => 30,  83 => 26,  81 => 25,  76 => 22,  72 => 20,  68 => 18,  66 => 17,  60 => 13,  56 => 11,  52 => 9,  50 => 8,  43 => 4,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "User/_register.twig", "/var/www/php.529252.ru/www/app/View/User/_register.twig");
    }
}
