<?php
namespace App\Helpers;

trait HelpersTrait
{

    /**
     * Parse string and remove the accents
     * @param string|null $string
     * @param string|null $charset
     *
     * @return string
     */
    public function skipAccents(?string $string = '', ?string $charset = 'utf-8'): string
    {
        $string = trim($string);
        $string = htmlentities($string, ENT_NOQUOTES, $charset);

        $string = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $string);
        $string = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $string);
        $string = preg_replace('#&[^;]+;#', '', $string);
        $string = preg_replace('/[^A-Za-z0-9\-]/', ' ', $string);

        return $string;
    }

}
