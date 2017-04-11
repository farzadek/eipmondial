$(window).scroll(collapseNavbar);
$(document).ready(collapseNavbar);

ccc1=0;
ccc2=0;
ccc3=0;
ccc4=0;
turn = true; 
function collapseNavbar() {
    if ($(".navbar").offset().top > 50) {
        $(".navbar-fixed-top").addClass("top-nav-collapse");
    } else {
        $(".navbar-fixed-top").removeClass("top-nav-collapse");
    }
    //console.log(window.pageYOffset);

    if(turn){
        if(window.innerWidth > 1200 && window.pageYOffset>50){
            turn = false;
            timing();
        }
        if( window.innerWidth < 1200 && window.innerWidth > 770 && window.pageYOffset>140){
            turn = false;
            timing();
        }
        if( window.innerWidth < 770 && window.pageYOffset>50){
            turn = false;
            timing();
        }
    }

}
        /*  */
function timing(){
                cn1 = setInterval(function(){
                document.getElementById("cnt1").innerHTML = checkTime(ccc1);
                if(ccc1<44){ccc1+=1;}
                else{clearInterval(cn1);}
                },100);
            cn2 = setInterval(function(){
                document.getElementById("cnt2").innerHTML = '$'+checkTime(ccc2)+'K';
                if(ccc2<182){ccc2+=1;}
                else{clearInterval(cn2);}
                },27);
            cn3 = setInterval(function(){
                document.getElementById("cnt3").innerHTML = ccc3;
                if(ccc3<5){ccc3+=1;}
                else{clearInterval(cn3);}
                },850);
            cn4 = setInterval(function(){
                document.getElementById("cnt4").innerHTML = ccc4;
                if(ccc4<11){ccc4+=1;}
                else{clearInterval(cn4);}
                },420);
}
function checkTime(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}



// jQuery for page scrolling feature - requires jQuery Easing plugin

$(function() {
    $('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 1500, 'easeInOutExpo');
        event.preventDefault();
    });
});

// Closes the Responsive Menu on Menu Item Click 
$('.navbar-collapse ul li a').click(function() {
  if ($(this).attr('class') != 'dropdown-toggle active' && $(this).attr('class') != 'dropdown-toggle') {
    $('.navbar-toggle:visible').click();
  }
});

function closeLoginWindow(){
    document.getElementById("loginWindow").style.display = 'none';
}
function openLoginWindow(){
    document.getElementById("loginWindow").style.display = 'block';
}

function exch(pts,vps){
	document.getElementById('ptexch').style.display = 'inherit';
	document.getElementById('bkop').style.display = 'inherit';
	document.getElementById('t').innerHTML = vps+'<br/>'+pts;
}
function closePtexch(){
	document.getElementById('ptexch').style.display = 'none';	
	document.getElementById('bkop').style.display = 'none';
}
function carrier(){
	var x = document.getElementById('carrier');
	if(x.style.display == 'none' || x.style.display == ''){x.style.display = 'block';}
	else{x.style.display = 'none';}
}
function actual(){
	var x = document.getElementById('actualite');
	if(x.style.display == 'none' || x.style.display == ''){x.style.display = 'block';}
	else{x.style.display = 'none';}
}

