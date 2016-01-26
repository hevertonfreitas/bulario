<?php
require_once '../vendor/autoload.php';
use Hevertonfreitas\Bulario\Bulario;

function debug($var)
{
    $template = PHP_SAPI !== 'cli' ? '<pre>%s</pre>' : "\n%s\n";
    printf($template, print_r($var, true));
}
$medicamento = 'dipirona';

$medicamentos = Bulario::buscarMedicamentos($medicamento);

debug($medicamentos);
