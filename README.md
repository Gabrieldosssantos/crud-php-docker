
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
### Explicação Linha por Linha do Workflow (`changelog.yml`)

#### **Configurações Globais**

* `name: Gerar Changelog`: Define o nome do workflow que aparece no painel da aba **Actions** do GitHub.
* `on:`: Bloco que especifica os eventos que acionam a execução do workflow.
* `  push:`: Define o gatilho para envios de código.
* `    branches:`: Lista as branches monitoradas para o evento de push.
* `      - main`: Restringe o disparo automático para novos commits enviados à branch `main`.
* `  workflow_dispatch:`: Permite a execução manual do workflow via botão na interface do GitHub.
* `permissions:`: Define o nível de permissão concedido ao token padrão da automação (`GITHUB_TOKEN`).
* `  contents: write`: Concede permissão de **escrita** no repositório (necessário para registrar e enviar o novo commit com o arquivo `CHANGELOG.md`).

---

#### **Estrutura dos Jobs**

* `jobs:`: Agrupa as tarefas que serão executadas no runner.
* `  changelog:`: Identificador (ID) exclusivo da tarefa de geração de changelog.
* `    runs-on: ubuntu-latest`: Especifica o ambiente de execução (uma máquina virtual Linux Ubuntu gerenciada pelo GitHub).
* `    steps:`: Lista sequencial de passos que compõem a tarefa.

---

#### **Passo 1: Baixar o Repositório**

* `      - name: Baixar repositorio`: Nome amigável exibido no painel para a primeira etapa.
* `        uses: actions/checkout@v4`: Executa a ação oficial do GitHub para clonar o repositório dentro do runner.
* `        with:`: Bloco para passar parâmetros à ação de checkout.
* `          fetch-depth: 0`: Configura o checkout para baixar **todo o histórico de commits** do projeto (essencial para que o comando `git log` leia commits anteriores).

---

#### **Passo 2: Gerar o Arquivo CHANGELOG.md**

* `      - name: Gerar changelog`: Nome amigável para a segunda etapa.
* `        run: |`: Indica o início de um bloco de script Shell multilinhas.
* `          {`: Abre um bloco no Shell para agrupar as saídas dos comandos subsequentes.
* `            echo "# Changelog"`: Imprime o título principal em formato Markdown.
* `            echo ""`: Imprime uma linha em branco para espaçamento.
* `            echo "Ultimas alteracoes do projeto:"`: Imprime o subtítulo de descrição.
* `            echo ""`: Imprime uma linha em branco para espaçamento.
* `            git log -10 --pretty=format:"- %h - %s (%ad)" --date=short`: Extrai o histórico do Git com as seguintes opções:
  * `-10`: Limita a busca aos últimos 10 commits.
  * `--pretty=format:"- %h - %s (%ad)"`: Formata a linha como `- [hash_curto] - [mensagem] ([data])`.
  * `--date=short`: Exibe a data no formato simplificado (`AAAA-MM-DD`).
* `            echo ""`: Imprime uma linha em branco de encerramento.
* `          } > CHANGELOG.md`: Direciona toda a saída do bloco agrupado `{ ... }` para criar/sobrescrever o arquivo `CHANGELOG.md`.

---

#### **Passo 3: Commitar e Enviar o Changelog**

* `      - name: Salvar changelog`: Nome amigável para a terceira etapa.
* `        run: |`: Início do bloco de script para persistir as alterações.
* `          git config user.name "github-actions[bot]"`: Identifica o autor do commit no Git como o bot padrão do GitHub Actions.
* `          git config user.email "41898282+github-actions[bot]@users.noreply.github.com"`: Define o e-mail associado ao bot oficial do GitHub.
* `          git add CHANGELOG.md`: Prepara o arquivo `CHANGELOG.md` no staging do Git.
* `          if ! git diff --cached --quiet; then`: Estrutura condicional que verifica se há alterações pendentes no arquivo modificado.
* `            git commit -m "docs: atualiza changelog"`: Cria um commit com a mensagem especificada caso haja mudanças reais.
* `            git push`: Envia o commit com o novo changelog para a branch remota no GitHub.
* `          fi`: Finaliza o bloco condicional `if`.
