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

/* User/_change.twig */
class __TwigTemplate_96a2f24834dc6f8d10bde7010b95740a20e16d9001786b5327a5e4684010c205 extends \Twig\Template
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
        $this->loadTemplate("Layouts/header.twig", "User/_change.twig", 1)->display($context);
        // line 2
        echo "<body>
    <div class=\"registration-cssave\">
        <form action=\"/user/change\" method=\"post\" name=\"reg_form\" onsubmit=\"return validateForm();\">
            ";
        // line 5
        if ( !array_key_exists("success", $context)) {
            // line 6
            echo "                <div class=\"registration-title\">
                    <div class=\"title-div\">
                        <h3 class=\"text-center\">
                            Смена пароля
                        </h3>
                    </div>

                </div>

                <div class=\"form-group\">
                    <input class=\"form-control item\" type=\"email\" name=\"email\" id=\"email\" value=\"";
            // line 16
            ((($context["email"] ?? null)) ? (print (twig_escape_filter($this->env, ($context["email"] ?? null), "html", null, true))) : (print ("")));
            echo "\" placeholder=\"Email\" required>
                </div>
                <div class=\"form-group\">
                    <input class=\"form-control item\" type=\"password\" name=\"old_password\" minlength=\"4\" id=\"old_password\" placeholder=\"Старый Пароль\" required>
                </div>
                <div class=\"form-group\">
                    <input class=\"form-control item\" type=\"text\" name=\"password\" minlength=\"4\" id=\"password\" placeholder=\"Пароль\" required>
                </div>
                <div class=\"form-group\">
                    <input class=\"form-control item\" type=\"text\" name=\"password_\" minlength=\"4\" id=\"password_\" placeholder=\"Пароль\" required>
                </div>
                <div class=\"form-group\">
                    <button class=\"btn btn-primary btn-block create-account\" type=\"submit\" id=\"button_change\"><i class=\"fa fa-refresh fa-spin\" id=\"spinner\" style=\"display: none;\"></i> Отправить</button>
                </div>
            ";
        }
        // line 31
        echo "            ";
        if (($context["success"] ?? null)) {
            // line 32
            echo "                <br>
                <span style=\"color: green;font-size: 18pt;\">";
            // line 33
            echo twig_escape_filter($this->env, ($context["success"] ?? null), "html", null, true);
            echo " 
                    <br>
                    <br>
                    <a href=\"/blog/index\">Перейти в блог --></a>
                </span>
            ";
        }
        // line 39
        echo "            ";
        if (($context["error"] ?? null)) {
            // line 40
            echo "                <br>
                <span style=\"color: red\">";
            // line 41
            echo twig_escape_filter($this->env, ($context["error"] ?? null), "html", null, true);
            echo " </span>
            ";
        }
        // line 43
        echo "        </form>
    </div>

</body>
</html>
";
        // line 48
        $this->loadTemplate("Layouts/footer.twig", "User/_change.twig", 48)->display($context);
    }

    public function getTemplateName()
    {
        return "User/_change.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  109 => 48,  102 => 43,  97 => 41,  94 => 40,  91 => 39,  82 => 33,  79 => 32,  76 => 31,  58 => 16,  46 => 6,  44 => 5,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "User/_change.twig", "/var/www/php.529252.ru/www/app/View/User/_change.twig");
    }
}
