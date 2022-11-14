
const selectElement = document.querySelector('.name_insurer');


selectElement.addEventListener('change', (event) => {

    $.ajax({
      type: 'get',
      url: 'index.php?controller=Insurance&action=insurerServices',
      data: {name_insurer: event.target.value},
      success: function(response) {
        $('#checkbox').empty();
        $.each(JSON.parse(response), function(i, record) { 
          $('#checkbox').append('<input type="checkbox" name="checkbox[]" value="'+ record['name'] + '" />').append('<label for="checkbox">'+record['name']+'</label><br>');
        });
         
      }
  });

});
