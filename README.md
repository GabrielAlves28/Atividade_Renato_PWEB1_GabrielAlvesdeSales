# Sistema de Controle de Consumo de Água

Sistema web simples desenvolvido para uma associação comunitária gerenciar o abastecimento de água, calcular o consumo mensal dos medidores e gerar faturas automáticas com link de cobrança via WhatsApp.

**Desenvolvido por:** Gabriel Alves de Sales

## Tecnologias Usadas
- PHP com Laravel 11
- Banco de Dados MySQL
- HTML/CSS (Bootstrap)

## Como Instalar e Rodar Localmente
1. Clone este repositório em sua máquina.
2. Abra o terminal na pasta do projeto e rode `composer install` para instalar as dependências.
3. Copie o arquivo `.env.example` para `.env` e configure suas credenciais do banco de dados MySQL.
4. Rode o comando `php artisan key:generate`.
5. Crie um banco de dados vazio chamado `controle_agua` no seu SGBD.
6. Rode as migrations com o comando `php artisan migrate`.
7. Inicie o servidor local rodando `php artisan serve`.
8. Acesse `http://localhost:8000` no navegador. A taxa padrão de cobrança será criada automaticamente no primeiro acesso.
