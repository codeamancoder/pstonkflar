<div class="aday">
    <?=$ust_menu?>
    <div class="sayfa">
        <div id='calendar'></div>
    </div>
</div>

<script type='text/javascript' src='/static/fullcalendar.js'></script>
<script type='text/javascript'>

	$(document).ready(function() {
	
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month'
			},
			editable: false,
			events: [
				<? foreach($liste as $i=>$e): ?>
				<?=$i ? ',':''?>
				{
					title: '<?=$e->ad.' '.$e->soyad.' - '.$e->yetkili?>',
					start: new Date(<?=$e->yil?>,<?=$e->ay?>, <?=$e->gun?>,<?=$e->saat?>,<?=$e->dakika?>),
					end: new Date(<?=$e->yil?>,<?=$e->ay?>, <?=$e->gun?>,<?=$e->saat + floor(($e->dakika+20)/60)?>,<?=($e->dakika+20)%60?>),
			        allDay: false,
			        url : '?b=aday/mulakat/detay&id=<?=$e->id?>',
				}
			    <? endforeach; ?>
				
			]

		    ,
		    
		    	isRTL: false,
		    	firstDay: 1,
		    	monthNames: ["Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz","Ağustos","Eylül","Ekim","Kasım","Aralık"],
		    	monthNamesShort: ["Oca","Şub","Mar","Nis","May","Haz","Tem","Ağu","Eyl","Eki","Kas","Ara"],
		    	dayNames: ["Pazar","Pazartesi","Salı","Çarşamba","Perşembe","Cuma","Cumartesi"],
		    	dayNamesShort: ["Paz","Pzt","Sal","Çar","Per","Cum","Cmt"],
		    	buttonText: {
		    	  prev: "&nbsp;&#9668;&nbsp;",
		    	  next: "&nbsp;&#9658;&nbsp;",
		    	  prevYear: "&nbsp;&lt;&lt;&nbsp;",
		    	  nextYear: "&nbsp;&gt;&gt;&nbsp;",
		    	  today: "Bugün",
		    	  month: "Aylık",
		    	  week: "Haftalık",
		    	  day: "Günlük"},



		    	allDayText: "Bütün Gün"
			
		});


		$('#calendar a.fc-event').addClass('dialog').attr('w','4x4').attr('title','Mülakat Bilgileri');		
	});

	

</script>