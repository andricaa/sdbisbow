
//load default view
var request = new XMLHttpRequest();
var default_view_container = document.getElementById("default-view");
var holder = document.getElementById("holder");
var default_view;
var range = "1_5";
var c;


function requestData(range){
request.open('GET', 'http://localhost/sdbis/public/api/defaultview/'+range);


		request.onload = function (){
				 default_view = JSON.parse(request.responseText);
				 renderHTML(default_view);
			};

			request.send();
};


//render data
requestData(range);


function renderHTML(data){


	
	var HTMLString = "";

		
		while (default_view_container.firstChild) {
	    default_view_container.removeChild(default_view_container.firstChild);
		}



	for (var i = 0; i < data.length; i++) {
		HTMLString += "<div class='row row-default'> <div class='col-xs-3'>" +
							" <img class='img-responsive img-default-view' src="+data[i].image_url+" '> </div>" 
						   +"<div class ='col-xs-7'> <h4 onclick='detailView("+data[i].specie_id+")'>"+data[i].l_name+"</h4>"+ data[i].description + "</div>" 
						   +"<div class = 'col-xs-2'> <h3>Tasectomy:</h3><ul class='list-group'>"

						   		+"<li class=''>Familiy</li>"
						   		+"<li class=''>"+data[i].family+"</li>"

						   		+"<li class=''>Genus</li>"
						   		+"<li class=''>"+data[i].genus+"</li>"

						   		+"<li class=''>Origin</li>"
						   		+"<li class=''>"+data[i].origin+"</li>"

						   +"</ul></div>"
					 + "</div></div>";
		
	}

	default_view_container.insertAdjacentHTML('beforeend', HTMLString);


};


//number species

var cRequest = new XMLHttpRequest();
cRequest.open('GET', 'http://localhost/sdbis/public/api/counts');

cRequest.onload = function (){
		var nOfSpecies = JSON.parse(cRequest.responseText);
};

cRequest.send();

// navigator

var btnPrev = document.getElementById("previous");
var btnNext = document.getElementById("next");




//search by keyword


var qSearch = document.getElementById("qSearch");


qSearch.addEventListener("keydown", function(e){

	 if (e.keyCode === 13) { 

	 	var searchBy = document.getElementById("qSearch").value;
        console.log(searchBy);
        requestQSData(searchBy); 
        

    };

 
});




function requestQSData(keyword){

		var qsRquest = new XMLHttpRequest();
		qsRquest.open('GET', 'http://localhost/sdbis/public/api/quick-search/'+keyword);

		qsRquest.onload = function (){
				var sqresult = JSON.parse(qsRquest.responseText);
				renderHTML(sqresult);	
		};

		qsRquest.send();
};




function advancedSearch(){


};

function detailView(id){
	console.log(id);
	var detailV = new XMLHttpRequest();
		detailV.open('GET', 'http://localhost/sdbis/public/api/detail-view/'+id);

		detailV.onload = function (){
				var result = JSON.parse(detailV.responseText);
				while (default_view_container.firstChild) {
			    default_view_container.removeChild(default_view_container.firstChild);
				}
				renderDetailVIew(result);
				console.log(result);
		};

		detailV.send();

}


function renderDetailVIew(data){

		var HTMLString ="<row>"
								+"<div class ='col-md-7'>  <h3>Description</h3>"+data[0].description+"</div>"
								 +"<div class = 'col-md-3'> <h3>Details:</h3><ul class='list-group'>"

						   		+"<li class=''>Name</li>"
						   		+"<li class=''>"+data[0].r_name+"</li>"

						   		+"<li class=''>Conservation</li>"
						   		+"<li class=''>"+data[0].conservation+"</li>"

						   		+"<li class=''>Soil</li>"
						   		+"<li class=''>"+data[0].soil+"</li>"

						   		+"<li class=''>Termic Resistance</li>"
						   		+"<li class=''>"+data[0].termic_resistance+"</li>"

						   +"</ul></div>"
						   +"</row>"


						+"<row id='botrow'>"
							+"<div class ='col-md-3 img-detail'><img class='img-responsive img-detail-view' src="+data[0].image_url+" '></div>"
							+"<div class ='col-md-3 img-detail'><img class='img-responsive img-detail-view' src="+data[0].images[0].image_url+" '></div>"
							+"<div class ='col-md-3 img-detail'><img class='img-responsive img-detail-view' src="+data[0].images[0].image_url+" '></div>"
						+"</row>"
						+"<row>"
						+"<div class ='col-md-10'>  <h3>Info</h3>"+data[0].description+"</div>"
						+"</row>";


						
		default_view_container.insertAdjacentHTML('beforeend', HTMLString);

}