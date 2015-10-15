(function (a)
{
    var b = function ()
    {
        var f = this;
        var d = 1000;
        this.showTestMsgs = function (h, g)
        {
            a("<div/>").attr("id", "joommark_msg").prependTo("body").append('<div id="joommark_msgtitle">' + h + "</div>").append('<div id="joommark_msgtext">' + g + "</div>").css("margin-top", 0).animate({"margin-top": "-150px"}, 300, "linear")
        };
        this.dispatch = function (i) {
            //alert("1");
            var g = joommarkBaseURI + "index.php?option=com_joommark&format=json";
            //alert("1_");
            var h = {};
            //alert("2");
            h.task = "flow.display";
            //alert("3");
            h.nowpage = a(location).attr("href");
            //alert("4");
            h.initialize = i;
            //alert("5");
            a.ajax({url: g, data: h, type: "post", cache: false, dataType: "json", success: function (j, l, k) {
                    //alert("6");
                    if (j) {
                        d = 1000;
                        if (j.configparams)
                        {
                            d = 1000; //j.configparams.refresh * 1000;
                            //alert(j.configparams.refresh);
                        }
                        
                            setTimeout(function () {
                                f.dispatch()
                            }, d);
                    }
                }, error: function (k, l, j) {
                    //alert("8");
                }})

        }
    };


    window.JoommarkFlow = b;
    a(function () {
        var c = new JoommarkFlow();
        c.dispatch(true);
    });
})
        (jQuery);