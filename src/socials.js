function getFBUrl(){
	$.ajax({
		url: '/wp-content/plugins/selfie-tool/src/facebook/entry.php',
		type: 'GET',
		data:{ request: 'fetchURL'}
	}).done(function(response){
		var url = response.replace(/&amp;/g,'&');
		$('#social #facebook').attr('href',url);
	});
}
function getTwitterUrl(){
	$.ajax({
		url: '/wp-content/plugins/selfie-tool/src/twitter/entry.php',
		type: 'GET',
		data:{ request: 'fetchURL'}
	}).done(function(response){
		var url = response.replace(/&amp;/g,'&');
		$('#social #twitter').attr('href',url);
	});
}
getFBUrl();
getTwitterUrl();
$('#social #facebook, #social #twitter').on('click',function(event){
	event.preventDefault();
	var href = $(this).attr('href');
	window.open(href ,'popup','width=600,height=600');
	return false;
});