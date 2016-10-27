
$(document).ready(function(){
	


	
	
	$('[data-toggle="modal"]').click(function(e) {
		e.preventDefault();
		var url = $(this).attr('href');
		if (url.indexOf('#') == 0) {
			$(url).modal('open');
		} 
		else 
		{
			$('#dialog').html('<br><br><center><img src="/static/v1/img/ajax.gif"></center>');
			$.get(url, function(data) {
				$('#dialog').html(data);
				$('#dialog').modal();
			}).success(function() { $('input:text:visible:first').focus(); });
		}
	});
	
	if( $('div.sonduyuru a').size()){
		$("div.sonduyuru").scrollable({circular: true,items:'.items', mousewheel: true}).autoscroll({
			interval: 10000		
		});
	}

	if( $('div.test-slider .items2 > div').size()) {
		$("div.test-slider").scrollable({circular: true,items:'.items2', mousewheel: true}).autoscroll({
			interval: 5000		
		});
	}
	
	
});

function pencere(w,h,t,a,r)
{
	dialog.dialog({width:w,height:h,title:t});
	if(r) dialog.dialog({close:r});
	dialog.load(a);
	dialog.dialog('open');
	return false;
}

function jsdogrula()
{
	var x=Math.floor((Math.random()*10000))+1000; 
	var r = prompt("İşleme devam etmek için onay kodunuzu kutucuğa giriniz. \n\nKodunuz : "+x) 
	
	if(r!=null)
	{
		if(r==x) return true; 
		else {
			alert("Girilen kod yanlış!");
			return jsdogrula();
		}
	}
	else return false;
}

