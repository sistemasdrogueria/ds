

function Paginacioncar() {

    $('table.tablasearch').each(function () {


        var currentPage = 0;
        var numPerPage = 50;
        var $table = $(this);
        var rowCount = $('table.tablasearch tbody tr td.formcartcanttd').length;
        $table.bind('repaginate', function () {
            $table.find('tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
        });
        $table.trigger('repaginate');
        var numRows = $table.find('tbody tr').length;
        var numPages = Math.ceil(numRows / numPerPage);
        var $pager = $('<div class="page_cart1"></div>');


        var $anterior = $('<li class="prev disabled anterior"><a disabled "href="#"onclick="anterior();">Anterior</a></li>');
        var $case = $('<li class="prev"></li>');
        var $siguiente = $('<li class="prev siguiente"><a onclick="siguiente();" onsubmit="return false;">Siguiente></a></li>');
        var $total = $('<li class="pagination_count"><span>' + rowCount + ' Articulos</span></li>');
        var $ul = $('<ul id="uli" style="display: inline-flex;" class="pagination"></ul>');
        $anterior.appendTo($ul);


        for (var page = 0; page < numPages; page++) {
            var $linum = $('<div class="page-number" id=pag' + (page + 1) + '><a></a></div>').text(page + 1).bind('click', {
                newPage: page
            }, function (event) {
                currentPage = event.data['newPage'];
                $table.trigger('repaginate');

                $(this).addClass('active').siblings().removeClass('active');
            }).appendTo($ul).addClass('clickeable');
        }




        $siguiente.appendTo($ul);

        $total.appendTo($ul);
        $ul.appendTo($pager);
        $pager.insertAfter($table).find('div.page-number:first').addClass('active');



    });

}
function Paginacion() {

    $('form#formaddcart').each(function () {


        var currentPage = 0;
        var numPerPage = 200;
        var $table = $(this);
        var rowCount = $('form tbody tr td.formcartcanttd').length;
        $table.bind('repaginate', function () {
            $table.find('tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
        });
        $table.trigger('repaginate');
        var numRows = $table.find('tbody tr').length;
        var numPages = Math.ceil(numRows / numPerPage);
        var $pager = $('<div class="page_cart1"></div>');


        var $anterior = $('<li class="prev disabled anterior"><a disabled "href="#"onclick="anterior();">Anterior</a></li>');
        var $case = $('<li class="prev"></li>');
        var $siguiente = $('<li class="prev siguiente"><a onclick="siguiente();" onsubmit="return false;">Siguiente></a></li>');
        var $total = $('<li class="pagination_count"><span>' + rowCount + ' Articulos</span></li>');
        var $ul = $('<ul id="uli" style="display: inline-flex;" class="pagination"></ul>');
        $anterior.appendTo($ul);


        for (var page = 0; page < numPages; page++) {
            var $linum = $('<div class="page-number" id=pag' + (page + 1) + '><a></a></div>').text(page + 1).bind('click', {
                newPage: page
            }, function (event) {
                currentPage = event.data['newPage'];
                $table.trigger('repaginate');

                $(this).addClass('active').siblings().removeClass('active');
            }).appendTo($ul).addClass('clickeable');
        }




        $siguiente.appendTo($ul);

        $total.appendTo($ul);
        $ul.appendTo($pager);
        $pager.insertAfter($table).find('div.page-number:first').addClass('active');



    });

}
function Paginacioncarcar() {

    $('table.tablasearch').each(function () {


        var currentPage = 0;
        var numPerPage = 50;
        var $table = $(this);
        var rowCount = $('table.tablasearch tbody tr td.formcartcanttd1').length;
        $table.bind('repaginate', function () {
            $table.find('tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
        });
        $table.trigger('repaginate');
        var numRows = $table.find('tbody tr').length;
        var numPages = Math.ceil(numRows / numPerPage);
        var $pager = $('<div class="page_cart1"></div>');


        var $anterior = $('<li class="prev disabled anterior"><a disabled "href="#"onclick="anterior();">Anterior</a></li>');
        var $case = $('<li class="prev"></li>');
        var $siguiente = $('<li class="prev siguiente"><a onclick="siguiente();" onsubmit="return false;">Siguiente></a></li>');
        var $total = $('<li class="pagination_count"><span>' + rowCount + ' Articulos</span></li>');
        var $ul = $('<ul id="uli" style="display: inline-flex;" class="pagination"></ul>');
        $anterior.appendTo($ul);


        for (var page = 0; page < numPages; page++) {
            var $linum = $('<div class="page-number" id=pag' + (page + 1) + '><a></a></div>').text(page + 1).bind('click', {
                newPage: page
            }, function (event) {
                currentPage = event.data['newPage'];
                $table.trigger('repaginate');

                $(this).addClass('active').siblings().removeClass('active');
            }).appendTo($ul).addClass('clickeable');
        }




        $siguiente.appendTo($ul);

        $total.appendTo($ul);
        $ul.appendTo($pager);
        $pager.insertAfter($table).find('div.page-number:first').addClass('active');



    });

}

function siguiente() {

    var $divs = $(".page-number.clickeable").toArray().length;
    var regex = /(\d+)/g;
    const page = document.querySelector(".page-number.clickeable.active").getAttribute("id");
    pagenext = parseInt(page.match(regex)) + (1);
    if ($divs == pagenext) {
        $('.siguiente').addClass("disabled");
    }
    $('.page-number.clickeable#pag' + pagenext).click()
    $('.anterior').removeClass("disabled");


}

function anterior() {
    var $divs = $(".page-number.clickeable").toArray().length;
    var regex = /(\d+)/g;
    const page = document.querySelector(".page-number.clickeable.active").getAttribute("id");
    pagenext = parseInt(page.match(regex)) - (1);

    $('.siguiente').removeClass("disabled");
    $('.page-number.clickeable#pag' + pagenext).click()
    if (pagenext == 1) {
        $('.anterior').addClass("disabled");

    }


}


function sortdescripcion() {
    var tabla = document.querySelectorAll("tbody.ajuste tr");
    var keys = Object.keys(tabla);
    var terminosort = keys.sort(function(a, b) {
        return b - a;
    });

    for (var i = 0; i < keys.length; i++) {
        $('.ajuste').append(tabla[keys[i]]);

        //console.log( keys[i], tabla[ keys[i] ] );

    }
}


$('#stockk').click(function() {
    var status = $(this).attr('data-value');

    if (status == 1 ){
        sort(true, 'colstock1', 'vartable');
        $(this).attr('data-value', 2);
        console.log("true")
    
    } else {
        sort(false, 'colstock1', 'vartable');
        $(this).attr('data-value', 1);
        console.log("false")

    }
});
$('#pcdto').click(function() {
    var status = $(this).attr('data-value');

    if (status == 1 ){
        sort(true, 'colprecio1', 'vartable');
        $(this).attr('data-value', 2);
        console.log("true")
    
    } else {
        sort(false, 'colprecio1', 'vartable');
        $(this).attr('data-value', 1);
        console.log("false")

    }
});




                function sort(ascending, columnClassName, tableId) {
                    var regex = /(\d+)/g;
                    var tbody = document.getElementById(tableId).getElementsByTagName("tbody")[0];
                    var rows = tbody.getElementsByTagName("tr");

                    var unsorted = true;



                    while (unsorted) {
                        unsorted = false

                        for (var r = 0; r < rows.length - 1; r++) {
                            var row = rows[r];
                            var nextRow = rows[r + 1];

                            var value = row.getElementsByClassName(columnClassName)[0].innerHTML;
                            var nextValue = nextRow.getElementsByClassName(columnClassName)[0].innerHTML;
                            var numero = value.match(regex);
                            var numero1 = nextValue.match(regex);

                            const noTruncarDecimales = {
                                maximumFractionDigits: 2,
                                minimumFractionDigits: 2
                            };
                            value = numero.toLocaleString('es', noTruncarDecimales)
                            nextValue = numero1.toLocaleString('es', noTruncarDecimales)


                            value = value.replace('.', '');
                            value = value.replace(',', '');
                            
                            // in case a comma is used in float number

                            nextValue = nextValue.replace('.', '');
                            nextValue = nextValue.replace(',', '');

                            if (!isNaN(value)) {
                                value = value;
                                nextValue = nextValue;
                                
                            }


                            if (ascending ? value > nextValue : value < nextValue) {
                                tbody.insertBefore(nextRow, row);
                                unsorted = true;
                            }
                        }
                    }
                }


                function sortTable(table, col, reverse) {
                    var tb = table.tBodies[0], // use `<tbody>`para ignorar las filas  `<thead>` y `<tfoot>` 
                        tr = Array.prototype.slice.call(tb.rows, 0), // poner filas en una matriz
                        i;
                    reverse = -((+reverse) || -1);
                    tr = tr.sort(function (a, b) { // sort rows
                        return reverse // `-1 *` si quieres orden opuesto
                            * (a.cells[col].textContent.trim() //usando `.textContent.trim()` para la prueba
                                .localeCompare(b.cells[col].textContent.trim())
                            );
                    });
                    for(i = 0; i < tr.length; ++i) tb.appendChild(tr[i]); //agregar cada fila en orden
                }

                function makeSortable(table) {
                    var th = table.tHead, i;
                    th && (th = th.rows[0]) && (th = th.cells);
                    if (th) i = th.length;
                    else return; // if no `<thead>` then do nothing
                    while (--i >= 0) (function (i) {
                        var dir = 1;
                        th[i].addEventListener('click', function () {sortTable(table, i, (dir = 1 - dir))});
                    }(i));
                    console.log("usted no hizo");
                }

                function makeAllSortable(parent) {
                    parent = parent || document.body;
                    var t = parent.getElementsByTagName('table'), i = t.length;
                    while (--i >= 0) makeSortable(t[i]);
                }


             
	
               