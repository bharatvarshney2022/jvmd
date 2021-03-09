"use strict";
var KTDatatablesExtensionButtons = {
    init: function() {
        var t;
        $("#kt_datatable1").DataTable({
            responsive: !0,
            dom: "<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>\n\t\t\t<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
            buttons: ["print", "copyHtml5", "excelHtml5", "csvHtml5", "pdfHtml5"],
        }),
        t = $("#kt_datatable2").DataTable({
            responsive: !0,
            buttons: ["print", "copyHtml5", "excelHtml5", "csvHtml5", "pdfHtml5"],
            processing: !0,
            serverSide: !0,
        }),
        $("#export_print").on("click", (function(e) {
            e.preventDefault(),
            t.button(0).trigger()
        }
        )),
        $("#export_copy").on("click", (function(e) {
            e.preventDefault(),
            t.button(1).trigger()
        }
        )),
        $("#export_excel").on("click", (function(e) {
            e.preventDefault(),
            t.button(2).trigger()
        }
        )),
        $("#export_csv").on("click", (function(e) {
            e.preventDefault(),
            t.button(3).trigger()
        }
        )),
        $("#export_pdf").on("click", (function(e) {
            e.preventDefault(),
            t.button(4).trigger()
        }
        ))
    }
};
jQuery(document).ready((function() {
    KTDatatablesExtensionButtons.init()
}
));
