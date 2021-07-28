function initMap(){

	//DECLARANDO CONTANTES.
	const parametros = Joomla.getOptions('params');
	const mapCentro = {lat: Number(parametros.latitude, lng: Number(parametros.longitude))};

	var mapTypeIds = [];

	//DEFINIR OS TIPOS DE MAPAS QUE PODEM SER MOSTRADOS = ESTRADA OU SATÉLITE.
	for(var type in google.maps.MapTypeId){
		mapTypeIds.push(google.maps.MapTypeId[type]);
	}

	//DESENHAR O MAPA.
	var map = new google.maps.Map(document.getElementById('map'), {

		center: mapCentro,
		zoom: Number(params.zoom),
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		mapTypeControlOptions: {mapTypeIds: mapTypeIds}, streetViewControl: false, scrollwheel: true, gestureHandling: 'cooperative' 

	});

	//ADICIONAR O MARCADOR
	var marcador = new google.maps.InfoWindow({});
	marcador.addListener('click', function(){
		infoWindow.setContent(parametros.texto);
		infoWindow.open(map, marcador);
	});

}