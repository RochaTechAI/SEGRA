# SEGRA - Sistema de Gerenciamento de Amostras

O SEGRA é um ecossistema backend robusto desenvolvido em **Laravel 11**, projetado para o rastreio, gestão e integridade de amostras laboratoriais. Este projeto simula um ambiente de missão crítica onde a segurança de dados e a rastreabilidade são requisitos mandatórios.

> **Status do Projeto**: 🚧 Em constante evolução de funcionalidades.
> **Nota**: Atualmente o projeto foca na camada de API e regras de negócio. O desenvolvimento da interface Frontend está planejado para as próximas etapas.

## Diferenciais Técnicos (Senior Architecture)

* **Service Layer Pattern**: Lógica de negócio totalmente desacoplada dos Controllers, permitindo reutilização e testes isolados.
* **Conformidade LGPD**: Implementação de anonimização de dados sensíveis de pacientes via Hash SHA-256 antes da persistência.
* **UUIDs v4**: Utilização de identificadores universais como chave primária, eliminando vulnerabilidades de enumeração de IDs sequenciais.
* **API RESTful Versionada**: Endpoints estruturados sob o prefixo `v1`, utilizando Eloquent Resources para transformação e padronização de respostas JSON.
* **Batch Processing**: Interface de linha de comando (CLI) customizada para importação massiva de dados (Datasets laboratoriais).
* **Segurança de Tipagem**: Validação estrita via Form Requests, garantindo a integridade dos dados de entrada.
* **Docker Ready**: Ambiente de desenvolvimento conteinerizado via Laravel Sail para reprodutibilidade imediata.

## Roadmap de Evolução

O SEGRA segue um ciclo de melhoria contínua. As próximas implementações incluem:

1.  **Frontend**: Desenvolvimento de interface administrativa (SPA) para gestão visual das amostras.
2.  **Autenticação**: Implementação de Laravel Sanctum para proteção de rotas via tokens.
3.  **Audit Log**: Sistema de auditoria para registrar quem alterou o status de cada amostra.
4.  **Integração com IA**: Módulo para leitura e parser de guias médicas digitalizadas.

## Requisitos de Sistema

* Docker / Laravel Sail
* PHP 8.3+
* PostgreSQL

## Instalação e Execução

1.  Clone o repositório:
    ```bash
    git clone [https://github.com/RochaTechAI/segra.git](https://github.com/RochaTechAI/segra.git)
    ```
2.  Suba o ambiente Docker:
    ```bash
    ./vendor/bin/sail up -d
    ```
3.  Execute as migrações:
    ```bash
    sail artisan migrate:fresh
    ```
4.  Povoar banco via lote (CLI):
    ```bash
    sail artisan segra:import
    ```

## Endpoints da API

* `GET /api/v1/amostras`: Lista todas as amostras registradas.
* `POST /api/v1/amostras`: Registra uma nova amostra no sistema.
* `GET /api/v1/amostras/{uuid}`: Detalha uma amostra específica.

---
Desenvolvido por **Uanderson Rocha** como parte do portfólio de Engenharia de Software e Saúde Digital.