var ComponentsSelect2 = function() {

    var handleDemo = function() {

        $.fn.select2.defaults.set("theme", "bootstrap");
        $(".select2-provincia").select2({
            placeholder: "Todos las provincias",
            width: null
        });
        $(".select2-municipios").select2({
            placeholder: "Todos los municipios",
            width: null
        });
        $(".select2-productos").select2({
            placeholder: "Todos los productos",
            width: null
        });
        $(".select2-provincia").select2({
            placeholder: "Todos las provincias",
            width: null
        });
        $(".select2-provincia").select2({
            placeholder: "Todos las provincias",
            width: null
        });
        $(".select2-islas").select2({
            placeholder: "Todos las islas",
            width: null
        });
        $(".select2-operador").select2({
            placeholder: "Todos los tipos de operador",
            width: null
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            handleDemo();
        }
    };

}();

jQuery(document).ready(function() {
    ComponentsSelect2.init();
});
