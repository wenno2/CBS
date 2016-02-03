/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$( document ).ready(function() {

     $('#tokenize').tokenize();
  
  
     $('#selectize').selectize({
        
        sortField: 'text',
        allowEmptyOption: false
     });
     
     $('.datepicker input').pickadate({
        // Escape any “rule” characters with an exclamation mark (!).
        format: 'dddd, dd mmm, yyyy',
        formatSubmit: 'yyyy-mm-dd',        
        hiddenName: true
        
        //hiddenSuffix: ''        
      });
}); 







