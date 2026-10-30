# 🎰 Carrossel de Bolões

Sistema web completo desenvolvido em **Laravel** com autenticação **Laravel Breeze**, estilizado com **Tailwind CSS** e rodando sobre um ambiente conteinerizado com **Docker**. O sistema gerencia loterias, dias de sorteio, valores acumulados e o cadastro central de bolões.

---

## 🚀 Tecnologias Utilizadas

- **PHP 8.x** / **Laravel 10+**
- **MySQL** (Banco de dados relacional via Docker)
- **Node.js** (Gerenciamento de assets com Vite e Tailwind CSS)
- **Docker & Docker Compose** (Ambiente de desenvolvimento isolado)
- **Laravel Breeze** (Autenticação e painel administrativo)

---

## ⚙️ Pré-requisitos e Instalação do Ambiente

Certifique-se de ter o **Docker** e o **Docker Compose** instalados na sua máquina.

1. Clone o repositório e suba os containers do projeto:
   
docker compose up -d

2. Instale as dependências da aplicação (caso ainda não tenha feito):   

docker compose exec app composer install
docker compose run --npm run install

3. Execute as migrações do banco de dados:

docker compose exec app php artisan migrate

4. Para compilar os assets estáticos do Tailwind/Vite e garantir que o layout carregue corretamente sem o servidor dev ativo:

docker compose run --rm node npm run build

Módulos Implementados (CRUDs do Painel)

O painel administrativo protegido por autenticação conta com os seguintes módulos operacionais integrados diretamente à barra de navegação principal:
1. 🎲 Jogos da Loteria (/lottery-games)

Gerenciamento base dos tipos de loteria disponíveis (Ex: Mega-Sena, Quina, Lotofácil).

    Campos: name (Nome do jogo), is_active (Status).

2. 📅 Dias de Sorteio (/lottery-draw-days)

Vinculação dos dias da semana em que cada jogo da loteria é sorteado.

    Campos: lottery_game_id (Relação com o jogo) e marcadores booleanos para os 7 dias da semana (Domingo a Sábado).

3. 💰 Valores Acumulados (/lottery-accumulateds)

Controle do prêmio acumulado atual de cada jogo da loteria. Possui máscara monetária em JavaScript no formato brasileiro (R$ 0,00).

    Lógica de Negócio: O sistema mantém apenas o acumulado mais recente por jogo. Ao cadastrar um novo valor para um jogo existente, o anterior é substituído automaticamente.

    Campos: lottery_game_id, amount (Valor decimal).

4. 🎟️ Cadastro de Bolões (/lottery-pools)

O core do sistema. Unifica as tabelas anteriores para montar a oferta do bolão.

    Campos:

        lottery_game_id (ID do Jogo)

        lottery_draw_day_id (ID do dia de sorteio configurado)

        lottery_accumulated_id (ID do acumulado opcional)

        draw_date (Data específica do sorteio)

        quota_value (Valor da cota com máscara monetária)

        quota_quantity (Quantidade total de cotas disponíveis)

        numbers_count (Quantidade de dezenas jogadas)

        whatsapp_link (Link direto para atendimento/venda no WhatsApp)

        caixa_link (Link opcional para o site oficial da Loterias Caixa)

🛠️ Comandos Úteis do Dia a Dia

    Subir os containers: docker compose up -d

    Parar os containers: docker compose down

    Limpar todos os caches do Laravel: docker compose exec app php artisan optimize:clear

    Rodar novas migrations: docker compose exec app php artisan migrate

    Recompilar assets de produção (Vite): docker compose run --rm node npm run build