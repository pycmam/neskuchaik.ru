var Map = function(container, center, zoom) {

  var self = this;

  var _markers = [];
  var _points = [];

  // контейнер карты
  var _container = container;

  // начальный зум
  var _zoom = zoom;

  // начальная позиция по-умолчанию
  var _point = new GLatLng(center[0], center[1]);

  // карта
  var _gmap = new GMap2(document.getElementById(_container));

  // текущий маркер
  var _marker = null;

  var _defaultPointZoom = 14;
  
  // места
  var _points = null;

  // менеджер маркеров
  var _manager = null;

  // слои карт
  var _layers = [];

  // иконки маркеров
  var _icons = {};

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
    _points = {};

    // инициализация иконок
    _icons['movable'] = new GIcon();
    _icons['movable'].image = '/images/marker/movable.png';
    _icons['movable'].shadow = '';
    _icons['movable'].iconSize = new GSize(24, 37);
    _icons['movable'].iconAnchor = new GPoint(12,37);

    _marker = new GMarker(new GPoint(0, 0), { 
        title: 'Перетащите маркер в нужное место',
        icon: _icons['movable'],
        draggable: true
    });
    _gmap.addOverlay(_marker);

    GEvent.addListener(_gmap, 'moveend', self.savePosition);
    GEvent.addListener(_gmap, 'zoomend', self.savePosition); 
    GEvent.addListener(_gmap, 'maptypechanged', self.savePosition);

  };

  // сохранить текущую позицию карты
  self.savePosition = function() {
      var center = _gmap.getCenter();
      $.cookie('gmap_lat', center.lat());
      $.cookie('gmap_lng', center.lng());
      $.cookie('gmap_zoom', _gmap.getZoom());
  };

  // восстановить позицию карты
  self.restorePosition = function() {
      var lat = $.cookie('gmap_lat') ? $.cookie('gmap_lat') : _point.lat();
      var lng = $.cookie('gmap_lat') ? $.cookie('gmap_lng') : _point.lng();
      var zoom = $.cookie('gmap_zoom') ? parseInt($.cookie('gmap_zoom')) : _zoom;

      _gmap.setCenter(new GLatLng(lat, lng), zoom);
  };

  // добавить иконку
  self.addIcon = function(name)
  {
      _icons[name] = new GIcon();
      _icons[name].image = '/images/marker/'+name+'.png';
      _icons[name].shadow = '';
      _icons[name].iconSize = new GSize(24, 37);
      _icons[name].iconAnchor = new GPoint(12,37);

      return self;
  };

  // получить иконку
  self.getIcon = function(name)
  {
      return _icons[name];
  }
  
  self.getMarker = function() {
      return _marker;
  };
  

  // установить точки на карте
  self.setPoints = function(points) {
      _points = points;

      for(id in points) {
          _manager.addMarker(points[id], _defaultPointZoom);
      }

      _manager.refresh();
  };

  self.getPoint = function(id) {
      return _points[id];
  };

  self.hasPoint = function(id) {
      return _points[id] !== undefined;
  };

  self.addPoint = function(point) {
      _manager.addMarker(point, _defaultPointZoom);
  };

  self.createPoint = function(latlng, pointTitle, pointIcon) {
      var point = new GMarker(latlng, {
          title: pointTitle,
          icon: pointIcon
      });
      _manager.addMarker(point, _defaultPointZoom);
      _manager.refresh;
      point.show();

      return point;
  };

  // GMap
  self.getMap = function() {
      return _gmap;
  };

  _init();
};

var map = null;
var marker = null;
var infowindow = null;
