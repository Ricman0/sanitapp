
$(document).ready(function(){
  $('#headerMain').on('click', '#usersAreaPersonaleAmministratore', function(){
      inviaControllerTask('users', 'visualizza', '#contenutoAreaPersonale');
  }); 
  
  $('#headerMain').on('click', '#bloccatiAreaPersonaleAmministratore', function(){
      inviaControllerTask('users', 'bloccati', '#contenutoAreaPersonale');
  });
  
});

