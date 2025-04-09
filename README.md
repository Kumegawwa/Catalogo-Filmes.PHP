# Catálogo de Filmes em PHP

## Descrição

Este é um projeto de estudo simples. Um catálogo de filmes dinâmico feito em PHP. Ele permite aos visitantes visualizar uma lista de filmes, ver detalhes de cada um, filtrar a lista por título ou gênero e permite que um administrador (com login) adicione novos filmes ao catálogo. Novos filmes adicionados são armazenados temporariamente na sessão PHP. O projeto utiliza Bootstrap 5 para estilização básica e responsividade.

## Funcionalidades

*   **Listagem de Filmes:** Exibe os filmes do catálogo inicial (`dados.php`) e os filmes adicionados durante a sessão do usuário.
*   **Detalhes do Filme:** Mostra informações completas de um filme selecionado (título, ano, gênero, produtor, distribuidora, nota, descrição e imagem).
*   **Busca/Filtro:** Permite buscar filmes por título ou gênero através de uma barra de pesquisa na navegação.
*   **Login de Administrador:** Sistema de login simples com credenciais fixas (`admin` / `123`) para acessar a área restrita.
*   **Área Restrita:** Página (`protegido.php`) acessível apenas após login, onde é possível adicionar novos filmes.
*   **Adicionar Filme:** Formulário para cadastrar novos filmes com título, gênero, ano, nota, produtor, distribuidora, descrição e imagem (via URL ou upload de arquivo).
    *   Filmes adicionados são armazenados na `$_SESSION` e exibidos imediatamente no catálogo principal.
    *   Upload de imagens (JPG, PNG, até 2MB) são salvas na pasta `imagens/`.
*   **Logout:** Funcionalidade para encerrar a sessão do administrador.
*   **Design Responsivo:** Utiliza Bootstrap 5 para adaptar a visualização em diferentes tamanhos de tela.

## Tecnologias Utilizadas

*   **PHP:** Linguagem principal para lógica do servidor, gerenciamento de sessão e geração de conteúdo dinâmico.
*   **HTML5:** Estrutura das páginas web.
*   **CSS3:** Estilização básica (integrada no `header.php`) e através do Bootstrap.
*   **Bootstrap 5:** Framework CSS/JS para layout, componentes visuais e responsividade.
*   **Servidor Web:** Necessário um ambiente com servidor web (como Apache ou Nginx) com suporte a PHP (Ex: XAMPP, WAMP, MAMP, Laragon).

## Como Configurar e Executar o Projeto

1.  **Pré-requisitos:**
    *   Ter um ambiente de servidor web local instalado e rodando ([XAMPP](https://www.apachefriends.org/index.html)). Certifique-se de que o serviço Apache e o PHP estejam ativos.

2.  **Obter os Arquivos:**
    *   Baixe ou clone todos os arquivos PHP do projeto (`index.php`, `detalhes.php`, `login.php`, `logout.php`, `protegido.php`, `dados.php`, `funcoes.php`, `header.php`, `footer.php`).

3.  **Estrutura de Pastas:**
    *   Crie uma pasta para o projeto dentro do diretório raiz do seu servidor web (geralmente `htdocs` no XAMPP, `www` no WAMP/MAMP). Ex: `catalogo_filmes`.
    *   Coloque todos os arquivos `.php` diretamente dentro desta pasta (`catalogo_filmes/`).
    *   **Importante:** Crie manualmente uma subpasta chamada `imagens` dentro da pasta principal (`catalogo_filmes/imagens/`). Esta pasta será usada para armazenar as imagens enviadas pelo formulário de adicionar filme.

4.  **Acessar o Projeto:**
    *   Abra seu navegador web e acesse o endereço correspondente à pasta do projeto no seu servidor local. Ex: `http://localhost/catalogo_filmes/`.

6.  **Login (para adicionar filmes):**
    *   Navegue até `http://localhost/catalogo_filmes/login.php`.
    *   Usuário: `admin`
    *   Senha: `123`

## Estrutura dos Arquivos

*   `index.php`: Página principal que exibe o catálogo de filmes e lida com a filtragem/busca.
*   `detalhes.php`: Exibe os detalhes de um filme específico, identificado por um `id` passado via GET.
*   `login.php`: Contém o formulário de login e processa a autenticação do usuário.
*   `logout.php`: Encerra a sessão do usuário logado e redireciona para a página de login.
*   `protegido.php`: Página restrita para adicionar novos filmes. Verifica se o usuário está logado; caso contrário, redireciona para `login.php`. Processa o formulário de adição de filme.
*   `dados.php`: Contém o array PHP inicial `$filmes` com os dados base do catálogo.
*   `funcoes.php`: Contém funções PHP reutilizáveis, como `encontrarFilmePorId()`.
*   `header.php`: Define o início do HTML (`<head>`, `<body>`), inclui o CSS do Bootstrap, a barra de navegação superior e inicia a sessão (`session_start()`). Também exibe mensagens de sucesso/erro armazenadas na sessão.
*   `footer.php`: Define o rodapé da página e inclui o JavaScript do Bootstrap.
*   `imagens/` (Pasta): Destino para as imagens enviadas através do formulário em `protegido.php`. **(Deve ser criada manualmente)**

## Como Funciona

*   **Dados:** Os dados iniciais dos filmes estão no array `$filmes` em `dados.php`. Filmes adicionados pelo administrador logado são armazenados no array `$_SESSION['filmes_adicionados']`.
*   **Exibição:** A `index.php` combina os filmes de `$filmes` e `$_SESSION['filmes_adicionados']` e usa um loop `foreach` para exibir cada um como um card do Bootstrap.
*   **Detalhes:** Ao clicar em "Saiba mais", o `id` do filme é passado via GET para `detalhes.php`. A função `encontrarFilmePorId()` (em `funcoes.php`) busca o filme correspondente tanto no array base quanto no array da sessão.
*   **Login/Sessão:** `login.php` compara os dados do formulário POST com as credenciais fixas. Se corretos, define `$_SESSION['logado'] = true;` e `$_SESSION['usuario']`. O `header.php` inicia a sessão em todas as páginas. `protegido.php` verifica `$_SESSION['logado']` para permitir acesso. `logout.php` destrói a sessão.
*   **Adição (Sessão):** `protegido.php` valida os dados do formulário POST. Se válidos, lida com a imagem (prioriza upload sobre URL), cria um novo array para o filme (com um ID único prefixado com 's' para indicar origem da sessão) e o adiciona a `$_SESSION['filmes_adicionados']`. Em seguida, redireciona para `index.php` com uma mensagem de sucesso na sessão.
*   **Upload vs URL:** O formulário em `protegido.php` permite colar uma URL ou fazer upload. O código PHP prioriza o arquivo enviado. Se um arquivo for enviado com sucesso, seu caminho (ex: `imagens/img_xxxxx.jpg`) é salvo; caso contrário, se uma URL válida for fornecida, essa URL é salva.