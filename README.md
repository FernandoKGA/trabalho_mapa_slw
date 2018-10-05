# Trabalho de Soluções Web

Trabalho final para a matéria de Soluções Web, o intuito do trabalho é criar uma aplicação Web de uma mapa interativo, baseada em Software Livre.

## Acesso ao servidor na AWS

Para conseguir acesso ao servidor remoto da AWS instaurado pelo professor para uso do grupo deve-se possuir uma chave de segurança para acessar o servidor remotamente que foi fornecida pelo professor.

O acesso deve ser feito por SSH para poder entrar no servidor, para acessar o site é só usar o link: [Site do Projeto](https://g5.each3.tk).

Este acesso pode ser feito tanto via Linux, MacOS quanto por Windows, porém para Windows existe um outro procedimento para que possa ser feito o acesso, utilizando um programa chamado **PuTTY**. Os outros se utilizando da linha de comando dos próprios terminais existentes em seus sistemas.

### Instalação e Utilização do PuTTY

O **PuTTY** deve ser instalado de acordo com a versão do Windows que se está utilizando.

Link para download: [PuTTY v0.70](https://www.chiark.greenend.org.uk/~sgtatham/putty/latest.html)

A instalação do PuTTY é muito simples, basta se rodar o instalador e colocar em um diretório de preferência.

Após isso, devemos configurar o nosso PuTTY para que ele possa fazer o acesso ao servidor que desejamos conectar. A configuração pode ser encontrada de forma simples neste link (em inglês): [SSH - PuTTY on Windows](https://www.ssh.com/ssh/putty/windows/). Lembrando que o PuTTY exige que se crie uma chave privada para o programa dele para se fazer o acesso, isso pode ser feito através de um dos executáveis do próprio PuTTY, o **PuTTYGen** que cria esta chave exigida pelo programa, explicado no seguinte guia: [Use PuTTY to access EC2 Linux Instances via SSH from Windows](https://linuxacademy.com/howtoguides/posts/show/topic/17385-use-putty-to-access-ec2-linux-instances-via-ssh-from-windows).

### Transferência de arquivos para o servidor

A transferência de arquivos entre cliente e servidor também deve ser feita por uma das aplicações do PuTTY, chamada **PSCP**, para que isso seja possível é necessário que o PuTTY já esteja configurado corretamente. Para a transferência, deve ser executado por linha do comando o seguinte comando:

    pscp -v -4 -i caminho\para\onde\a\chave\esta\chave.ppk 
    caminho\arquivo\a\ser\enviado\algo.extensao 
    g5@g5.each.tk:/home/g5/web/html/

O caminho /home/g5/web/html foi descoberto pelo UNIX usando o comando *echo $PATH* e verificando qual o caminho para que leve ao diretório. Link: [Printando o caminho](https://www.cyberciti.biz/faq/howto-print-path-variable/).
