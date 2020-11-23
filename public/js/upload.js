     
      //ativado quando butao submit é clicado
      $(document).on('submit', 'form', function(e) {

        e.preventDefault();
        //recebe o valor dos input
        var input_nome_musica = $('#nome_musica').val();
        var input_nome_autor = $('#nome_autor').val();
        var input_arquivo = $('#arquivo').val();
        var extensao = input_arquivo.substr(-4);

        //verifica se não estao vazios
         if (input_nome_musica != '' && input_nome_autor != '' && input_arquivo != '') {
              ///verifica a extensao
              if(extensao == '.mp3'){
                //receber dados
                $form = $(this);
                var formdata = new FormData($form[0]);

                //criar a conexaão
                var request = new XMLHttpRequest();
          
                //pregress bar
                request.upload.addEventListener('progress', function (e){
                  var percent = Math.round(e.loaded / e.total * 100);
                  $form.find('.progress-bar').width(percent + '%').html(percent + '%');
                }); 
                //limpa a barra de proresso
                request.addEventListener('load', function(e) {
                  //no final do upload adciona a class bg-sucess para ficar verde e add o texto 'upload completo'
                  $form.find('.progress-bar').addClass('bg-success').html('Upload completo...');
                  //atualiza pagina
                  setTimeout("window.open(self.location, '_self');", 1000);
                });

                //arquivo responsavel por fazer o upload
                request.open('post', '/processaupload');
                request.send(formdata);
              }else {

                $('.alert').addClass('alert-danger');
                $('.alert').html('Erro! Só pode ser inseridos arquivos com a extensão <strong>.mp3</strong>');
              }    

        }else {

          $('.alert').addClass('alert-danger');
          $('.alert').html('Por favor, <strong>preencha</strong> todos os campos!!!');

        }

      })
