# 💬 Locação de Casas de Férias - Laravel 12
Este projeto foi desenvolvido utilizando **Laravel 12**, com **MySQL (MariaDB)** como banco de dados, **Breeze** para autenticação e **Blade** para renderização de interfaces. 
O objetivo deste projeto é desenvolver uma plataforma web para aluguer de carros, permitindo que clientes se registem e autentiquem com segurança, acedam ao seu histórico de reservas e realizem novas reservas de forma intuitiva. 

📌 Contexto do Projeto
Este repositório faz parte de uma iniciativa de demonstração e apoio pedagógico no âmbito da UFCD de Integração, tendo como destinatários os alunos do curso. A proposta base consiste no desenvolvimento de uma aplicação integrada, explorando conceitos de autenticação, persistência de dados, comunicação com APIs externas e gestão de reservas.

🎯 Proposta: Plataforma para Locação de Viaturas
Desenvolvimento de uma plataforma para reservas de carros, incluindo:
- Registo e autenticação de utilizadores
- Catálogo pesquisável com filtros
- Gestão de reservas com verificação de disponibilidade
- Integração de métodos de pagamento (reais e simulados)
- Envio de notificações por e-mail

## 🚀 Tecnologias Utilizadas
- **Laravel 12** - Framework PHP moderno e robusto
- **MySQL (MariaDB)** - Banco de dados relacional
- **Breeze** - Implementação simples de autenticação em Laravel
- **Blade** - Sistema de templates do Laravel
- **Tailwind CSS** - Estilização moderna e responsiva
- **Javascript** - Responsividade para a interação dos utilizadores

Sobre a framework, consulte: [Documentação](https://laravel.com/docs/)

## 🎯 Funcionalidades
A aplicação disponibiliza uma listagem de produtos com filtros por data, localização e intervalo de preço, facilitando a pesquisa de acordo com as necessidades do utilizador e disponibilidade de bens. O sistema de reservas inclui o cálculo automático do custo com base nas datas selecionadas, bem como a integração com métodos de pagamento reais (PayPal) e simulação de referências Multibanco fictícias para fins de teste. Após a conclusão de uma reserva, o utilizador pode optar por receber uma notificação por e-mail com os detalhes da mesma e/ou descarregar um pdf. Além disso, os clientes podem acompanhar o estado das suas reservas — futuras, a decorrer ou passadas — diretamente a partir do seu painel de cliente, onde pode descarregar o pdf e receber um e-mail com os detalhes da reserva que selecionar.

## 🛠 Softwares Necessários para a Instalação
Antes de clonar o projeto, certifique-se de ter instalado:
- **Git** → Controle de versões e clonagem do repositório  
- **PHP 8.2+** → Para rodar Laravel  
- **MySQL ou MariaDB** → Banco de dados do projeto  
- **Laravel CLI** → Facilita execução de comandos no framework  

## 🔧 Instalação
Clonar repositório e configurar o projeto:
```bash
git clone <URL-do-repositorio>
cd chat
composer install
composer update
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed --class=ImagemSeeder
npm run dev
php artisan serve
```

## Habilitação de Funcionalidades: PDF, PayPal e E-mail
Para garantir o pleno funcionamento do sistema, especialmente em funcionalidades como geração de PDF, pagamentos e envio de e-mails, siga as instruções abaixo:

### Geração de PDF com imagem
Para permitir a geração de PDFs com imagens incorporadas, é necessário habilitar a extensão gd no PHP.
No arquivo php.ini, localize e descomente a seguinte linha:
```ini
extension=gd
```
Após isto, reinicie o servidor para aplicar as alterações.

### Integração com PayPal
Para ativar o serviço de pagamentos via PayPal, adicione as suas credenciais no `.env` do projeto.
Certifique-se de incluir as chaves corretas de ambiente fornecidas pela sua conta PayPal Developer.
Em `.env.example`, encontram-se os nomes das variáveis referenciados no projeto.

### Serviço de E-mail
O envio automático de notificações por e-mail requer a configuração de um provedor SMTP no `.env`.
Durante o desenvolvimento deste projeto, foi utilizado o serviço `Brevo`, mas é compatível com qualquer provedor SMTP.
Em `.env.example`, encontram-se os nomes das variáveis referenciados no projeto.

## 📄 Licença
Sinta-se à vontade para usá-lo e melhorá-lo!



