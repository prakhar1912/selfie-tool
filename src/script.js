$(window).ready(function(){
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
			  $('#preview').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	$("#fileToUpload").change(function() {
		readURL(this);
		$('#preview').fadeIn();
		$('#choose-file').css('display','none');
		$('.primary-container > h4').css('display','none');
		$('input[type="submit"]').slideDown();
	});
	var width = $('.criteria-container').outerWidth();
	$('.slide').css('width',width);
	var totalScore = {
		'headtilt': 0,
		'filter': 0,
		'lighting': 0,
		'body': 0,
		'teeth': 0,
		'camera': 0
	};
	var scores = {
		'crh': 1,
		'lh': 2,
		'ctu': 3,
		'f': 3,
		'nf': 1,
		'g': 3,
		'd': 1,
		'v': 1,
		'ff': 3,
		'cu': 1,
		'ws': 3,
		'cm': 1,
		'lth': 3,
		'up': 1,
		'vh': 1
	};
	var progress = 0;
	$('.option .checkbox').on('click',function(){
		$('.option .checkbox').removeClass('filled');
		$(this).addClass('filled');
		$(this).siblings('input[type="radio"]').trigger('click');
	});
	$('.slide button#next').on('click',function(){
		var selected = $(this).siblings('.option').children('input[type="radio"]:checked');
		var type = selected.attr('name');
		var value = selected.val();
		totalScore[type] = scores[value];
		if(!$(this).parent().hasClass('last')){
			$(this).parent().fadeOut(1000);
		}
		progress+=16.66;
		$('.progress-bar .progress').css('width',progress+"%");
	});
	function fadeOutLast(){
		$('.last').fadeOut(1000,function(){
			$('#social').slideDown();
		});
	}
	$('.last #next').on('click',function(){
		var finalScore = Math.trunc((((((totalScore['filter']*totalScore['headtilt'])+(totalScore['lighting']*totalScore['teeth']))/2)+(totalScore['body']*totalScore['camera']))/18.0)*100);
		$('#score').html(finalScore);
		localStorage.setItem('score',finalScore);
		$(this).css('pointer-events','none').html('<i class="fa fa-spinner fa-spin" style="color:white;margin-right: 10px"></i>Calculating score');
		setTimeout(function(){
			fadeOutLast();
		},5000);
	});
	$('#choose-file').on('click',function(event){
		event.preventDefault();
		$('#fileToUpload').trigger('click');
	});
});