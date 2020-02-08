_colores=new Array();
_colores[0]="#BFCA4D";
_colores[1]="#8CB4C1";
_colores[2]="#95AB82";
_colores[3]="#BD905B";
_colores[4]="#D95B5B";
_colores[5]="#8162B4";

_catUR=new Object();
// Object.getOwnPropertyDescriptor(_catUR.UP,"001").value

document.addEventListener('DOMContentLoaded', function() {
	var elems = document.querySelectorAll('.fixed-action-btn');
	var instances = M.FloatingActionButton.init(elems);

    var elems = document.querySelectorAll('.modal');
    var instances = M.Modal.init(elems);

    var elems = document.querySelectorAll('.collapsible');
    var instances = M.Collapsible.init(elems,{
		accordion: false
	});
	

	$.get("https://storage.googleapis.com/nuestropresupuesto/UP_UR.json",function(resp){
		_catUR=resp
		params=getHashActual()
		if(params["v"]){
			$("#canvas").html('<div class="msg">Cargando datos <i class="fas fa-circle-notch fa-spin"></i></div>')
			updateAreaTrabajo()
		}else{
			$("#canvas").html('<div id="inicio" class="noReport"><h2>Bienvenid@ a #NuestroPresupuesto</h2><p>Para comenzar selecciona las versiones de presupuesto con las que quieres trabajar, utiliza el botón de la herramienta <i class="fas fa-cog"></i> que se localiza en el menú desplegable la dar clic en el logo:</p></div><img src="imgs/flechaInicio.svg" id="flechaInicio" class="noReport">')
		}
	},"json")
});


function number_format(nStr){
	nStr=parseFloat(nStr)
	nStr=Math.round(nStr*100)/100
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}


function goPresupuesto(v){
	window.location.href='/app#v:'+v
	setTimeout(function(){
		window.location.reload()
	}, 50)
}

function getHashActual(){
	var hash=window.location.hash
	hash=hash.replace("#", "")
	params=new Array()
	if(hash.length>0){
		hash=hash.split("|")
		for (i = 0; i < hash.length; i++){
			k=hash[i].substr(0, hash[i].indexOf(":"))
			v=hash[i].replace(k+":", "")
			params[k]=v
		}
	}
	return params
}

function setHash(params){
	hashValues=new Array()
	for (var k in params){
	    if (params.hasOwnProperty(k)) {
		    hashValues.push(k+":"+params[k])
	    }
	}
	window.location.hash="#"+hashValues.join("|")
}

function editPresupuestos(){
	pp=new Array()
	$("#modalPresupuestos .versionesDisponibles input:checked").each(function(){
		pp.push($(this).val())
	})
	params=getHashActual()
	params["pp"]=pp.join(",")
	params["a"]=$("#modalPresupuestos .aValoresDe input:checked").val()
	setHash(params)
}

function updateAniosModalPresupuestos(){
	$("#modalPresupuestos .versionesDisponibles input").each(function(){
		if($(this).is(":checked")){
			if($("#modalPresupuestos .aValoresDe li[data-anio='"+$(this).closest("li").attr("data-anio")+"']").length==0){
				$("#modalPresupuestos .aValoresDe").append('<li class="collection-item" data-anio="'+$(this).closest("li").attr("data-anio")+'"><label><input name="aValoresDe" type="radio" value="'+$(this).closest("li").attr("data-anio")+'" /><span>'+$(this).closest("li").attr("data-anio")+'</span></label></li>')
			}
			if($("#modalPresupuestos .aValoresDe input:checked").length==0){
				$("#modalPresupuestos .aValoresDe input:first-child").prop("checked",true)
			}
			$("#modalPresupuestos .aValoresDe li.mensaje").remove()
		}else{
			if($("#modalPresupuestos .versionesDisponibles li[data-anio='"+$(this).closest("li").attr("data-anio")+"'] input:checked").length==0){
				$("#modalPresupuestos .aValoresDe li[data-anio='"+$(this).closest("li").attr("data-anio")+"']").remove()
			}
			if($("#modalPresupuestos .aValoresDe li").length==0){
				$("#modalPresupuestos .aValoresDe").append('<li class="mensaje collection-item">Selecciona versiones de presupuesto de la columna izquierda</li>')
			}
		}
	})
}

function updateAreaTrabajo(){
	params=getHashActual()
	
	tipo=$("#versionesPresupuesto tr[data-id='"+params["v"]+"']").attr("data-tipo")
	$("#canvas").append('<div class="nota">Presupuestos a valores del '+$("#versionesPresupuesto tr[data-id='"+params["v"]+"']").attr("data-valores")+'</div>')
	treemap(params["v"])
}
/**************************************************
	Sunburst
	https://bl.ocks.org/vasturiano/12da9071095fbd4df434e60d52d2d58d
	************************************************/
function sunburst(){
    const width = window.innerWidth,
        height = window.innerHeight,
        maxRadius = (Math.min(width, height) / 2) - 5;

    const formatNumber = d3.format(',d');

    const x = d3.scaleLinear()
        .range([0, 2 * Math.PI])
        .clamp(true);

    const y = d3.scaleSqrt()
        .range([maxRadius*.1, maxRadius]);

    const color = d3.scaleOrdinal(d3.schemeCategory20);

    const partition = d3.partition();

    const arc = d3.arc()
        .startAngle(d => x(d.x0))
        .endAngle(d => x(d.x1))
        .innerRadius(d => Math.max(0, y(d.y0)))
        .outerRadius(d => Math.max(0, y(d.y1)));

    const middleArcLine = d => {
        const halfPi = Math.PI/2;
        const angles = [x(d.x0) - halfPi, x(d.x1) - halfPi];
        const r = Math.max(0, (y(d.y0) + y(d.y1)) / 2);

        const middleAngle = (angles[1] + angles[0]) / 2;
        const invertDirection = middleAngle > 0 && middleAngle < Math.PI; // On lower quadrants write text ccw
        if (invertDirection) { angles.reverse(); }

        const path = d3.path();
        path.arc(0, 0, r, angles[0], angles[1], invertDirection);
        return path.toString();
    };

    const textFits = d => {
        const CHAR_SPACE = 6;

        const deltaAngle = x(d.x1) - x(d.x0);
        const r = Math.max(0, (y(d.y0) + y(d.y1)) / 2);
        const perimeter = r * deltaAngle;

        return d.data.name.length * CHAR_SPACE < perimeter;
    };

    const svg = d3.select('#canvas').append('svg')
        .style('width', '100vw')
        .style('height', '100vh')
        .attr('viewBox', `${-width / 2} ${-height / 2} ${width} ${height}`)
        .on('click', () => focusOnSunburst()); // Reset zoom on canvas click

    d3.json('background?pp=1&t=OG&format=json', (error, root) => {
        if (error) throw error;

        root = d3.hierarchy(root);
        root.sum(d => d.size);

        const slice = svg.selectAll('g.slice')
            .data(partition(root).descendants());

        slice.exit().remove();

        const newSlice = slice.enter()
            .append('g').attr('class', 'slice')
            .on('click', d => {
                d3.event.stopPropagation();
                focusOnSunburst(d);
            });

        newSlice.append('title')
            .text(d => d.data.name + '\n' + formatNumber(d.value));

        newSlice.append('path')
            .attr('class', 'main-arc')
            .style('fill', d => color((d.children ? d : d.parent).data.name))
            .attr('d', arc);

        newSlice.append('path')
            .attr('class', 'hidden-arc')
            .attr('id', (_, i) => `hiddenArc${i}`)
            .attr('d', middleArcLine);

        const text = newSlice.append('text')
            .attr('display', d => textFits(d) ? null : 'none');

        // Add white contour
        text.append('textPath')
            .attr('startOffset','50%')
            .attr('xlink:href', (_, i) => `#hiddenArc${i}` )
            .text(d => d.data.name)
            .style('fill', 'none')
            .style('stroke', '#fff')
            .style('stroke-width', 5)
            .style('stroke-linejoin', 'round');

        text.append('textPath')
            .attr('startOffset','50%')
            .attr('xlink:href', (_, i) => `#hiddenArc${i}` )
            .text(d => d.data.name);
    });

	function focusOnSunburst(d = { x0: 0, x1: 1, y0: 0, y1: 1 }) {
	    // Reset to top-level if no data point specified
	
	    const transition = svg.transition()
	        .duration(750)
	        .tween('scale', () => {
	            const xd = d3.interpolate(x.domain(), [d.x0, d.x1]),
	                yd = d3.interpolate(y.domain(), [d.y0, 1]);
	            return t => { x.domain(xd(t)); y.domain(yd(t)); };
	        });
	
	    transition.selectAll('path.main-arc')
	        .attrTween('d', d => () => arc(d));
	
	    transition.selectAll('path.hidden-arc')
	        .attrTween('d', d => () => middleArcLine(d));
	
	    transition.selectAll('text')
	        .attrTween('display', d => () => textFits(d) ? null : 'none');
	
	    moveStackToFront(d);
	
	    //
	
	    function moveStackToFront(elD) {
	        svg.selectAll('.slice').filter(d => d === elD)
	            .each(function(d) {
	                this.parentNode.appendChild(this);
	                if (d.parent) { moveStackToFront(d.parent); }
	            })
	    }
	}

}

function treemap(visualizacion){
	var dataOriginal
	var montos=new Array()
	var montoTotal=0
	$("#canvas").append('<div id="chart" class="treemap"></div>')
	window.addEventListener('message', function(e) {
	    var opts = e.data.opts,
	        data = e.data.data;
	
	    return main(opts, data);
	});
	
	var defaults = {
	    margin: {top: 24, right: 0, bottom: 0, left: 0},
	    rootname: "TOP",
	    format: ",d",
	    title: "",
	    width: $("#canvas").width(),
	    height: $("#canvas").height()-15
	};

	function main(o, data) {
	  var root,
	      opts = $.extend(true, {}, defaults, o),
	      formatNumber = d3.format(opts.format),
	      rname = opts.rootname,
	      margin = opts.margin,
	      theight = 36 + 16;
	
	  $('#chart').width(opts.width).height(opts.height);
	  var width = opts.width - margin.left - margin.right,
	      height = opts.height - margin.top - margin.bottom - theight,
	      transitioning;
	  
	  var color = d3.scale.category20c();
	  
	  var x = d3.scale.linear()
	      .domain([0, width])
	      .range([0, width]);
	  
	  var y = d3.scale.linear()
	      .domain([0, height])
	      .range([0, height]);
	  
	  var treemap = d3.layout.treemap()
	      .children(function(d, depth) { return depth ? null : d._children; })
	      .sort(function(a, b) { return a.value - b.value; })
	      .ratio(height / width * 0.5 * (1 + Math.sqrt(5)))
	      .round(false);
	  
	  var svg = d3.select("#chart").append("svg")
	      .attr("width", width + margin.left + margin.right)
	      .attr("height", height + margin.bottom + margin.top)
	      .style("margin-left", -margin.left + "px")
	      .style("margin.right", -margin.right + "px")
	    .append("g")
	      .attr("transform", "translate(" + margin.left + "," + margin.top + ")")
	      .style("shape-rendering", "crispEdges");
	  
	  var grandparent = svg.append("g")
	      .attr("class", "grandparent");
	  
	  grandparent.append("rect")
	      .attr("y", -margin.top)
	      .attr("width", width)
	      .attr("height", margin.top);
	  
	  grandparent.append("text")
	      .attr("x", 6)
	      .attr("y", 6 - margin.top)
	      .attr("dy", ".75em");
	
	  if (opts.title) {
	    $("#chart").prepend("<p class='title'>" + opts.title + "</p>");
	  }
	  if (data instanceof Array) {
	    root = { key: rname, values: data };
	  } else {
	    root = data;
	  }
	    
	  initialize(root);
	  accumulate(root);
	  layout(root);
	  display(root);
	  
	  tabla()
	
	  if (window.parent !== window) {
	    var myheight = document.documentElement.scrollHeight || document.body.scrollHeight;
	    window.parent.postMessage({height: myheight}, '*');
	  }
	
	  function initialize(root) {
	    root.x = root.y = 0;
	    root.dx = width;
	    root.dy = height;
	    root.depth = 0;
	  }
	
	  // Aggregate the values for internal nodes. This is normally done by the
	  // treemap layout, but not here because of our custom implementation.
	  // We also take a snapshot of the original children (_children) to avoid
	  // the children being overwritten when when layout is computed.
	  function accumulate(d) {
	    return (d._children = d.values)
	        ? d.value = d.values.reduce(function(p, v) { return p + accumulate(v); }, 0)
	        : d.value;
	  }
	
	  // Compute the treemap layout recursively such that each group of siblings
	  // uses the same size (1×1) rather than the dimensions of the parent cell.
	  // This optimizes the layout for the current zoom state. Note that a wrapper
	  // object is created for the parent node for each group of siblings so that
	  // the parent’s dimensions are not discarded as we recurse. Since each group
	  // of sibling was laid out in 1×1, we must rescale to fit using absolute
	  // coordinates. This lets us use a viewport to zoom.
	  function layout(d) {
	    if (d._children) {
	      treemap.nodes({_children: d._children});
	      d._children.forEach(function(c) {
	        c.x = d.x + c.x * d.dx;
	        c.y = d.y + c.y * d.dy;
	        c.dx *= d.dx;
	        c.dy *= d.dy;
	        c.parent = d;
	        layout(c);
	      });
	    }
	  }
	
	  function display(d) {
	    grandparent
	        .datum(d.parent)
	        .on("click", transition)
	      .select("text")
	        .text(name(d));
	
	    var g1 = svg.insert("g", ".grandparent")
	        .datum(d)
	        .attr("class", "depth");
	
	    var g = g1.selectAll("g")
	        .data(d._children)
	      .enter().append("g");
	
	    g.filter(function(d) { return d._children; })
	        .classed("children", true)
	        .on("click", transition);
	
	    var children = g.selectAll(".child")
	        .data(function(d) { return d._children || [d]; })
	      .enter().append("g");
	
	    children.append("rect")
	        .attr("class", "child")
	        .call(rect)
	      .append("title")
	        .text(function(d) { return d.key + " (" + formatNumber(d.value) + ")"; });
	    children.append("text")
	        .attr("class", "ctext")
	        .text(function(d) { if(Object.getOwnPropertyDescriptor(_catUR.UR,""+d.key)){
			       return d.key+" "+Object.getOwnPropertyDescriptor(_catUR.UR,""+d.key).value 
		        }else if(Object.getOwnPropertyDescriptor(_catUR.ConG,""+d.key)){
			       return d.key+" "+Object.getOwnPropertyDescriptor(_catUR.ConG,""+d.key).value 
		        }else{
			        return decodeURI(escape(d.key)); // +"holiii"
		        }
		        
		        })// "Concepto "+d.key;
		    .attr("clave",function(d) { 
			    return d.key; // +"holiii"
		    })
	        .call(text2);
	
	    g.append("rect")
	        .attr("class", "parent")
	        .call(rect);
	
	    var t = g.append("text")
	        .attr("class", "ptext")
	        .attr("dy", ".75em")

	    t.append("tspan")
	        .text(function(d) { 
		        if(Object.getOwnPropertyDescriptor(_catUR.UR,""+d.key)){
			       return d.key+" "+Object.getOwnPropertyDescriptor(_catUR.UR,""+d.key).value 
		        }else if(Object.getOwnPropertyDescriptor(_catUR.ConG,""+d.key)){
			       return d.key+" "+Object.getOwnPropertyDescriptor(_catUR.ConG,""+d.key).value 
		        }else{
			        return decodeURI(escape(d.key)); // +"holiii"
		        }
		        });
		t.attr("clave",function(d) { 
			    return d.key; // +"holiii"
		    })
	    t.append("tspan")
	        .attr("dy", "1.2em")
	        .text(function(d) { return "$"+formatNumber(d.value); });
	    t.call(text);
	
	    g.selectAll("rect")
	        .style("fill", function(d) { return color(decodeURI(escape(d.key))); });
	
	    function transition(d) {
	      if (transitioning || !d) return;
	      transitioning = true;
	
	      var g2 = display(d),
	          t1 = g1.transition().duration(750),
	          t2 = g2.transition().duration(750);
	
	      // Update the domain only after entering new elements.
	      x.domain([d.x, d.x + d.dx]);
	      y.domain([d.y, d.y + d.dy]);
	
	      // Enable anti-aliasing during the transition.
	      svg.style("shape-rendering", null);
	
	      // Draw child nodes on top of parent nodes.
	      svg.selectAll(".depth").sort(function(a, b) { return a.depth - b.depth; });
	
	      // Fade-in entering text.
	      g2.selectAll("text").style("fill-opacity", 0);
	
	      // Transition to the new view.
	      t1.selectAll(".ptext").call(text).style("fill-opacity", 0);
	      t1.selectAll(".ctext").call(text2).style("fill-opacity", 0);
	      t2.selectAll(".ptext").call(text).style("fill-opacity", 1);
	      t2.selectAll(".ctext").call(text2).style("fill-opacity", 1);
	      t1.selectAll("rect").call(rect);
	      t2.selectAll("rect").call(rect);
	
	      // Remove the old node when the transition is finished.
	      t1.remove().each("end", function() {
	        svg.style("shape-rendering", "crispEdges");
	        transitioning = false;
	      });
	    }
	
	    return g;
	  }
	  
	  function tabla(){
		  if($('#tabla table').length==0){
			  $("#canvas").append("<div id='tabla' class='container'><div class='row'><div class='col s6 input-field'><input id='filtrarTabla' placeholder='Busca Unidad Responsable'></div></div><table data-orderby='UR' data-order='asc'><thead><tr><th data-tipo='UR'><label><input type=\"checkbox\" checked=\"\" id=\"check_all\" ><span> </span></label> <b>Unidad Responsable ↓</b></th><th  data-tipo='Monto'><b>Monto</b></th><th></th></tr></thead><tbody></tbody></table></div>")
			   for (let key in _catUR.UR){
				    if (_catUR.UR.hasOwnProperty(key)) {
					    if(montos[key]>0){
						    porcentaje=Math.round(montos[key]/montoTotal*100)
						    $("#tabla tbody").append('<tr><td class="UR"><label><input type="checkbox" checked="" id="check_'+key+'"><span>'+key+' - '+_catUR.UR[key]+'</span></label></td><td class="Monto">'+number_format(montos[key])+'</td><td>'+porcentaje+'%</td></tr>')
					    }
				    }
				}
				  
				
				var $table=$('#tabla table');
				
				var rows = $table.find('tbody tr').get();
				rows.sort(function(a, b) {
				var keyA = $(a).find('.UR').text();
				var keyB = $(b).find('.UR').text();
				if (keyA < keyB) return 1;
				if (keyA > keyB) return -1;
				return 0;
				});
				$.each(rows, function(index, row) {
				$table.children('tbody').prepend(row);
				});		
				
				$('#tabla table thead th b').click(function(){
					var $table=$('#tabla table');
					var param=$(this).closest("th").attr("data-tipo")
					var order="asc"
					if($("#tabla table").attr("data-orderby")==param){
						if($("#tabla table").attr("data-order")=="asc"){
							order="desc"
						}
					}
					$("#tabla table").attr("data-orderby",param)
					$("#tabla table").attr("data-order",order)
					var rows = $table.find('tbody tr').get();
					rows.sort(function(a, b) {
					var keyA = $(a).find('.'+param).text();
					var keyB = $(b).find('.'+param).text();
					if(param=="Monto"){
						keyA=keyA.replace("$", "")
						keyA=keyA.replace(/,/g, "")
						keyB=keyB.replace("$", "")
						keyB=keyB.replace(/,/g, "")
						keyA=parseFloat(keyA)
						keyB=parseFloat(keyB)
					}
					if(order=="asc"){
						if (keyA < keyB) return 1;
						if (keyA > keyB) return -1;
						return 0;
					}else{
						if (keyA < keyB) return -1;
						if (keyA > keyB) return 1;
						return 0;
					}
					});
					$.each(rows, function(index, row) {
					$table.children('tbody').prepend(row);
					});	
					
					$('#tabla table thead th[data-tipo="UR"] b').html('Unidad Responsable')	
					$('#tabla table thead th[data-tipo="Monto"] b').html('Monto')
					if(order=="asc"){
						$('#tabla table thead th[data-tipo="'+param+'"] b').html($('#tabla table thead th[data-tipo="'+param+'"] b').text()+" ↓")
					}else{
						$('#tabla table thead th[data-tipo="'+param+'"] b').html($('#tabla table thead th[data-tipo="'+param+'"] b').text()+" ↑")
					}
				})
				$("#tabla table tbody input[type='checkbox']").change(function(){
					updateGrafico()
				})
				$("#check_all").change(function(){
					  if($("#check_all").is(":checked")){
						  $("#tabla table input[type='checkbox']").prop("checked",true)
					  }else{
						  $("#tabla table input[type='checkbox']").prop("checked",false)
					  }
					  updateGrafico()
					
				})
				params=getHashActual()
				if(params["not"]){
					params["not"]=params["not"].split(",")
					for (i = 0; i < params["not"].length; i++){
						$("#tabla table #check_"+params["not"][i]).prop("checked",false)
					}
					updateGrafico()
				}
				$("#filtrarTabla").keyup(function(){
					if($(this).val().trim().length>0){
						$("#tabla table tbody tr").hide()
						$("#tabla table tbody tr").each(function(){
							if($(this).text().toUpperCase().indexOf($("#filtrarTabla").val().trim().toUpperCase())>=0){
								$(this).show()
							}
						})
					}else{
						$("#tabla table tbody tr").show()
					}
				})
		  }
	  }
	  
	  
	  function updateGrafico(){
		  datos=new Array()
		  for (i = 0; i < dataOriginal.length; i++){
			  datos[i]=dataOriginal[i]
		  }
		  params=getHashActual()
		  params["not"]=new Array()
		  if($("#tabla table tbody input[type='checkbox']:not(:checked)").length>0){
			 $("#check_all").prop("checked",false) 
		  }
		  if($("#tabla table tbody input[type='checkbox']:not(:checked)").length==0){
			 $("#check_all").prop("checked",true) 
		  }
		  $("#tabla table tbody input[type='checkbox']:not(:checked)").each(function(){
			  UR=$(this).attr("id").replace("check_", "")
			  params["not"].push(UR)
			  for (var i in datos) {
				if(datos[i].CapituloGasto){
				  	if(datos[i].UnidadResponsable==UR){
					  	delete datos[i]
				  	}else if(datos[i].CapituloGasto==UR){
					  	delete datos[i]
				  	}else if(datos[i].key==UR){
					  	delete datos[i]
				  	}
				}
			  }
		  })
		  datos=datos.filter(function (el) {
		  	return el != null;
		  });
		  
		  params["not"]=params["not"].join(",")
		  setHash(params)
		  
          var data = d3.nest().key(function(d) { return d.UnidadResponsable; }).key(function(d) { return d.CapituloGasto; }).entries(datos);
		  $("#chart svg").remove()
		  $("#chart .title").remove()
		  main({title: $("#versionesPresupuesto tr[data-id='"+visualizacion+"'] .nombrePresupuesto").text()+' '+$("#versionesPresupuesto tr[data-id='"+visualizacion+"'] span").text()}, {key: "⇤ Jalisco", values: data});
	  }

	  function text(text) {
	    text.selectAll("tspan")
	        .attr("x", function(d) { return x(d.x) + 6; })
	    text.attr("x", function(d) { return x(d.x) + 6; })
	        .attr("y", function(d) { return y(d.y) + 6; })
	        .style("opacity", function(d) { return this.getComputedTextLength() < x(d.x + d.dx) - x(d.x) ? 1 : 0.5; });
	  }
	
	  function text2(text) {
	    text.attr("x", function(d) { return x(d.x + d.dx) - this.getComputedTextLength() - 6; })
	        .attr("y", function(d) { return y(d.y + d.dy) - 6; })
	        .style("opacity", function(d) { return this.getComputedTextLength() < x(d.x + d.dx) - x(d.x) ? 1 : 0.5; });
	  }
	
	  function rect(rect) {
	    rect.attr("x", function(d) { return x(d.x); })
	        .attr("y", function(d) { return y(d.y); })
	        .attr("width", function(d) { return x(d.x + d.dx) - x(d.x); })
	        .attr("height", function(d) { return y(d.y + d.dy) - y(d.y); });
	  }
	
	  function name(d) {
	    return d.parent
	        ? name(d.parent) + " / " + d.key + " (" + formatNumber(d.value) + ")"
	        : d.key + " (" + formatNumber(d.value) + ")";
	  }
	}
	
    d3.json($("#versionesPresupuesto tr[data-id='"+visualizacion+"']").attr("data-url"), function(err, res) {
        if (!err) {
			$("#canvas .msg").remove()
            dataOriginal=res
            params=getHashActual()
            for (i = 0; i < dataOriginal.length; i++){
	            key=""
	            if($("#versionesPresupuesto tr[data-id='"+visualizacion+"']").attr("data-tipo")=="OGbyUP"){
		            key=dataOriginal[i].UnidadResponsable
	            }
	            if($("#versionesPresupuesto tr[data-id='"+visualizacion+"']").attr("data-tipo")=="URbyOG"){
		            key=dataOriginal[i].key
	            }
	            if($("#versionesPresupuesto tr[data-id='"+visualizacion+"']").attr("data-tipo")=="PPbyUR"){
		            key=dataOriginal[i].UnidadResponsable
	            }
	            if(!montos[key]){
		           montos[key]=0 
	            }
	            montos[key]=montos[key]+parseFloat(dataOriginal[i].value)
	            montoTotal=montoTotal+parseFloat(dataOriginal[i].value)
            }
            var data = d3.nest().key(function(d) { return d.UnidadResponsable; }).key(function(d) { return d.CapituloGasto; }).entries(res);
            main({title: $("#versionesPresupuesto tr[data-id='"+visualizacion+"'] .nombrePresupuesto").text()+' - '+$("#versionesPresupuesto tr[data-id='"+visualizacion+"'] span").text()}, {key: "⇤ Jalisco", values: data});
        }
    });
}