<?php

function removerEspacosDuplicados(string $texto): string
{
    return trim(preg_replace('/\s+/u', ' ', $texto));
}

function separarPalavras(string $texto): array
{
    $texto = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $texto);
    $texto = removerEspacosDuplicados($texto);

    return $texto === '' ? [] : explode(' ', $texto);
}

function contarFrases(string $texto): int
{
    $frases = preg_split('/[.!?]+/u', $texto);

    return count(array_filter($frases, fn($frase) => trim($frase) !== ''));
}

function encontrarMaiorPalavra(array $palavras): string
{
    $maior = '';

    foreach ($palavras as $palavra) {
        if (strlen($palavra) > strlen($maior)) {
            $maior = $palavra;
        }
    }

    return $maior;
}

function encontrarMenorPalavra(array $palavras): string
{
    $menor = $palavras[0] ?? '';

    foreach ($palavras as $palavra) {
        if (strlen($palavra) < strlen($menor)) {
            $menor = $palavra;
        }
    }

    return $menor;
}

function contarPalavrasRepetidas(array $frequencias): int
{
    $total = 0;

    foreach ($frequencias as $quantidade) {
        $total += max(0, $quantidade - 1);
    }

    return $total;
}

function cincoMaisFrequentes(array $frequencias): array
{
    arsort($frequencias);

    return array_slice($frequencias, 0, 5, true);
}

function formatarTexto(string $texto): string
{
    return ucwords(strtolower($texto));
}

function processarTexto(string $texto): array
{
    $semEspacosDuplicados = removerEspacosDuplicados($texto);
    $palavras = separarPalavras($semEspacosDuplicados);
    $frequencias = array_count_values(array_map('strtolower', $palavras));

    return [
        'caracteres' => strlen($texto),
        'palavras' => count($palavras),
        'frases' => contarFrases($texto),
        'palavra_mais_longa' => encontrarMaiorPalavra($palavras),
        'palavra_mais_curta' => encontrarMenorPalavra($palavras),
        'palavras_repetidas' => contarPalavrasRepetidas($frequencias),
        'cinco_mais_frequentes' => cincoMaisFrequentes($frequencias),
        'sem_espacos_duplicados' => $semEspacosDuplicados,
        'texto_formatado' => formatarTexto($semEspacosDuplicados),
    ];
}
