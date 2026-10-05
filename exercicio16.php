<?php

function contarMaiusculas(string $senha): int
{
    return preg_match_all('/[A-Z]/', $senha);
}

function contarMinusculas(string $senha): int
{
    return preg_match_all('/[a-z]/', $senha);
}

function contarNumeros(string $senha): int
{
    return preg_match_all('/[0-9]/', $senha);
}

function contarEspeciais(string $senha): int
{
    return preg_match_all('/[^a-zA-Z0-9]/', $senha);
}

function classificarSenha(int $tamanho, int $maiusculas, int $minusculas, int $numeros, int $especiais): string
{
    if ($tamanho < 8) {
        return 'Fraca';
    }

    $tipos = ($maiusculas > 0) + ($minusculas > 0) + ($numeros > 0) + ($especiais > 0);

    if ($tipos === 4) {
        return 'Muito Forte';
    }

    if ($tipos === 3) {
        return 'Forte';
    }

    return 'Média';
}

function analisarSenha(string $senha): array
{
    $maiusculas = contarMaiusculas($senha);
    $minusculas = contarMinusculas($senha);
    $numeros = contarNumeros($senha);
    $especiais = contarEspeciais($senha);
    $tamanho = strlen($senha);

    return [
        'maiusculas' => $maiusculas,
        'minusculas' => $minusculas,
        'numeros' => $numeros,
        'especiais' => $especiais,
        'tamanho' => $tamanho,
        'nivel' => classificarSenha($tamanho, $maiusculas, $minusculas, $numeros, $especiais),
    ];
}
