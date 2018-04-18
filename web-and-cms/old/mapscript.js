// JavaScript Document
var map = AmCharts.makeChart("chartdiv", {

	"type": "map",
    "theme": "none",
    "pathToImages": "http://www.amcharts.com/lib/3/images/",

	"dataProvider": {
     "map": "worldLow",
		"getAreasFromMap": true
	},
	"areasSettings": {
		"autoZoom": false,
		"selectedColor": "#CC0000",
        "selectable": true
	},
	"smallMap": {}
});

map.addListener("clickMapObject", function (event) {
    document.getElementById("placeholder").innerHTML = '<img src="http://lorempixel.com/200/200/city/' + event.mapObject.title + '/" />';
});