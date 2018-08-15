var container = document.getElementById('container-hide');
var containerDop	=	document.getElementById('painSection1');
var menu = document.getElementById('menuSection');

function showContainer(){
	console.log('suka')
	container.style.height = 'auto';
	menu.style.display = 'block'
}
function showPainContainer(){
	console.log('suka')
	containerDop.style.height = 'auto';
	menu.style.display = 'block'
}
function changeBtn1(){
	document.getElementById('f-block').className = 'radius-block';
	document.getElementById('s-block').className = 'second-block';
}
function changeBtn2(){
	document.getElementById('s-block').className = 'radius-block';
	document.getElementById('f-block').className = 'second-block';
}