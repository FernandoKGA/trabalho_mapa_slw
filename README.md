# Trabalho de Soluções Web

Trabalho final para a matéria de Soluções Web, o intuito do trabalho é criar uma aplicação Web de uma mapa interativo, baseada em Software Livre.

## Acesso ao servidor na AWS

Para conseguir acesso ao servidor remoto da AWS instaurado pelo professor para uso do grupo deve-se possuir uma chave de segurança para acessar o servidor remotamente que foi fornecida pelo professor.

O acesso deve ser feito por SSH para poder entrar no servidor, para acessar o site é só usar o link: [Site do Projeto](https://g5.each3.tk).

Este acesso pode ser feito tanto via Linux, MacOS quanto por Windows, porém para Windows existe um outro procedimento para que possa ser feito o acesso, utilizando um programa chamado **PuTTY**. Os outros se utilizando da linha de comando dos próprios terminais existentes em seus sistemas.

## Instalação e Utilização do PuTTY

O **PuTTY** deve ser instalado de acordo com a versão do Windows que se está utilizando.

Link para download: [PuTTY v0.70](https://www.chiark.greenend.org.uk/~sgtatham/putty/latest.html)

A instalação do PuTTY é muito simples, basta se rodar o instalador e colocar em um diretório de preferência.

Após isso, devemos configurar o nosso PuTTY para que ele possa fazer o acesso ao servidor que desejamos conectar. A configuração pode ser encontrada de forma simples neste link (em inglês): [SSH - PuTTY on Windows](https://www.ssh.com/ssh/putty/windows/). Lembrando que o PuTTY exige que se crie uma chave privada para o programa dele para se fazer o acesso, isso pode ser feito através de um dos executáveis do próprio PuTTY, o **PuTTYGen** que cria esta chave exigida pelo programa, explicado no seguinte guia: [Use PuTTY to access EC2 Linux Instances via SSH from Windows](https://linuxacademy.com/howtoguides/posts/show/topic/17385-use-putty-to-access-ec2-linux-instances-via-ssh-from-windows).

## Transferência de arquivos para o servidor

A transferência de arquivos entre cliente e servidor também deve ser feita por uma das aplicações do PuTTY, chamada **PSCP**, para que isso seja possível é necessário que o PuTTY já esteja configurado corretamente. Para a transferência, deve ser executado por linha do comando o seguinte comando:

    pscp -v -4 -i caminho\para\onde\a\chave\esta\chave.ppk
    caminho\arquivo\a\ser\enviado\algo.extensao
    g5@g5.each3.tk:/home/g5/web/html/

**Atenção**: Para que você transfira do servidor para a sua máquina, deve-se inverter o caminho, o endereço do arquivo no servidor deve vir primeiro e depois o caminho para onde você quer salvar na sua máquina, a primeira linha de instrução deve se manter igual, que é o comando para acesso e o local para onde está a chave.

O caminho /home/g5/web/html foi descoberto via GNU/Linux usando o comando *echo $PATH* e verificando qual o caminho para que leve ao diretório. Link: [Printando o caminho](https://www.cyberciti.biz/faq/howto-print-path-variable/). Pode-se também utilizar o comando: *pwd*, que facilita a identificação!

## Processo para acesso automático no MySQL

Para fazer acesso automático no **SGBD MySQL** se utiliza um arquivo de configuração que o próprio MySQL oferece a fim de colocar atributos de configurações personalizados como usuário, senha e outros. Como só queremos nos utilizar de usuário e senha para fazer um acesso rápido ao programa, criamos esse arquivo chamado de "*.my.cnf*", isso como o servidor é um sistema operacional GNU/Linux, e deixamos na pasta raiz de onde o projeto será executado e colocamos os seguintes comandos dentro dele:

    [client]
    user=g5
    password=37c965a8d6d7bec292c7b11ff315d9ea

Além disso precisamos modificar a visibilidade do arquivo para que somente o usuário veja, faremos isso usando o comando *chmod*:

    chmod 600 .my.cnf

Após isso poderemos utilizar o comando para entrar no MySQL sem precisar colocar nenhum parâmetro só executando:

    mysql

Se tudo estiver corretamente configurado, o comando deverá funcionar e você acessará o programa!

Referências:

* [Option-files - MySQL Documentation](https://dev.mysql.com/doc/refman/5.7/en/option-files.html)
* [How to auto-login in MySQL using Shell Scripts - StackOverflow](https://stackoverflow.com/questions/13814413/how-to-auto-login-mysql-in-shell-scripts)

## Instalação do Apache

## Instalação do PHP

## Instalação do Composer

Para que seja feita a instalação do Composer, é importante lembrar que ele serve como um instalador de pacotes (dependências) para a linguagem de programação PHP, ou seja, você deve possuir uma instância do PHP instalado na sua máquina para fazer uso deste programa.

* [Composer para iniciantes - Tableless](https://tableless.com.br/composer-para-iniciantes/)
* [Como instalar e utilizar o Composer - Hostinger](https://www.hostinger.com.br/tutoriais/como-instalar-e-usar-o-composer/#gref)
* [Where do I put Composer.json? - StackOverflow](https://stackoverflow.com/questions/22155554/where-do-i-put-composer-json)
* [Guzzle 6](http://docs.guzzlephp.org/en/stable/overview.html#requirements)
* [Monolog - Packagist](https://packagist.org/packages/monolog/monolog)