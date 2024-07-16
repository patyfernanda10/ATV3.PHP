<?php
// Função para ler a entrada do usuário
function readInput() {
    return trim(fgets(STDIN));
}

// Função para cadastrar alunos
function cadastrarAlunos(&$alunos) {
    for ($i = 0; $i < 5; $i++) {
        echo "Digite o nome do aluno " . ($i + 1) . ": ";
        $nome = readInput();
        $alunos[$nome] = ['notas' => [], 'total' => 0, 'media' => 0, 'status' => ''];
    }
}

// Função para atribuir notas
function atribuirNotas(&$alunos) {
    foreach ($alunos as $nome => &$info) {
        for ($i = 0; $i < 4; $i++) {
            do {
                echo "Digite a nota " . ($i + 1) . " do aluno $nome (0-10): ";
                $nota = (float)readInput();
            } while ($nota < 0 || $nota > 10);
            $info['notas'][] = $nota;
        }
    }
}

// Função para calcular a nota total e a média
function calcularNotas(&$alunos) {
    foreach ($alunos as $nome => &$info) {
        $info['total'] = array_sum($info['notas']);
        $info['media'] = $info['total'] / 4;
        if ($info['media'] < 4) {
            $info['status'] = 'Reprovado';
        } elseif ($info['media'] <= 6) {
            $info['status'] = 'Recuperação';
        } else {
            $info['status'] = 'Aprovado';
        }
    }
}

// Função para editar resultados
function editarResultados(&$alunos) {
    echo "Digite o nome do aluno que deseja editar: ";
    $nome = readInput();
    if (isset($alunos[$nome])) {
        for ($i = 0; $i < 4; $i++) {
            do {
                echo "Digite a nova nota " . ($i + 1) . " do aluno $nome (0-10): ";
                $nota = (float)readInput();
            } while ($nota < 0 || $nota > 10);
            $alunos[$nome]['notas'][$i] = $nota;
        }
        calcularNotas($alunos);
        echo "Notas atualizadas com sucesso!\n";
    } else {
        echo "Aluno não encontrado!\n";
    }
}

// Função para exibir o menu e processar opções
function exibirMenu() {
    $alunos = [];
    do {
        echo "\nSistema de Gestão de Notas\n";
        echo "1. Cadastrar alunos\n";
        echo "2. Atribuir notas\n";
        echo "3. Calcular notas\n";
        echo "4. Exibir resultados\n";
        echo "5. Editar resultados\n";
        echo "0. Sair\n";
        echo "Escolha uma opção: ";
        $opcao = readInput();

        switch ($opcao) {
            case '1':
                cadastrarAlunos($alunos);
                break;
            case '2':
                atribuirNotas($alunos);
                break;
            case '3':
                calcularNotas($alunos);
                break;
            case '4':
                foreach ($alunos as $nome => $info) {
                    echo "Aluno: $nome\n";
                    echo "Notas: " . implode(", ", $info['notas']) . "\n";
                    echo "Total: " . $info['total'] . "\n";
                    echo "Média: " . $info['media'] . "\n";
                    echo "Status: " . $info['status'] . "\n";
                }
                break;
            case '5':
                editarResultados($alunos);
                break;
            case '0':
                echo "Saindo...\n";
                break;
            default:
                echo "Opção inválida!\n";
                break;
        }
    } while ($opcao != '0');
}

// Executar o sistema
exibirMenu();
?>
