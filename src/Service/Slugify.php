<?php


namespace App\Service;


class Slugify
{
    public function generate (string $input) : string
    {
        $input = htmlentities($input, ENT_NOQUOTES, 'utf-8');
        $input = str_replace(' ', '-', $input);
        $input = trim($input,'');
        $input = strtolower($input);
        $input = str_replace('#&([a-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $input);
        $input = str_replace('/[.,\/#!$%\^&\*;:{}=_`~()]/', '', $input);

        return $input;
    }
}