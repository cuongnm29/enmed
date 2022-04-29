function generateChartData() {
    var chartData = [];
    $.ajax({
        type: "get",
        url: "/showmap",
        async: false,
        contentType: "application/json",
        dataType: 'json',
        success: function(res) {
            $.each(res, function(key, value) {
                chartData.push(
                    {
                        title: value.name,
                        latitude: value.latitude,
                        longitude:value.longitude,
                        id:value.id
                    }
                );    
            });
        }
    });
       return chartData;
    }
am4core.ready(function() {
var mapData =  generateChartData(); 
am4core.useTheme(am4themes_animated);
// Themes end
// Create map instance
var chart = am4core.create("chartdiv", am4maps.MapChart);
// Set map definition
chart.geodata = am4geodata_worldLow;
// Set projection
chart.projection = new am4maps.projections.Miller();
chart.zoomDuration = 0;
chart.zoomControl = new am4maps.ZoomControl(20);
// Create map polygon series
var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
// Exclude Antartica
polygonSeries.exclude = ["AQ"];
// Make map load polygon (like country names) data from GeoJSON
polygonSeries.useGeodata = true;

// Configure series
var polygonTemplate = polygonSeries.mapPolygons.template;
polygonTemplate.tooltipText = "{name}";
polygonTemplate.fill = chart.colors.getIndex(0).lighten(0.5);

// Create hover state and set alternative fill color
var hs = polygonTemplate.states.create("hover");
hs.properties.fill = chart.colors.getIndex(0);

// Add image series
var imageSeries = chart.series.push(new am4maps.MapImageSeries());

imageSeries.mapImages.template.propertyFields.longitude = "longitude";
imageSeries.mapImages.template.propertyFields.latitude = "latitude";
imageSeries.data =mapData;

// add events to recalculate map position when the map is moved or zoomed
chart.events.on( "ready", updateCustomMarkers );
chart.events.on( "mappositionchanged", updateCustomMarkers );

// this function will take current images on the map and create HTML elements for them
function updateCustomMarkers( event ) {
  
  // go through all of the images
  imageSeries.mapImages.each(function(image) {
    // check if it has corresponding HTML element
    if (!image.dummyData || !image.dummyData.externalElement) {
      // create onex
      image.dummyData = {
        externalElement: createCustomMarker(image)
      };
    }

    // reposition the element accoridng to coordinates
    var xy = chart.geoPointToSVG( { longitude: image.longitude, latitude: image.latitude } );
    image.dummyData.externalElement.style.top = xy.y + 'px';
    image.dummyData.externalElement.style.left = xy.x + 'px';
  });

}

// this function creates and returns a new marker element
function createCustomMarker( image ) {
  
  var chart = image.dataItem.component.chart;

  // create holder
  var holder = document.createElement('a');
  holder.className = 'map-marker';
  holder.title = image.dataItem.dataContext.title;
  holder.href = "/agent/"+ image.dataItem.dataContext.id;
  holder.style.position = 'absolute';

  // maybe add a link to it?
  if ( undefined != image.url ) {
    holder.onclick = function() {
      window.location.href = image.url;
    };
    holder.className += ' map-clickable';
  }

  // create dot
  var dot = document.createElement( 'div' );
  dot.className = 'dot';
  holder.appendChild( dot );

  // create pulse
  var pulse = document.createElement( 'div' );
  pulse.className = 'pulse';
  holder.appendChild( pulse );

  // append the marker to the map container
  chart.svgContainer.htmlElement.appendChild( holder );

  return holder;
}

});