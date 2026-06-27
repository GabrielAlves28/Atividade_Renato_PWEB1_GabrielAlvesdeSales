> **🌐 APLICAÇÃO EM PRODUÇÃO:** [https://atividaderenatopweb1gabrielalvesdesales-production.up.railway.app](https://atividaderenatopweb1gabrielalvesdesales-production.up.railway.app)
>
> | Perfil | E-mail | Senha |
> |--------|--------|-------|
> | **Gestor** | gestor@associacao.com.br | senha123 |
> | **Leiturista** | leiturista@associacao.com.br | senha123 |

---

Dupla: Gabriel Alves de Sales e William Axel

# Sistema de Controle de Consumo de Água

Sistema web desenvolvido para uma associação comunitária gerenciar o abastecimento de água, calcular o consumo mensal dos medidores e gerar faturas automáticas com link de cobrança via WhatsApp.

**Desenvolvido por:** Gabriel Alves de Sales e William Axel

## Tecnologias Usadas
- PHP 8.2 com Laravel 12
- Banco de Dados MySQL 8.0
- HTML/CSS (Bootstrap)
- Docker + Nginx (deploy)
- Railway.app (hospedagem em nuvem)

---

## 🐳 Como Rodar com Docker (Recomendado)

### Pré-requisitos
- [Docker Desktop](https://www.docker.com/products/docker-desktop/) instalado e em execução

### Passos

```bash
# 1. Clone o repositório
git clone https://github.com/GabrielAlves28/Atividade_Renato_PWEB1_GabrielAlvesdeSales.git
cd Atividade_Renato_PWEB1_GabrielAlvesdeSales

# 2. Suba os containers (build + inicialização)
docker-compose up -d --build

# 3. Gere a chave da aplicação Laravel
docker exec app php artisan key:generate

# 4. Execute as migrations (cria as tabelas no banco)
docker exec app php artisan migrate --force

# 5. Popule o banco com os usuários de teste
docker exec app php artisan db:seed

# 6. Acesse no navegador
# http://localhost:8000
```

### Credenciais de Teste

| Perfil     | E-mail                        | Senha    |
|------------|-------------------------------|----------|
| Gestor     | gestor@associacao.com.br      | senha123 |
| Leiturista | leiturista@associacao.com.br  | senha123 |

### Comandos Úteis Docker

```bash
# Ver logs dos containers
docker-compose logs -f

# Parar os containers
docker-compose down

# Parar e remover os volumes (apaga o banco!)
docker-compose down -v

# Acessar o shell do container da aplicação
docker exec -it app bash
```

---

## 💻 Como Instalar e Rodar Localmente (Sem Docker)

1. Clone este repositório em sua máquina.
2. Abra o terminal na pasta do projeto e rode `composer install` para instalar as dependências.
3. Copie o arquivo `.env.example` para `.env` e configure suas credenciais do banco de dados MySQL.
4. Rode o comando `php artisan key:generate`.
5. Crie um banco de dados vazio chamado `controle_agua` no seu SGBD.
6. Rode as migrations com o comando `php artisan migrate`.
7. Popule o banco com `php artisan db:seed`.
8. Inicie o servidor local rodando `php artisan serve`.
9. Acesse `http://localhost:8000` no navegador.

---

## 📁 Estrutura Docker

```
controle-agua/
├── Dockerfile              # Imagem PHP 8.2-FPM da aplicação
├── docker-compose.yml      # Orquestra app + nginx + mysql
└── docker/
    └── nginx/
        └── default.conf    # Configuração do servidor web Nginx
```
