jQuery(document).ready(function(){

	//OBTER OS DADOS PASSADOS DO PHP DO JOOMLA.
	/*O PARÂMETRO 'params' É UM OBJETO JAVASCRIPT COM PROPRIEDADES PARA A EXIBIÇÃO DO MAPA: 
	LATITUDE CENTRAL, LONGITUDE CENTRAL, ZOOM E TEXTO.*/
	const params = Joomla.getOptions('params');

	//SERÁ USADO O OPENLAYERS PARA DESENHAR O MAPA (MAIS INFORMAÇÕES: http://openlayers.org/)

	//OPENLAYERS USA UM SISTEMA DE COORDENADAS X, Y PARA AS POSIÇÕES.
	//É PRECISO CONVERTER A LATITUDE/LONGITUDE EM UMA PAR X, Y QUE É RELATIVO.
	//À PROJEÇÃO DO MAPA QUE ESTÁ SENDO USADO: 'Spherical Mercator WGS 84'.

	//OBTER A LONGITUDE.
	const x = parseFloat(params.longitude);

	//OBTER A LATITUDE.
	const y = parseFloat(params.latitude);

	//'Spherical Mercator' É ASSUMIDO POR PADRÃO.
	const mapCentro = ol.proj.fromLonLat([x, y]);

	/* 

	PARA DESENHAR O MAPA, O OPENLAYER PRECISA DE:
	
	1. UM ELEMENTO HTML DE DESTINO NO QUAL O MAPA É COLOCADO.
	
	2. UMA CAMADA DE MAPA, QUE PODE SER, POR EXEMPLO, UMA CAMADA 'Vector' COM DETALHES 
	DE POLÍGONOS PARA LIMITES DE PAÍS, LINHAS PARA ESTRADAS, ETC, OU UMA CAMADA DE MOSAICO,
	COM ARQUIVOS '.png' PARA CADA BLOCO DE MAPA (256x256 pixels).
	
	3. UMA VISUALIZAÇÃO, ESPECIFICANDO A PROJEÇÃO 2D DO MAPA (PADRÃO 'Spherical Mercator'),
	COORDENADAS DO CENTRO DO MAPA E NÍVEL DE ZOOM.  

	*/
	var map = new ol.Map({

		target: 'map',
		layers: [

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
	var helloworldPoint = new ol.Feature({geometry: new ol.geom.Point(mapCentro)});

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

	});

	helloworldPoint.setStyle(new ol.style.Style({
		image: star
	}));

	const vectorSource = new ol.source.Vector({});
	vectorSource.addFeature(helloworldPoint);

	const vector = new ol.layer.Vector({

		source: vectorSource

	});
	map.addLayer(vector);

	//SE UM USUÁRIO CLICAR NA ESTRELA, É MOSTRADO O TEXTO HELLOWORLD.
	//O TEXTO IRÁ PARA OUTRO ELEMENTO HTML, COM ID = 'texto-container'.
	//E ISSO SERÁ MOSTRADO COMO UMA SOBREPOSIÇÃO NO MAPA.
	var overlay = new ol.Overlay({

		element: document.getElementById('texto-container')

	});
	map.addOverlay(overlay);

	//FINALMENTE, É ADICIONADO O OUVINTE 'onclick' PARA EXIBIR O TEXTO QUANDO A ESTRELA É CLICADA.
	/* 

	A MANEIRA DE COMO ISSO FUNCIONA É QUE O OUVINTE 'onclick' É ANEXADO NO MAPA,
	E, EM SEGUIDA, DETERMINA QUAL RECURSO OU RECURSOS FOREM 'hintados' (ACIONADOS).

	*/
	map.on('click', function(e){

		let markup = '';
		let position;

		map.forEachFeatureAtPixel(e.pixel, function(feature){

			markup = params.texto;
			position = feature.getGeometry().getCoordinates();

		}, {hitTolerance: 5}); //TOLERÂNCIA DE 5 PIXELS

		if(markup){

			document.getElementById('texto-container').innerHTML = markup;
			overlay.setPosition(position);
		}else{

			overlay.setPosition(); //IRÁ OCULTAR A ESTRELA QUANDO O USUÁRIO CLICAR FORA DA ÁREA.

		}

	});

});