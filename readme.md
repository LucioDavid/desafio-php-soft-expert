# Requisitos

- PHP 8.2
- Composer 2.4.1
- PostgreSQL 15
- Extensão de PHP para PostgreSQL (pdo_pgsql e pgsql, precisam ser habilitadas no ``php.ini``)

Sugestão: Utilizar o [XAMPP](https://www.apachefriends.org/download.html).

# Como rodar o Projeto

1. Crie o arquivo ``.env`` como uma cópia do arquivo ``.env.example`` e altere as suas variáveis caso necessário.
2. Inicie seu servidor de PostgreSQL.
3. Execute o comando abaixo para inicializar o banco de dados (criar as tabelas).
```
php cli db:init
```
4. Execute o comando abaixo para rodar o projeto conforme as configurações contidas no arquivo ``.env``.
```
php cli serve
```
5. Abra o navegador da web no endereço configurado no arquivo ``.env`` sob a variável ``APP_URL``.
O endereço sugerido é [http://localhost:8080](http://localhost:8080).


#  Tecnologias, versões e soluções adotadas

- Buscou-se implementar o básico de um framework, de modo a separar as responsabilidades das classes do sistema.
- Utilizou-se o autoload do composer para se conseguir carregar, com uma única chamada, todas as classes da pasta ``src``.
- Implementou-se o conceito de separação das variáveis de ambiente.

# Oportunidades de Melhoria do Sistema

- Aumentar a independência entre os métodos dos _controllers_.
- Implementar novas regras de validação de dados, como _numeric_ e _exists_.
- Isolar todo texto da interface de usuário em arquivos de localização.
- Transformar as Models em classes estáticas.
- Utilizar arquivo de configuração para definir parâmetros do sistema, como a _timezone_.
- Incluir métodos HTTP PUT e DELETE.
- Separar rotas em arquivo próprio.
- Cadastrar rotas com uma nova classe Route, com métodos estáticos.
- Aprimorar os filtros de inputs.
- Implementar _migrations_.
- Implementar _seeders_.

# Créditos

- Créditos ao Bootstrap, pois foram utilizadas as suas classes nos alertas do sistema.
- Foi utilizada a _library_ de front-end Materialize CSS.
