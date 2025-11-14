jQuery(function($){
  console.log('MBP frontend script loaded');
  // Example: attach to form submission events
  $(document).on('submit', 'form', function(){
    // do something
    console.log('A form was submitted on the page');
  });
});
