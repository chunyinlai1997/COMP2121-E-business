$(document).ready(function() {
  
  var scrollLink = $('.scroll');
  
  // Smooth scrolling
  scrollLink.click(function(e) {
    e.preventDefault();
    $('body,html').animate({
      scrollTop: $(this.hash).offset().top - 75
    }, 1000 );
  });
   
})  
  // Click link switching
$(function() {
   $("li").click(function() {
	   
      // remove classes from all
      $("li").removeClass("active");
      // add class to the one we clicked
      $(this).addClass("active");
      });	  
});

$(document).ready(function() {
  
  var scrollLink = $('.scroll2');
  
  // Smooth scrolling
  scrollLink.click(function(e) {
    e.preventDefault();
    $('body,html').animate({
      scrollTop: $(this.hash).offset().top - 75
    }, 1000 );
  });
  
})

$(window).scroll(function() {
	var scrollbarLocation = $(document).scrollTop()+180;
	var scrollLink = $('.activescroll');
	scrollLink.each(function() {	  
	  var sectionOffset = $(this.hash).offset().top;
	  if ( sectionOffset <= scrollbarLocation) {
		$(this).parent().addClass('active');
		$(this).parent().siblings().removeClass('active');
	  }
	})	
 })
 
$('.navbar-nav a').on('click', function () {
        $(".navbar-toggle").click() 
});


