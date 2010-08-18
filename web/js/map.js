var Map = function(container, center, zoom) {

  var self = this;

  var _markers = [];
  var _points = [];

  // контейнер карты
  var _container = container;

  // увеличение по-умолчанию
  var _zoom = zoom;

  // начальная позиция по-умолчанию
  var _point = new GLatLng(center[0], center[1]);

  // карта
  var _gmap = new GMap2(document.getElementById(_container));

  // текущий маркер
  var _marker = null;

  // менеджер маркеров
  var _manager = null;

  // слои карт
  var _layers = [];

  // балун маркера
  var _markerInfo = function(index) {
    if (_markers[index]) {
      $.ajax({
        url: '/map/info',
        dataType: 'html',
        data: { id: _points[index].id },
        success: function(response) {
          _markers[index].openInfoWindow(response);
        },
        error: function() {
          notice.error('Не удалось загрузить описание объекта');
        }
      });

    } else {
      notice.error('Нет информации об этом объекте');
    }
  };

  // инициализация карты
  var _init = function() {
    
    _gmap.setMapType(G_SATELLITE_MAP);
    _gmap.setUIToDefault();

    self.restorePosition();
    
    _manager = new MarkerManager(_gmap, { trackMarkers: true });

    var defaultIcon = new GIcon();
    defaultIcon.image = '/images/marker/9.png';
    defaultIcon.shadow = '';
    defaultIcon.iconSize = new GSize(24, 37);
    defaultIcon.iconAnchor = new GPoint(12,37);

    _marker = new GMarker(new GPoint(0, 0), { icon: defaultIcon, draggable: true });
    _gmap.addOverlay(_marker);


    GEvent.addListener(_gmap, 'moveend', self.savePosition);
    GEvent.addListener(_gmap, 'zoomend', self.savePosition); 
    GEvent.addListener(_gmap, 'maptypechanged', self.savePosition);

  };

  self.savePosition = function() {
      var center = _gmap.getCenter();
      $.cookie('gmap_lat', center.lat());
      $.cookie('gmap_lng', center.lng());
      $.cookie('gmap_zoom', _gmap.getZoom());
  };

  self.restorePosition = function() {
      var lat = $.cookie('gmap_lat') ? $.cookie('gmap_lat') : _point.lat();
      var lng = $.cookie('gmap_lat') ? $.cookie('gmap_lng') : _point.lng();
      var zoom = $.cookie('gmap_zoom') ? parseInt($.cookie('gmap_zoom')) : _zoom;

      _gmap.setCenter(new GLatLng(lat, lng), zoom);
  }

  // GMap
  self.getMap = function() {
	  return _gmap;
  };
  
  self.getMarker = function() {
	  return _marker;
  };

  self.markerPosition = function(point) {
	  _marker.setLatLng(point);
	  //_gmap.addOverlay(_marker);

	  return self;
  };

  self.markerShow = function() {
	  _marker.show();
	  
	  return self;
  };

  self.markerHide = function() {
	  _marker.hide();
	  
	  return self;
  };

  // загрузка объектов
  self.loadPoints = function() {
    _gmap.clearOverlays();

    $.ajax({
      url: '/map/points?sf_format=json&t='+Math.random(),
      dataType: 'json',
      success: function(points) {

        _points = points;
        _markers = [];

        for(var i = 0; i < points.length; i++) {

          if (points[i].category) {
            var icon = new GIcon();
            icon.image = points[i].category.icon;
            icon.iconAnchor = new GPoint(16, 16);
            icon.infoWindowAnchor = new GPoint(16, 0);
            icon.iconSize = new GSize(32, 32);
          } else {
            var icon = null;
          }

          _markers[i] = new GMarker(new GLatLng(points[i].geo_lat, points[i].geo_lng), { 'icon': icon });
          GEvent.addListener(_markers[i], 'click', function(index){ return function(){ _markerInfo(index); }; }(i));
        }

        _manager.addMarkers(_markers, 15);
        _manager.refresh();
      },
      error: function() {
        notice.error('Не удалось загрузить объекты на карте');
      }

    });
  };

  _init();
};

var map = null;
var marker = null;
var infowindow = null;
