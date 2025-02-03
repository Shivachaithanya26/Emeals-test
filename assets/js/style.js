$(document).ready(function(){
    $(".container").slick({
        dots: false,
        arrows: true,
        autoplay: true,
        autoplaySpeed: 8000,
        prevArrow: '.prevBtn',
        nextArrow: '.nextBtn',
        fade: false, /* true for fade animation */
        speed: 2000,
    });
           
    $(".nav-btn").click(function(){
        $(".menu").fadeIn(500);
        $(".nav-btn").css({
           'display':'none' 
        });
        $(".close-btn").css({
           'display':'block' 
        });
    });
         
    $(".close-btn").click(function(){
        $(".menu").fadeOut(500);
        $(".nav-btn").css({
           'display':'block' 
        });
        $(".close-btn").css({
           'display':'none' 
        });
    });    
    
        
    $(window).resize(function(){
        if($(window).width() >= 1080){
            if($('.menu').css('display') == 'none') {
                $('.menu').css('display','block');
            }
        }else{
            if($(window).width() <= 1080){
                if($('.menu').css('display') == 'block') {
                $('.menu').css('display','none');
                }
            }
        }
    });
        
        
    $(".list-name").click(
        function(){
            $(".sub-list", this).slideToggle();
        }
    )
    
        
    $(".sign-up-message .btn-btn").click(function(){
        $(".sign-up-form").fadeOut(500); 
        $(".sign-up-message").fadeOut(500);
        $(".login-form").fadeIn(500); 
        $(".login-message").fadeIn(500);
    });
        
    $(".login-message .btn-btn").click(function(){
        $(".sign-up-form").fadeIn(500); 
        $(".sign-up-message").fadeIn(500);
        $(".login-form").fadeOut(500); 
        $(".login-message").fadeOut(500);
    });
      
        
        
    $("#open").click(function(){
        $(".admin-nav").animate({
           'width':'200px', 
        }, 500);
        $("#open").css({
            'display':'none',
        });
        $("#close").css({
            'display':'block',
        });
    });
        
        
    $("#close").click(function(){
        $(".admin-nav").animate({
           'width':'0', 
        }, 500);
        $("#open").css({
            'display':'block',
        });
        $("#close").css({
            'display':'none',
        });
    });
        
    $(window).resize(function(){
        if($(window).width() >= 1080){
            if($('.admin-nav').css('width') <= '200px'){
                $('.admin-nav').css('width','10%');
            }
        }else{
         if($(window).width() <= 1080){
            if($('.admin-nav').css('width') >= '200px'){
                $('.admin-nav').css('width','0');
                }
            }   
        }    
        
    });    
        
        
    /*
    $('.menu-list-btn', this).click(function(){
        $('.menu-list-btn').css({
            'border-bottom':'none',
        });
        $(this).css({
            'border-bottom':'2px solid red',
        });
    })    
    */    
        
        
    });