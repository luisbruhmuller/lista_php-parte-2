<?php

function ordenarPorHorario(array $consultas): array
{
    usort($consultas, fn($a, $b) => strcmp($a['horario'], $b['horario']));

    return $consultas;
}

function contarPacientesDiferentes(array $consultas): int
{
    return count(array_unique(array_column($consultas, 'paciente')));
}

function contarPorEspecialidade(array $consultas): array
{
    return array_count_values(array_column($consultas, 'especialidade'));
}

function pesquisarPaciente(array $consultas, string $paciente): array
{
    return array_values(array_filter(
        $consultas,
        fn($consulta) => strcasecmp($consulta['paciente'], $paciente) === 0
    ));
}

function existemHorariosDuplicados(array $consultas): bool
{
    $horarios = [];

    foreach ($consultas as $consulta) {
        $chave = $consulta['data'] . ' ' . $consulta['horario'];

        if (isset($horarios[$chave])) {
            return true;
        }

        $horarios[$chave] = true;
    }

    return false;
}

function primeiroAtendimento(array $consultasOrdenadas): ?array
{
    return $consultasOrdenadas[0] ?? null;
}

function ultimoAtendimento(array $consultasOrdenadas): ?array
{
    return $consultasOrdenadas[count($consultasOrdenadas) - 1] ?? null;
}

function organizarAgenda(array $consultas, string $paciente): array
{
    $ordenadas = ordenarPorHorario($consultas);

    return [
        'total_consultas' => count($consultas),
        'pacientes_diferentes' => contarPacientesDiferentes($consultas),
        'consultas_por_especialidade' => contarPorEspecialidade($consultas),
        'primeiro_atendimento' => primeiroAtendimento($ordenadas),
        'ultimo_atendimento' => ultimoAtendimento($ordenadas),
        'lista_ordenada' => $ordenadas,
        'pesquisa_paciente' => pesquisarPaciente($consultas, $paciente),
        'horarios_duplicados' => existemHorariosDuplicados($consultas),
    ];
}
