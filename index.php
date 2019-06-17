<?php

$alphas = range('A', 'Z');
$baseUrl = "https://www.referendum.interieur.gouv.fr/consultation_publique/8/";

$count = 0;

function scrapLink($urlCible)
{
    global $count;
    $contentCible = @file_get_contents($urlCible);

    $supprimer = array('@<form.*?</form>@si', '@<style.*?</style>@si', '@<head.*?</head>@si', '@<noscript.*?</noscript>@si', '@<script.*?</script>@si');

    $contenu = preg_replace($supprimer, array('', '', ''), $contentCible);

    $doc = new DOMDocument();
    $doc->loadHTML($contenu);
    $node = $doc->getElementById('formulaire_consultation_publique');
    $count += countSupport($node);
    return $count;
}

function countSupport($node)
{
    $mayBeEmpty = $node->childNodes[7]->textContent;
    if (contains($mayBeEmpty, "Aucun")) {
        return 0;
    } else {
        countReallySupport($node);
        return 0;
    }

}

function contains($haystack, $needle)
{
    return strpos($haystack, $needle) !== false;
}


function countReallySupport($node)
{
    echo "There are supports";
}

// $baseUrl = "https://www.referendum.interieur.gouv.fr/consultation_publique/8/A/AA";
// echo scrapLink($baseUrl);


foreach ($alphas as $fValue) {
    foreach ($alphas as $sValue) {
        echo "<h1>$fValue-$fValue$sValue</h1>";
        //$n = scrapLink($baseUrl . $fValue . "/" . $fValue . $sValue);
        //echo "Numbber of support found " . $n;
    }
}

