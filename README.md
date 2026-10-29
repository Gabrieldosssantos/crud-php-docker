
# Actions: Changelog, Release e Runner

Este documento descreve brevemente o funcionamento das actions de **Changelog**, **Release** e **Runner**, explicando suas responsabilidades no fluxo de automação e entrega de software.

## 1. Changelog Action

A action de **Changelog** é responsável por gerar ou atualizar o registro de alterações do projeto. Ela organiza as mudanças realizadas entre versões, facilitando o acompanhamento de novas funcionalidades, correções de bugs e outras modificações.

**Principais responsabilidades:**
- Identificar alterações relevantes desde a última versão.
- Gerar ou atualizar o arquivo `CHANGELOG.md`.
- Organizar as mudanças para facilitar a consulta do histórico do projeto.

## 2. Release Action

A action de **Release** é responsável por preparar e publicar uma nova versão do projeto. Ela pode utilizar as informações do changelog para documentar as alterações incluídas na versão.

**Principais responsabilidades:**
- Definir ou identificar a versão a ser publicada.
- Criar uma tag de versão, quando aplicável.
- Gerar notas da versão (*release notes*).
- Publicar a release na plataforma configurada, como o GitHub.

## 3. Runner Action

A action de **Runner** é responsável por executar tarefas automatizadas definidas no fluxo de trabalho. Ela funciona como parte do ambiente de execução das etapas de automação, seguindo as configurações e os comandos definidos no projeto.

**Principais responsabilidades:**
- Executar scripts e comandos automatizados.
- Processar as etapas definidas no workflow.
- Disponibilizar o ambiente necessário para a execução das tarefas.
- Retornar o resultado da execução, indicando sucesso ou falha.

## Fluxo de funcionamento

De forma geral, essas actions podem trabalhar em conjunto no processo de entrega de software:

1. **Runner:** executa as tarefas automatizadas do workflow.
2. **Changelog:** registra as alterações realizadas no projeto.
3. **Release:** utiliza as informações da versão para preparar e publicar a entrega.

A ordem exata de execução depende das dependências e da configuração do workflow utilizado no projeto.
