function addToCollage(resource, canvas) {
	"use strict";
	//var imgElement = document.getElementById(ID);
	var imgInstance = new fabric.Image(resource, {
		left: 100,
		top: 100,
		width: 128,
		height: 128
	});
	canvas.add(imgInstance);
}

function saveImage(canvas) {
	"use strict";
	//var canvas = document.getElementById("canvas");
	var jsonCanvas = canvas.toDatalessJSON();
	var canvasDataUrl = canvas.toDataURL();
	canvas.clear();
	canvas.backgroundImage = false;
	canvas.backgroundColor = false;
	canvas.renderAll();
	$.ajax({
		type: "POST",
		url: "/collage/savePng.php",
		//url: "/collage/savePng.php",
		data: {design: canvasDataUrl, jcanvas: jsonCanvas}
	})
		.done(function (response) {
			var preview = document.getElementById("saves");
			//var img = JSON.parse(response);
			preview.innerHTML = "<img src=" + response + " class='saves' onclick='setAs(this, canvas)'>";
		})
		.fail(function (response) {console.log("fail"); })
		.always(function (response) {console.log("always"); });

}

function setAs(img, canvas) {
	"use strict";
	//var canvas = new fabric.Canvas("canvas");
	canvas.setBackgroundImage(img.src, canvas.renderAll.bind(canvas), {
		// Needed to position backgroundImage at 0/0
		originX: 'left',
		originY: 'top'
	});
}

function setBackground(color, canvas) {
	"use strict";
	canvas.backgroundColor = color.id;
	canvas.renderAll();
}

function addShape(shape, canvas) {
	"use strict";
	var selected = document.getElementById("fillColor");
	var fillColor = selected.options[selected.selectedIndex].value;
	if (fillColor === "") {
		fillColor = "black";
	}
	switch (shape.id) {
	case "circle": 
		var circle = new fabric.Circle({ radius: 50, left: 100, top: 100, fill: fillColor});
		canvas.add(circle);
	break;			
	case "rectangle": 
		var rectangle = new fabric.Rect({left: 100, top: 100, width: 50, height: 50, fill: fillColor});
		canvas.add(rectangle);
	break;			
	case "triangle": 
		var triangle = new fabric.Triangle({left: 100, top: 100, width: 50, height: 50, fill: fillColor});
		canvas.add(triangle);
	break;				
	}
}

function addText(canvas) {
	"use strict";
	var msgText = document.getElementById("msg").value;
	var textBox = new fabric.Text(msgText, { left: 100, top: 100 });
	canvas.add(textBox);
}