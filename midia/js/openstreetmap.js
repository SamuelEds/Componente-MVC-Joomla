
//CRIAR A VARIÁVEL PARA O MAPA.
var mapa;

//CRIAR VARIÁVEL PARA URL DO AJAX.
var ajaxurl;

jQuery(document).ready(function(){

	//OBTER OS DADOS PASSADOS DO PHP DO JOOMLA.
	/*O PARÂMETRO 'params' É UM OBJETO JAVASCRIPT COM PROPRIEDADES PARA A EXIBIÇÃO DO MAPA: 
	LATITUDE CENTRAL, LONGITUDE CENTRAL, ZOOM E TEXTO.*/
	const params = Joomla.getOptions('params');
	ajaxurl = params.ajaxurl;

	//SERÁ USADO O OPENLAYERS PARA DESENHAR O MAPA (MAAIS INFORMAÇÕES: http://openlayers.org/)

	//OPENLAYERS USA UM SISTEMA DE COORDENADAS X, Y PARA AS POSIÇÕES.
	//É PRECISO CONVERTER A LATITUDE/LONGITUDE EM UMA PAR X, Y QUE É RELATIVO.
	//À PROJEÇÃO DO MAPA QUE ESTÁ SENDO USADO: 'Spherical Mercator WGS 84'.

	//OBTER A LONGITUDE.
	const x = parseFloat(params.longitude);

	//OBTER A LATITUDE
	const y = parseFloat(params.latitude);
	const mapCentro = ol.proj.fromLonLat([x, y]); //'Spherical Mercator' É ASSUMIDO POR PADRÃO.

	/* 

	PARA DESENHAR O MAPA, O OPENLAYER PRECISA DE:
	
	1. UM ELEMENTO HTML DE DESTINO NO QUAL O MAPA É COLOCADO.
	
	2. UMA CAMADA DE MAPA, QUE PODE SER, POR EXEMPLO, UMA CAMADA 'Vector' COM DETALHES 
	DE POLÍGONOS PARA LIMITES DE PAÍS, LINHAS PARA ESTRADAS, ETC, OU UMA CAMADA DE MOSAICO,
	COM ARQUIVOS '.png' PARA CADA BLOCO DE MAPA (256x256 pixels).
	
	3. UMA VISUALIZAÇÃO, ESPECIFICANDO A PROJEÇÃO 2D DO MAPA (PADRÃO 'Spherical Mercator'),
	COORDENADAS DO CENTRO DO MAPA E NÍVEL DE ZOOM.  

	*/
	mapa = new ol.Map({
		target: 'map',
		layers:[

			//OBTER OS 'tiles' DO SERVIDOR OSM.
			new ol.layer.Tile({
				source: new ol.source.OSM()
			})

			],

		//PADRÃO 'Spherical Mercator'
		view: new ol.View({

			center: mapCentro,
			zoom: params.zoom

		})
	});

	//É ADICIONADO UM MARCADOR PARA A POSIÇÃO HELLOWORLD.
	//PARA FAZER ISSO, É ESPECIFICADO COMO UM 'Feature Point' E É ADICIONADO UM STYLE
	//PARA DEFINIR COMO ESTE RECURSO É APRESENTADO NO MAPA...
	var pontoHelloworld = new ol.Feature({geometry: new ol.geom.Point(mapCentro)});

	//... É DEFINIDO ABAIXO UMA 'ESTRELA' VERMELHA DE 5 PONTOS COM BORDA AZUL.
	const redFill = new ol.style.Fill({

		color: 'red'

	});
	const blueStroke = new ol.style.Stroke({

		color: 'blue',
		width: 3

	});

	const star = new ol.style.RegularShape({

		fill: redFill,
		stroke: blueStroke,
		points: 5,
		radius1: 20, //RAIO EXTERNO DA ESTRELA.
		radius2: 10, //RAIO INTERNO DA ESTRELA.

	})

	pontoHelloworld.setStyle(new ol.style.Style({

		image: star

	}));

	//AGORA É ADICIONADO O RECURSO AO MAPA POR MEIO DE UMA FONTE DE VETOR E UMA CAMADA DE VETOR.
	const vectorSource = new ol.source.Vector({});

	vectorSource.addFeature(pontoHelloworld);
	
	const vector = new ol.layer.Vector({
		source: vectorSource
	});
	mapa.addLayer(vector);

	//SE UM USUÁRIO CLICAR NA ESTRELA, É MOSTRADO O TEXTO HELLOWORLD.
	//O TEXTO IRÁ PARA OUTRO ELEMENTO HTML, COM ID = 'texto-container'.
	//E ISSO SERÁ MOSTRADO COMO UMA SOBREPOSIÇÃO NO MAPA.
	var overlay = new ol.Overlay({
		element: document.getElementById('texto-container'),
	});
	mapa.addOverlay(overlay);

	//FINALMENTE, É ADICIONADO O OUVINTE 'onclick' PARA EXIBIR O TEXTO QUANDO A ESTRELA É CLICADA.
	/* 

	A MANEIRA DE COMO ISSO FUNCIONA É QUE O OUVINTE 'onclick' É ANEXADO NO MAPA,
	E, EM SEGUIDA, DETERMINA QUAL RECURSO OU RECURSOS FOREM 'hintados' (ACIONADOS).

	*/
	mapa.on('click', function(e){

		let marcador = '';
		let posicao;

		mapa.forEachFeatureAtPixel(e.pixel, function(feature){

			marcador = params.texto;
			posicao = feature.getGeometry().getCoordinates();

		}, {hitTolerance: 5}); //TOLERÂNCIA DE 5 PIXELS

		if(marcador){
			document.getElementById('texto-container').innerHTML = marcador;
			overlay.setPosition(posicao);
		}else{

			overlay.setPosition(); //IRÁ OCULTAR A ESTRELA QUANDO O USUÁRIO CLICAR FORA DA ÁREA.

		}

	});

});

//ABAIXO ESTÃO AS FUNÇÒES PARA FAZER A SOLICITAÇÃO VIA AJAX.

//ESSA FUNÇÃO SERÁ CHAMADA NO ARQUIVO 'view.json.php'.
function getMapBounds(){

	var mercatorMapBounds = mapa.getView().calculateExtent(mapa.getSize());
	var latlngMapBounds = ol.proj.transformExtent(mercatorMapBounds, 'EPSG:3857', 'EPSG:4326');
	return {

		minlat: latlngMapBounds[1],
		maxlat: latlngMapBounds[3],
		minlng: latlngMapBounds[0],
		maxlng: latlngMapBounds[2]

	}

}

function searchHere(){

	var mapBounds = getMapBounds();
	var token = jQuery('#token').attr('name');

	//CRIAR A SOLICITAÇÃO AJAX.
	jQuery.ajax({

		/*

		OBSERVE QUE O PARÂMETRO 'format' ESTÁ RECEBENDO 'json' COMO VALOR.
		
		JOOMLA IRÁ PROCURAR PELO ARQUIVO 'view.json.php' POIS ESSE SERÁ A VIEW PRINCIPAL
		DO JSON. A CHAMADA DA VIEW ESTÁ CONFIGURADA NO CONTROLADOR PRINCIPAL.

		*/

		url: ajaxurl,
		data: { [token]: "1", task: "mapsearch", view: "helloworld", format: "json", mapBounds: mapBounds },
		success: function(result, status, xhr){ 
			displaySearchResults(result);
		},
		error: function(){
			console.log("Falha no Ajax");
		}

	});

}

function displaySearchResults(result){

	//CASO A SOLICITAÇÃO OBTER SUCESSO FARÁ UMA AÇÃO.
	if(result.success){
		
		//APRENSENTARÁ OS RESULTADOS.

		var html = "";
		
		for(var i = 0; i < result.data.length; i++){
			html += '<p><a href="' + $result.data[i].url +'">' 
			+ result.data[i].texto + '</a>' + ' @ ' 
			+ result.data[i].latitude + 
			result.data[i].longitude +'</p>';
		}

		jQuery('#searchresults').html(html);

	}else{

		//SENÃO, ENTÃO EXIBIRÁ UMA MENSAGEM DE ERRO.
		var msg = result.message;

		if((result.messages) && (result.messages.error)){

			for(var j = 0; j < result.messages.error.length; j++){

				msg += "<br/>" + result.messages.error[j];

			}

		}

		jQuery('#searchresults').html(msg);

	}

}
